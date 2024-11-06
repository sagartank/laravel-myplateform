<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class SelectCountry extends Component
{
    public $user;
    public $countries;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?User $user = null, $countries = null)
    {
        $this->user = $user;
        $this->countries = $countries ?? DB::table('countries')->select('id', 'name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select-country', [
            'countries'=> $this->countries,
        ]);
    }

    public function isSelected($option)
    {        
        return ($this->user ?? false) ? ($option == $this->user->country_id) : false;
    }
}
