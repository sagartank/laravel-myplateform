<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\GeneralMail;
use App\Models\Blog;
use App\Models\HowToWork;
use App\Models\Faq;
use App\Models\HomePartner;
use App\Models\HomeSlide;
use App\Models\HomeText;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Deviam\Bancard\Bancard;

class MarketingController extends Controller
{
    public function home()
    {
        if(!session()->get('locale')) {
            App::setLocale('es');
            session()->put('locale', 'es');
        }

        return view('marketing.home', [
            'homeSlides' => HomeSlide::active()->orderBy('step_number')->get(),
            'faqs' => Faq::with('type:id,name')->active()->get(),
            'blogs' => Blog::latest()->active()->take(3)->get(),
            'homePartners' => HomePartner::active()->orderBy('step_number')->get(),
            'homeText' => HomeText::first(),
            'howToWork' => HowToWork::first(),
        ]);
    }

    public function blog()
    {
        return view('marketing.blog');
    }

    public function ajaxLoadMore()
    {
        $perPage = 9;
        $pagination = true;

        $blogs = Blog::orderByDesc('id')
            ->when($pagination, function ($qry) use ($perPage) {
                return $qry->paginate($perPage);
            }, function ($qry) {
                return $qry->get();
            });

        $blogsHtml = view('marketing.ajax.load-blogs', [
            'blogs' => $blogs,
        ])->render();

        $response = [
            'success' => 1,
            'message' => __('Blogs loaded successfully'),
            'blogsHtml' => $blogsHtml,            
            'hasMorePages' => $blogs->hasMorePages(),
        ];
        return response()->json($response);
    }

    public function blogPost($slug)
    {
        $blog = Blog::where('slug', $slug)->with('author:id,name')->first();

        return view('marketing.blog-post', ['blog' => $blog]);
    }
    
    public function contactUsStore(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string'],
            // 'last_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'phone_number' => ['required', 'max:15'],
            // 'phone_number' => ['required', 'string', 'regex:/^([0-9\ \-\+\(\)]*)$/'],
            'message' => ['required', 'string'],
        ]);

        $email = $request->input('email');

        $content = "<table>
            <tbody>
                <tr>
                    <td>First Name:</td>
                    <td>" . $request->input('full_name') . "</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>" . $email . "</td>
                </tr>
                <tr>
                    <td>Phone Number:</td>
                    <td>" . $request->input('phone_number') . "</td>
                </tr>
                <tr>
                    <td>Message:</td>
                    <td>" . $request->input('message') . "</td>
                </tr>
            </tbody>
        </table>";

        try {
            Mail::to($email)->send(new GeneralMail('You have a new contact message!', $content, 'Admin'));

        } catch (\Throwable $th) {
            $response = [
                'status' => false,
                'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
            ];
            return response()->json($response);
        }

        $response = [
            'status' => true,
            'message' =>  __('Thanks for the messsage. We will get back to you soon!')
        ];
        return response()->json($response);
    }

    public function about()
    {
        return view('marketing.about',
        [
            'homeSlides' => HomeSlide::active()->orderBy('step_number')->get(),
            'howToWork' => HowToWork::first(),
        ]);
    }

    public function contactUsCreate()
    {
        return view('marketing.contact-us');
    }

    public function faq()
    {
        return view('marketing.faq',
        [
            'faqs' => Faq::with('type:id,name')->active()->get(),
        ]);
    }
}