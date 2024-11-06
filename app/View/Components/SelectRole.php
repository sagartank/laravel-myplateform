<?php

namespace App\View\Components;

use App\Models\Role;
use Illuminate\View\Component;

class SelectRole extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $user;
    public function __construct($user = null)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select-role', [
            'roles'=> Role::select('id', 'name', 'display_name')->active()->orderBy('display_name')->get(),
        ]);
    }

    public function isSelected($option)
    {
        return ($this->user ?? false) ? ($this->user->hasRole($option)) : false;
    }
}
