<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\DealsController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CounterOfferController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\ExploreOperationController;
use App\Http\Controllers\OfferedOperationsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Admin\OperationController as AdminOperationController;
use App\Http\Controllers\Admin\OperationProgressController as AdminOperationProgressController;
use App\Http\Controllers\Admin\OffersController as AdminOffersController;
use App\Http\Controllers\Admin\UserLevelController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DealsController as AdminDealsController;
use App\Http\Controllers\Admin\FaqTypeController;
use App\Http\Controllers\Admin\HomePartnerController;
use App\Http\Controllers\Admin\HomeSlideController;
use App\Http\Controllers\Admin\HomeTextController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\Admin\PayerissuerController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\ClaimsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Auth\PlansController;
use App\Http\Controllers\Admin\IssuerBankController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Auth\UserCompanyController;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerification as TestMailVerification;
use App\Http\Controllers\Admin\UserContractSingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserContractSingOtpController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Admin\HowToWorkMipoController;
use App\Http\Controllers\DhtmlController;
use App\Mail\SignContractOtp as MailSignContractOtp;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SignContractOtp as NotificationsSignContractOtp;
use App\Notifications\SignUp as  NotificationAdminSignUp;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MarketingController::class, 'home'])->name('marketing.home');
Route::get('/blog', [MarketingController::class, 'blog'])->name('blog');
Route::post('/blog/ajax-load-more', [MarketingController::class, 'ajaxLoadMore'])->name('blog.ajax-load-more');
Route::get('/blog/{slug}/post', [MarketingController::class, 'blogPost'])->name('blog.post');
Route::get('/about', [MarketingController::class, 'about'])->name('about');
Route::get('/faq', [MarketingController::class, 'faq'])->name('faq');
Route::get('/contact-us', [MarketingController::class, 'contactUsCreate'])->name('marketing.contact-us-create');
Route::post('/contact-us', [MarketingController::class, 'contactUsStore'])->name('marketing.contact-us-store');

// Route::get('/', function () {
//     return redirect('/login');
// });

Route::get('locale/{locale}', function ($locale){

    if (! in_array($locale, ['en', 'es'])) {
        abort(400);
    }

    if(Auth::check()){
        $id = Auth::user()->id;
        $user = \App\Models\User::find($id);
        $user->preferred_language = $locale;
        $user->save();
    }

    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::get('/secure-image/{path}', [FileController::class, 'secureImage'])->name('secure-image');
Route::get('/secure-pdf/{path}', [FileController::class, 'securePdf'])->name('secure-pdf');
Route::get('/secure-file/{path}', [FileController::class, 'secureFile'])->name('secure-file');

Route::get('/pdf', function () {
    set_time_limit(300); 
    // ini_set('max_execution_time', 0);
    // return view('pdf.user-activity-pdf');
    $pdf = Pdf::loadView('pdf.platform-activity-pdf');
    return $pdf->stream();
    // return $pdf->download('sample.pdf');
});

Route::get('/view', function () {
    // set_time_limit(300); 
    // ini_set('max_execution_time', 0);
    //  return view('dhtml.confrim-offer-contract');
    //  return view('mail_template.authorized_otp');
    // $pdf = Pdf::loadView('pdf.operation-detail');
    // return $pdf->stream();
    // return $pdf->download('sample.pdf');
});

Route::get('/shepherd', function () {
    return view('shepherd');
});

Route::prefix('/myplatform-admin')->name('admin.')->group(function () {

    Route::middleware(['auth', 'is_admin'])->group(function () {

        /*  Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard'); 
        */

        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::get('/notificaiton-list', [AdminDashboardController::class, 'notificaitonList'])->name('notificaiton-list');
        Route::post('/ajax-dashboard-admin',  [AdminDashboardController::class, 'ajaxDashboard'])->name('ajax-dashboard-admin');
        Route::post('/dashboard-daily-report', [AdminDashboardController::class, 'ExportDailyReport'])->name('dashboard.export-daily-report');

        // blog module
        Route::resource('/blogs', BlogController::class)->except('show', 'destroy');
        Route::post('/blogs/{slug}/forcedelete', [BlogController::class, 'forceDelete'])->name('blogs.forcedelete');

        // faq type module
        Route::resource('/faq-types', FaqTypeController::class)->except('show', 'destroy');
        Route::post('/faq-types/{slug}/forcedelete', [FaqTypeController::class, 'forceDelete'])->name('faq-types.forcedelete');

        // faq module
        Route::resource('/faqs', FaqController::class)->except('show', 'destroy');
        Route::post('/faqs/{slug}/forcedelete', [FaqController::class, 'forceDelete'])->name('faqs.forcedelete');

        // home text module
        Route::resource('/home-texts', HomeTextController::class)->except('create', 'store', 'edit', 'show', 'destroy');
        Route::resource('/how-to-work', HowToWorkMipoController::class)->except('create', 'store', 'edit', 'show', 'destroy');

        // home slide module
        Route::resource('/home-slides', HomeSlideController::class)->except('show', 'destroy');
        Route::post('/home-slides/{slug}/forcedelete', [HomeSlideController::class, 'forceDelete'])->name('home-slides.forcedelete');
        Route::post('/home-slides/ajax-update-step-number', [HomeSlideController::class, 'ajaxUpdateStepNumber'])->name('home-slides.ajax-update-step-number');

        // home partner module
        Route::resource('/home-partners', HomePartnerController::class)->except('show', 'destroy');
        Route::post('/home-partners/{slug}/forcedelete', [HomePartnerController::class, 'forceDelete'])->name('home-partners.forcedelete');
        Route::post('/home-partners/ajax-update-step-number', [HomePartnerController::class, 'ajaxUpdateStepNumber'])->name('home-partners.ajax-update-step-number');

        // social media module
        Route::resource('/social-media', SocialMediaController::class)->except('show', 'destroy');
        Route::post('/social-media/{slug}/forcedelete', [SocialMediaController::class, 'forceDelete'])->name('social-media.forcedelete');
        Route::post('/social-media/ajax-update-step-number', [SocialMediaController::class, 'ajaxUpdateStepNumber'])->name('social-media.ajax-update-step-number');

        // role module
        Route::resource('/roles', RoleController::class)->except('show');

        // permission module
        Route::resource('/permissions', PermissionController::class)->except('show');

        // user module
        Route::resource('/users', UserController::class);
        Route::post('/users/{slug}/forcedelete', [UserController::class, 'forceDelete'])->name('users.forcedelete');
        Route::post('/users/{slug}/delete', [UserController::class, 'destroy'])->name('users.delete');
        Route::post('/users/ajax-load-admin', [UserController::class, 'ajaxLoadAdminData'])->name('users.ajax-load-admin');
        Route::post('/users/ajax-load-user', [UserController::class, 'ajaxLoadUserData'])->name('users.ajax-load-user');
        Route::post('/users/ajax-approve-user', [UserController::class, 'ajaxApproveUser'])->name('users.ajax-approve-user');
        Route::post('/users/ajax-reject-user', [UserController::class, 'ajaxRejectUser'])->name('users.ajax-reject-user');
        Route::post('/users/ajax-export', [UserController::class, 'Export'])->name('users.ajax-export-users');
        Route::get('/users/ajax-send-otp-user-address/{slug}', [UserController::class, 'ajaxSendOtpUserAddress'])->name('users.ajax-send-otp-user-address');
        Route::get('/users/ajax-kyc-address/{slug}/{pdf_type}', [UserController::class, 'ajaxKycUserAddress'])->name('users.ajax-kyc-address');
        Route::post('/users/ajax-active-inactive-user', [UserController::class, 'ajaxActiveInactiveUser'])->name('users.ajax-active-inactive-user');
        Route::get('/users/login-as-user/{slug}', [UserController::class, 'loginAsUser'])->name('users.login-as-user');
        Route::get('/users/get-update-plan-modal/{slug}', [UserController::class, 'getUserPlanModal'])->name('users.update-plan-modal');
        Route::post('/users/update-plan/{slug}', [UserController::class, 'updateUserPlan'])->name('users.update-plan');
        Route::get('/users/send-reset-password-link/{slug}', [UserController::class, 'ajaxSendResetPwdLink'])->name('users.send-reset-password-link');
        Route::post('/users/create-company-account/{slug}', [UserController::class, 'createCompanyAccount'])->name('users.create-company-account');
        Route::post('/users/delete-image-document/{id}', [UserController::class, 'ajaxDeleteImage'])->name('users.ajax-delete-image-document');
        
        Route::resource('/user-level', UserLevelController::class)->except('show');
        Route::post('/user-level/{slug}/forcedelete', [UserLevelController::class, 'forceDelete'])->name('user-level.forcedelete');

        Route::get('/user-companies', [UserCompanyController::class, 'companyIndex'])->name('users.company');
        Route::post('/users/ajax-load-user-companies', [UserCompanyController::class, 'ajaxLoadUserComapnyData'])->name('users.ajax-load-user-companies');
        
        //operations
        Route::resource('/operations', AdminOperationController::class)->except('create', 'store');
        Route::post('/operations/{slug}/delete', [AdminOperationController::class, 'destroy'])->name('operations.delete');
        Route::post('/operations/ajax-load-operations-data', [AdminOperationController::class, 'ajaxLoadOperationsData'])->name('operations.ajax-load-operations-data');
        Route::get('/operations/ajax-delete-document/{slug}', [AdminOperationController::class, 'ajaxDeleteDocument'])->name('operations.ajax-delete-document');
        Route::get('/operations/ajax-delete-attachments/{slug}', [AdminOperationController::class, 'ajaxDeleteAttachments'])->name('operations.ajax-delete-attachments');
        Route::post('/operations/ajax-export', [AdminOperationController::class, 'fileExport'])->name('operations.ajax-export-operations');
        Route::post('/operations/ajax-import', [AdminOperationController::class, 'fileImport'])->name('operations.ajax-import-operations');
        Route::post('/operations/ajax-delete-all', [AdminOperationController::class, 'ajaxDeleteAll'])->name('operations.ajax-delete-all');
        Route::get('/operations/ajax-delete-process-status-file/{id}/{clm_name}', [AdminOperationController::class, 'ajaxDeleteProcessStatusFile'])->name('operations.ajax-delete-process-status-file');
        Route::get('/operations/ajax-delete-admin-staff-attachments-file/{id}', [AdminOperationController::class, 'ajaxDeleteAdminStaffAttachmentsFile'])->name('operations.ajax-delete-admin-staff-attachments-file');
        Route::get('/operations/export/{slug}', [AdminOperationController::class, 'exportOperationDetail'])->name('operations.export-operations-detail');
        
        //progress
        Route::resource('/progress', AdminOperationProgressController::class)->except('show');
        Route::post('/ajax-progress-sortable',[ AdminOperationProgressController::class, 'ajaxProgresSortableUpdate'])->name('progress.ajax-sortable');
        Route::post('/progress/{slug}/forcedelete', [AdminOperationProgressController::class, 'forceDelete'])->name('progress.forcedelete');
        
        //offers
        Route::resource('/offers', AdminOffersController::class)->except('create', 'store', 'show', 'edit', 'update');
        Route::post('/offers/ajax-load-offers-data', [AdminOffersController::class, 'ajaxLoadOffersData'])->name('offers.ajax-load-offers-data');
        Route::post('/offers/ajax-export', [AdminOffersController::class, 'Export'])->name('offers.ajax-export-offers');
        
        //settings
        Route::resource('/settings', SettingsController::class)->only('index', 'update');
        Route::get('/invite', [SettingsController::class, 'invite'])->name('settings.invite');
        Route::post('/send-invite', [SettingsController::class, 'sendInviteEmail'])->name('settings.send-invite');
        
        //companies types
        Route::resource('/companies', CompanyController::class)->except('show');
        Route::post('/companies/{slug}/forcedelete', [CompanyController::class, 'forceDelete'])->name('companies.forcedelete');
        
        //deals
        Route::resource('/deals', AdminDealsController::class)->except('create', 'store', 'show', 'edit', 'update');
        Route::post('/deals/ajax-load-deals-data', [AdminDealsController::class, 'ajaxLoadDealsData'])->name('deals.ajax-load-deals-data');
        Route::get('/deals/details/{slug}', [AdminDealsController::class, 'Details'])->name('deals.details');
        Route::post('/deals/ajax-deals-change-status', [AdminDealsController::class, 'dealsChangeStatus'])->name('deals.ajax-deals-change-status');
        Route::post('/deals/ajax-export', [AdminDealsController::class, 'Export'])->name('deals.ajax-export-deals');
        Route::post('/deals/dispute-resolve', [AdminDealsController::class, 'disputeResolve'])->name('deals.dispute-resolve');
        Route::post('/deals/create-seog/{offer_slug}', [AdminDealsController::class, 'uploadDealsSeog'])->name('deals.create-seog');
        Route::get('/deals/download-seog/{offer_slug}', [AdminDealsController::class, 'seogFileDownload'])->name('deals.download-seog');
        Route::post('/deals/ajax-deals-flow-change-status', [AdminDealsController::class, 'dealsFlowChangeStatus'])->name('deals.ajax-deals-flow-change-status');
        Route::post('/deals/private-note', [AdminDealsController::class, 'privateNote'])->name('deals.private-note-crud');
        Route::post('/deals/private-note-list', [AdminDealsController::class, 'privateNoteList'])->name('deals.private-note-list');

        // payer-issuer
        Route::resource('/payer-issuer', PayerissuerController::class)->except('show');
        Route::post('/payer-issuer/{slug}/forcedelete', [PayerissuerController::class, 'forceDelete'])->name('payer-issuer.forcedelete');
        Route::post('/payer-issuer/{slug}/delete', [PayerissuerController::class, 'destroy'])->name('payer-issuer.delete');
        Route::get('/payer-issuer/ajax-delete-issuer-attach-image/{slug}', [PayerissuerController::class, 'ajaxDeleteIssuerAttachImage'])->name('payer-issuer.ajax-delete-issuer-attach-image');
        // plan module
        Route::resource('/plans', PlanController::class)->except('show');

        Route::resource('/issuer-bank', IssuerBankController::class)->except('show');
        Route::post('/issuer-bank/{slug}/forcedelete', [IssuerBankController::class, 'forceDelete'])->name('issuer-bank.forcedelete');

        Route::resource('/pages', PagesController::class)->except('show');
        Route::post('/pages/{slug}/forcedelete', [PagesController::class, 'forceDelete'])->name('pages.forcedelete');
        
        Route::resource('/logs', LogController::class)->only('index');
        
        Route::get('/relation-graph', [AdminDashboardController::class, 'userGraphIndex'])->name('relation-graph');
        Route::get('/ajax-user-search', [AdminDashboardController::class, 'userDataAjaxSearch'])->name('ajax-user-search');
        //Route::get('/user-relation-chart', [AdminDashboardController::class, 'userRelationChartData'])->name('user-relation-chart');
        Route::any('/user-relation-chart', [AdminDashboardController::class, 'userRelationChartData'])->name('user-relation-chart');
        Route::post('/ajax-get-user-connectivity-chart', [AdminDashboardController::class, 'getUserConnectivityChartData'])->name('ajax-get-user-connectivity-chart');
        
        Route::get('/activity-logs', [ActivityLogController::class,'index'])->name('activity-log.index');
        Route::get('/activity-logs/{id}/show', [ActivityLogController::class,'show'])->name('admin.activity-log.show');
        Route::post('/activity-logs/ajax-load-activity-log-data', [ActivityLogController::class, 'ajaxLoadActivityLogData'])->name('activity-logs.ajax-load-activity-log-data');
        Route::post('/activity-logs/ajax-show-activity-log', [ActivityLogController::class, 'ajaxShowActivityLog'])->name('activity-logs.ajax-show-activity-log');
        //Route::post('/activity-logs/ajax-show-activity-log', [ActivityLogController::class, 'ajaxLoadActivityLogData'])->name('activity-logs.ajax-show-activity-log');
        Route::get('/activity-logs/{id}/export', [ActivityLogController::class,'export'])->name('activity-log.export');

        Route::resource('/user-contract-sing', UserContractSingController::class)->only(['index', 'store']);
        Route::post('/user-contract-sing-delete/{id}', [UserContractSingController::class, 'delete'])->name('user-contract-sing.delete');
    });
    
});

Route::middleware(['auth', 'is_not_admin'])->group(function () {
    
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('register_complete_approved_by_admin');
    Route::post('/dashboard-type', [DashboardController::class, 'ajaxDashboard'])->name('dashboard.ajax-type');
    
    Route::controller(DashboardController::class)->name('dashboard.borrower.')->prefix('dashboard-borrower')->group(function () {
        Route::get('/finalized-deals/{date_range}/{currency_type}', 'finalizedDealsDetails')->name('finalized-deals');
        Route::post('/ajax-finalized-deals', 'ajaxFinalizedDealsDetails')->name('ajax-finalized-deals');
        Route::get('/finalized-operations/{date_range}/{currency_type}', 'finalizedOperationsDetails')->name('finalized-operations');
        Route::post('/ajax-finalized-operations', 'ajaxFinalizedOperationsDetails')->name('ajax-finalized-operations');
    });

    Route::controller(DashboardController::class)->name('dashboard.investor.')->prefix('dashboard-investor')->group(function () {
        Route::get('/incomes-profit-loss/{date_range}/{currency_type}', 'incomesProiftLossDetails')->name('incomes-profit-loss');
        Route::post('/ajax-incomes-profit-loss', 'ajaxIncomesProiftLossDetails')->name('ajax-incomes-profit-loss');
        Route::get('/risk-managment/{date_range}/{currency_type}', 'riskManagmentDetails')->name('risk-managment');
        Route::post('/ajax-risk-managment', 'ajaxRiskManagmentDetails')->name('ajax-risk-managment');
    });

    Route::resource('/operations', OperationController::class)->except('show');
    Route::post('/operations/ajax-delete-authorized-personnel-signature', [OperationController::class, 'ajaxDeleteAuthorizedPersonnelSignature'])->name('operations.ajax-delete-authorized-personnel-signature');
    Route::post('/operations/ajax-delete-document-file', [OperationController::class, 'ajaxDeleteDocumentFile'])->name('operations.ajax-delete-document-file');
    Route::post('/operations/ajax-delete-supporting-attachment-file', [OperationController::class, 'ajaxDeleteSupportingAttachmentFile'])->name('operations.ajax-delete-supporting-attachment-file');
    Route::post('/operations/ajax-update-document-display-name', [OperationController::class, 'ajaxUpdateDocumentDisplayName'])->name('operations.ajax-update-document-display-name');
    Route::post('/operations/ajax-update-supporting-attachment-display-name', [OperationController::class, 'ajaxUpdateSupportingAttachmentDisplayName'])->name('operations.ajax-update-supporting-attachment-display-name');
    Route::get('/operations/ajax-get-tags-list', [OperationController::class, 'ajaxGetTagsList'])->name('operations.ajax-get-tags-list');
    Route::get('/operations/bulk-upload-form', [OperationController::class, 'bulkUpload'])->name('operations.bulk-upload-create');

    Route::post('/operations/ajax-load-more-operations', [OperationController::class, 'ajaxLoadMoreOperations'])->name('operations.ajax-load-more-operations');
    Route::post('/operations/ajax-load-more-offers-list', [OperationController::class, 'ajaxLoadMoreOffersList'])->name('operations.ajax-load-more-offers-list');
    Route::post('/operations/ajax-operations-by-offer', [OperationController::class, 'ajaxOperationsByOffer'])->name('operations.ajax-operations-by-offer');
    Route::post('/operations/ajax-operations-high-low-amount', [OperationController::class, 'ajaxOperationsHighLowAmount'])->name('operations.ajax-operations-high-low-amount');
    Route::post('/operations/ajax-send-single-counter-page', [OperationController::class, 'ajaxSingleOfferCounterPage'])->name('operations.ajax-send-single-counter-page');
    Route::post('/operations/ajax-search-operations-tags', [OperationController::class, 'ajaxgetTags'])->name('operations.ajax-search-operations-tags');
    Route::get('/operations/details/{slug}', [OperationController::class, 'operationDetail'])->name('operations.details');
    Route::get('/operations/file-export-download/{slug}', [OperationController::class, 'ajaxFileExport'])->name('operations.file-export');
    Route::post('/operations/ajax-delete-multiple', [OperationController::class, 'ajaxDeleteMultipleOperation'])->name('operations.ajax-delete-multiple');
    Route::post('/operations/ajax-change-status', [OperationController::class, 'ajaxUpdateStatusOperation'])->name('operations.ajax-change-status');
    Route::post('/operations/ajax-load-more-offer-contract-list', [OperationController::class, 'ajaxLoadMoreOffersContractList'])->name('operations.ajax-load-more-offers-contract-list');
    Route::post('/operations/bulk-upload', [OperationController::class, 'bulkUploadOperations'])->name('operations.bulk-upload');
    Route::post('/operations/ajax-add-payer-issuer', [OperationController::class, 'ajaxAddPayerIssuer'])->name('operations.ajax-add-payer-issuer');
    Route::get('/operations/ajax-payer-issuer-list', [OperationController::class, 'ajaxPayerIssuerList'])->name('operations.ajax-payer-issuer-list');
    
    Route::resource('/profile', UserProfileController::class)->only('index', 'update', 'store');
    Route::get('/profile-for-seller/{slug}', [UserProfileController::class, 'publicProfileSeller'])->name('profile.public-seller');
    Route::get('/profile-for-company/{slug}', [UserProfileController::class, 'publicProfilePayer'])->name('profile.public-payer-profile');
    Route::post('/profile/ajax-enterprise-by-user-list', [UserProfileController::class, 'ajaxEnterpriseByUserList'])->name('profile.ajax-enterprise-by-user-list');
    Route::post('/profile/ajax-enterprise-by-user-delete', [UserProfileController::class, 'ajaxEnterpriseByUserDelete'])->name('profile.ajax-enterprise-by-user-delete');
    Route::post('/profile-for-seller-pdf-download', [UserProfileController::class, 'publicProfileSellerPdfExport'])->name('profile.public-seller-pdf');
    Route::post('/profile-for-company-pdf-download', [UserProfileController::class, 'publicProfilePayerPdfExport'])->name('profile.public-payer-profile-pdf');
    Route::post('/profile/ajax-otp-verify-address', [UserProfileController::class, 'ajaxOtpVerifyUserAddress'])->name('profile.ajax-otp-verify-address');
    Route::post('/profile/ajax-save-update-bank-detail', [UserProfileController::class, 'ajaxSaveUpdateUserBank'])->name('profile.ajax-save-update-bank-detail');
    Route::post('/profile/ajax-bank-detail-list', [UserProfileController::class, 'ajaxUserBankList'])->name('profile.ajax-bank-list');
    Route::post('/profile/ajax-bank-delete', [UserProfileController::class, 'ajaxUserBankDelete'])->name('profile.ajax-bank-delete');
    
    Route::post('/profile/ajax-invite-friend', [UserProfileController::class, 'inviteFriend'])->name('profile.ajax-invite-friend');
    Route::post('/profile/ajax-user-profile-setting', [UserProfileController::class, 'userProfileSetting'])->name('profile.ajax-user-profile-setting');
    Route::post('/profile/ajax-search-seller', [UserProfileController::class, 'ajaxSellerList'])->name('profile.ajax-search-seller');
    Route::post('/profile/ajax-search-buyer', [UserProfileController::class, 'ajaxBuyerList'])->name('profile.ajax-search-buyer');
    Route::post('/profile/ajax-user-prfile/{slug}', [UserProfileController::class, 'ajaxUserFileUpload'])->name('profile.ajax-file-upload');
    Route::post('/profile/ajax-favorite-prfile-list', [UserProfileController::class, 'ajaxFavoritePrfileList'])->name('profile.ajax-favorite-prfile-list');
    Route::post('/profile/ajax-favorite-prfile-delete', [UserProfileController::class, 'ajaxFavoritePrfileDelete'])->name('profile.ajax-favorite-prfile-delete');
    
    Route::resource('/explore-operations', ExploreOperationController::class);
    Route::post('/explore-operations/ajax-load-more-explore-operations', [ExploreOperationController::class, 'ajaxLoadMoreExploreOperations'])->name('explore-operations.ajax-load-more-explore-operations');
    Route::post('/explore-operations/ajax-get-explore-operations-group', [ExploreOperationController::class, 'ajaxGetExploreOperationsGroup'])->name('explore-operations.ajax-get-explore-operations-group');
    Route::post('/explore-operations/ajax-save-group-offer', [ExploreOperationController::class, 'ajaxSaveGroupOffer'])->name('explore-operations.ajax-save-group-offer');
    Route::get('/explore-operations/details/{slug}', [ExploreOperationController::class, 'exploreOperationDetail'])->name('explore-operations.details');
    
    Route::post('/counter-offer/ajax-save-counter-offer', [CounterOfferController::class, 'ajaxSaveCounterOffer'])->name('counter-offer.ajax-save-counter-offer');
    Route::post('/counter-offer/ajax-save-offer-status', [CounterOfferController::class, 'ajaxSaveOfferStatus'])->name('counter-offer.ajax-save-offer-status');
    Route::post('/counter-offer/ajax-confirm-offer-pdf', [CounterOfferController::class, 'ajaxConfirmOfferPdf'])->name('counter-offer.ajax-confirm-offer-pdf');
    Route::post('/counter-offer/ajax-confirm-offer-save', [CounterOfferController::class, 'ajaxConfirmOfferSave'])->name('counter-offer.ajax-confirm-offer-save');

    Route::resource('/offered-operations', OfferedOperationsController::class);
    Route::post('/offered-operations/ajax-load-more-offered-operations', [OfferedOperationsController::class, 'ajaxLoadMoreOfferedOperationsList'])->name('offered-operations.ajax-load-more-offered-operations');
    Route::post('/offered-operations/ajax-update-offer', [OfferedOperationsController::class, 'ajaxUpdateOffer'])->name('offered-operations.ajax-update-offer');
    Route::post('/offered-list/ajax-offer-list', [OfferedOperationsController::class, 'ajaxOfferIdByList'])->name('offered-operations.ajax-offers-id-list');
    Route::post('/offered-by-id/ajax-offer-by-id', [OfferedOperationsController::class, 'ajaxOfferById'])->name('offered-operations.ajax-offers-by-id');
    
    Route::resource('/deals', DealsController::class)->except('index');;
    Route::get('/deals/{user_type?}/{currency_type?}', [DealsController::class, 'index'])->name('deals.index');
    Route::post('/deals/ajax-deals-list-buyer', [DealsController::class, 'ajaxDealsListBuyer'])->name('deals.ajax-deals-list-buyer');
    Route::post('/deals/ajax-deals-list-seller', [DealsController::class, 'ajaxDealsListSeller'])->name('deals.ajax-deals-list-seller');
    Route::post('/deals/ajax-deals-list-seller', [DealsController::class, 'ajaxDealsListSeller'])->name('deals.ajax-deals-list-seller');
    Route::get('/deals/details/{slug}/{type}', [DealsController::class, 'dealsDetails'])->name('deals.details')->whereIn('type', ['seller', 'buyer']);;
    Route::post('/deals/ajax-create-disputes/{slug}', [DealsController::class, 'createDisputes'])->name('deals.ajax-create-disputes');
    Route::post('/deals/ajax-create-cashed/{slug}', [DealsController::class, 'createCashed'])->name('deals.ajax-create-cashed');
    Route::post('/deals/ajax-file-upload', [DealsController::class, 'createFileUpload'])->name('deals.ajax-file-upload');
    Route::post('/deals/ajax-private-note', [DealsController::class, 'ajaxPrivateNote'])->name('deals.ajax-private-note-crud');
    Route::post('/deals/ajax-private-note-list', [DealsController::class, 'ajaxPrivateNoteList'])->name('deals.ajax-private-note-list');
    Route::post('/deals/ajax-user-document-list', [DealsController::class, 'ajaxDealsDocumentList'])->name('deals.ajax-user-document-list');
    Route::post('/deals/ajax-multiple-feedback/{slug}', [DealsController::class, 'ajaxMultipleFeedback'])->name('deals.ajax-multiple-feedback');
    Route::post('/deals/ajax-create-multiple-feedback/{slug}', [DealsController::class, 'ajaxCreateMultipleFeedback'])->name('deals.ajax-create-multiple-feedback');

    Route::resource('/rating', RatingController::class);
    Route::resource('/favourite', FavouriteController::class);
    Route::resource('/suggestion', SuggestionController::class);
    Route::resource('/claims', ClaimsController::class);
    Route::resource('/notifications', NotificationController::class);
    Route::get('/notifications-mark-as-read', [NotificationController::class, 'notificationsAllRead'])->name('notifications-all-read');

    Route::get('/user-plan/{slug}/checkout', [PlansController::class, 'userPlanCheckout'])->name('user-plan.checkout');
    Route::get('/user-plan/{slug}/success', [PlansController::class, 'userPlanPurchaseSuccess'])->name('user-plan.purchase-success');
    //Get role modal
    Route::get('/role/ajax-get-modal', [UserProfileController::class, 'ajaxGetRoleModal'])->name('role.get-modal');
    Route::post('/role/ajax-store', [UserProfileController::class, 'ajaxStoreRole'])->name('role.ajax-store');
    Route::post('/role/ajax-role-list', [UserProfileController::class, 'ajaxByRoleList'])->name('role.ajax-role-list');
    Route::get('/role/ajax-role-edit/{id}', [UserProfileController::class, 'ajaxEditRole'])->name('role.ajax-edit');
    Route::post('/role/ajax-role-update/{id}', [UserProfileController::class, 'ajaxUpdateRole'])->name('role.ajax-update');
    Route::post('/role/ajax-role-delete', [UserProfileController::class, 'ajaxUserRoleDelete'])->name('profile.ajax-role-delete');

    Route::get('/users/back-to-superadmin-login', [UserController::class, 'backToSuperAdminLogin'])->name('users.back-to-superadmin-login');
    Route::get('/users/login-as-website-user/{slug}', [UserController::class, 'loginAsWebsiteUser'])->name('users.login-as-website-user');
    Route::get('/users/back-to-website-login', [UserController::class, 'backToWebsiteLogin'])->name('users.back-to-website-login');

    //For payment
    Route::any('/bcpg-return/{shop_process_id}/result', [PaymentController::class, 'paymentReturn'])->name('users.bcpg-return');
    Route::any('/bcpg-cancel/{shop_process_id}/result', [PaymentController::class, 'paymentCancel'])->name('users.bcpg-cancel');
    Route::any('/bcpg-card/{shop_process_id}/result', [PaymentController::class, 'paymentCard'])->name('users.bcpg-card');

    //For deals payment
    Route::get('/deals-payment/{slug}/{step_id}/payment', [DealsController::class, 'dealsPaymentCheckout'])->name('deals.payment');
    Route::get('/deals-payment/{slug}/{step_id}/mipo-commission-payment', [DealsController::class, 'dealsMipoCommissionPaymentCheckout'])->name('deals.mipo-commission-payment');

    Route::post('/contract-sing-otp-verify/{id}', [UserContractSingOtpController::class, 'update'])->name('contract-sing-otp.otp-verify-update');
    Route::post('/contract-sing-otp-resend/{id}', [UserContractSingOtpController::class, 'resendOTP'])->name('contract-sing-otp.otp-resend');

    // CommonController
    Route::post('/search-user', [CommonController::class, 'ajaxSearchUser'])->name('ajax.search-user');
    Route::post('/search-company', [CommonController::class, 'ajaxSearchCompany'])->name('ajax.search-company');
    Route::post('/search-bank', [CommonController::class, 'ajaxSearchBank'])->name('ajax.search-bank');

    // ExportController
    Route::get('/explore-operation-detail/{slug}', [ExportController::class, 'exploreOperationDetail'])->name('export.explore-operation-detail');

    Route::resource('/dhtml', DhtmlController::class);
});

require __DIR__.'/auth.php';

Route::get('/qrcode-with-image', [QrCodeController::class, 'createQrCodeImage'])->name('qrcode-with-image');
Route::get('/deals-scane-qrcode/{slug}/{user_type}/{step_id}', [QrCodeController::class, 'dealsScaneQrcode'])->name('deals-scane-qrcode');

Route::get('/deals-tracking/{offer_id}', function($offer_id){
    
    $update = \App\Models\DealsTracking::TrackingAdd($offer_id);
    $delete = \App\Models\OperationsLogs::where('offer_id', $offer_id)->delete();
    dd($update, $delete);
});

Route::get('/privacy-policy', function () {
        $privacy_policy = \App\Models\Page::where('name','privacy-policy')->where('default_page', 'Yes')->first();
        return view('privacy-policy', compact('privacy_policy'));
})->name('privacy-policy'); 


Route::get('/test-mail', function () {
    // ini_set('max_execution_time', 0);
    try {
        // return view('errors.404');
        $otp = '99875';
        $user_obj = app('common')->getUserEmail(2);
        $admin_obj = app('common')->getUserDetailsRoleBy(1);
        Notification::send($user_obj, new NotificationAdminSignUp($user_obj));
        // Notification::send($user_obj, new NotificationsSignContractOtp(app()->getLocale(), $otp, 'user contract'));
        // $res = Mail::to('sagartank.w3nuts@gmail.com')->send(new MailSignContractOtp($otp));
        // $res = Mail::to('sagartank.w3nuts@gmail.com')->send(new TestMailVerification($otp));
        
        $httphost = request()->getHttpHost();
        $host = request()->getHost();
        dd('Success', $httphost,  $host);

    } catch (\Throwable $th) {
        dd('Error ',$th);
    }
});