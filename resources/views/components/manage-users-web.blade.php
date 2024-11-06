@props(['roles'])
<div class="protabdetail">
    <div class="protab_outerbox">
        <div class="manage_userbox">
            <div class="titlebox">
                <h3 class="text-20-semibold">{!! __('Users') !!}</h3>
                <div class="newuserbtn">
                    <a href="javascript:;" class="text-16-medium evt_user_modal_open" data-action="Add" data-bank-object="" data-form-name="#addsubUserForm" data-modal-name="#add_new_user"><i><img src="{{ asset('images/mipo/payplus.svg') }}" alt="no-image"></i>{!! __('New User') !!}</a>
                </div>
            </div>
        </div>

        <div id="ajax_enterprise_by_user_list">
            {{-- <div class="user_Table">
                <table>
                    <thead>
                        <tr class="forbg">
                            <th class="text-14-medium">{!! __('Name') !!}</th>
                            <th class="text-14-medium">{!! __('Action') !!}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-12-medium">
                                <div class="user_namebox">
                                    <div class="imgbox"><img src="{{ asset('images/mipo/usericon1.png') }}" alt="no-image"></div>
                                    <p class="text-14-medium">John Doe</p>
                                </div>
                            </td>
                            <td class="text-12-medium">
                                <div class="actionbtnbox">
                                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#new_user"><i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i><span class="text-12-medium edit">{!! __('Edit') !!}</span></a>
                                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#udelete_confirm"><i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i><span class="text-12-medium delete">{!! __('Delete') !!}</span></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-12-medium">
                                <div class="user_namebox">
                                    <div class="imgbox"><img src="{{ asset('images/mipo/usericon2.png') }}" alt="no-image"></div>
                                    <p class="text-14-medium">John Doe</p>
                                </div>
                            </td>
                            <td class="text-12-medium">
                                <div class="actionbtnbox">
                                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#userEdit"><i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i><span class="text-12-medium edit">{!! __('Edit') !!}</span></a>
                                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#udelete_confirm"><i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i><span class="text-12-medium delete">{!! __('Delete') !!}</span></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-12-medium">
                                <div class="user_namebox">
                                    <div class="imgbox"><img src="{{ asset('images/mipo/usericon3.png') }}" alt="no-image"></div>
                                    <p class="text-14-medium">John Doe</p>
                                </div>
                            </td>
                            <td class="text-12-medium">
                                <div class="actionbtnbox">
                                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#userEdit"><i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i><span class="text-12-medium edit">{!! __('Edit') !!}</span></a>
                                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#udelete_confirm"><i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i><span class="text-12-medium delete">{!! __('Delete') !!}</span></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-12-medium">
                                <div class="user_namebox">
                                    <div class="imgbox"><img src="{{ asset('images/mipo/usericon4.png') }}" alt="no-image"></div>
                                    <p class="text-14-medium">John Doe</p>
                                </div>
                            </td>
                            <td class="text-12-medium">
                                <div class="actionbtnbox">
                                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#userEdit"><i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i><span class="text-12-medium edit">{!! __('Edit') !!}</span></a>
                                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#udelete_confirm"><i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i><span class="text-12-medium delete">{!! __('Delete') !!}</span></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-12-medium">
                                <div class="user_namebox">
                                    <div class="imgbox"><img src="{{ asset('images/mipo/usericon5.png') }}" alt="no-image"></div>
                                    <p class="text-14-medium">John Doe</p>
                                </div>
                            </td>
                            <td class="text-12-medium">
                                <div class="actionbtnbox">
                                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#userEdit"><i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i><span class="text-12-medium edit">{!! __('Edit') !!}</span></a>
                                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#udelete_confirm"><i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i><span class="text-12-medium delete">{!! __('Delete') !!}</span></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>    
                </table>
            </div> --}}

            {{-- mobile table:st --}}
            {{-- <div class="mobile_cmn_table_wrap">
                <div class="mb_mngUser_table">
                    <div class="mb_boxdata">
                        <div class="lft"><p class="text-16-medium">{!! __('Name') !!}</p></div>
                        <div class="right">
                            <div class="user_namebox">
                                <p class="text-16-medium">John Doe</p>
                                <div class="imgbox"><img src="{{ asset('images/mipo/usericon1.png') }}" alt="no-image"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb_boxdata">
                        <div class="lft"><p class="text-16-medium">{!! __('Action') !!}</p></div>
                        <div class="right">
                            <div class="actionbtnbox">
                                <a href="javascipt:;"><i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i></a>
                                <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#udelete_confirm"><i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb_mngUser_table">
                    <div class="mb_boxdata">
                        <div class="lft"><p class="text-16-medium">{!! __('Name') !!}</p></div>
                        <div class="right">
                            <div class="user_namebox">
                                <p class="text-16-medium">John Doe</p>
                                <div class="imgbox"><img src="{{ asset('images/mipo/usericon1.png') }}" alt="no-image"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb_boxdata">
                        <div class="lft"><p class="text-16-medium">{!! __('Action') !!}</p></div>
                        <div class="right">
                            <div class="actionbtnbox">
                                <a href="javascipt:;"><i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i></a>
                                <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#udelete_confirm"><i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb_mngUser_table">
                    <div class="mb_boxdata">
                        <div class="lft"><p class="text-16-medium">{!! __('Name') !!}</p></div>
                        <div class="right">
                            <div class="user_namebox">
                                <p class="text-16-medium">John Doe</p>
                                <div class="imgbox"><img src="{{ asset('images/mipo/usericon1.png') }}" alt="no-image"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb_boxdata">
                        <div class="lft"><p class="text-16-medium">{!! __('Action') !!}</p></div>
                        <div class="right">
                            <div class="actionbtnbox">
                                <a href="javascipt:;"><i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i></a>
                                <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#udelete_confirm"><i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb_mngUser_table">
                    <div class="mb_boxdata">
                        <div class="lft"><p class="text-16-medium">{!! __('Name') !!}</p></div>
                        <div class="right">
                            <div class="user_namebox">
                                <p class="text-16-medium">John Doe</p>
                                <div class="imgbox"><img src="{{ asset('images/mipo/usericon1.png') }}" alt="no-image"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb_boxdata">
                        <div class="lft"><p class="text-16-medium">{!! __('Action') !!}</p></div>
                        <div class="right">
                            <div class="actionbtnbox">
                                <a href="javascipt:;"><i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i></a>
                                <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#udelete_confirm"><i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- mobile table:nd --}}
        </div>
</div>
</div>


{{--delete modal st --}}
<div class="delete_modal">
    <div class="modal fade" id="udelete_confirm" tabindex="-1" aria-labelledby="delete_confirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-24-medium">{!! __('Remove Payment Method') !!}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="text-14-medium ">{!! __('Are you sure you wish to erase a payment method?') !!}</p>
                <div class="modal-footer">
                    <a href="javascript:;" class="text-16-medium close" data-bs-dismiss="modal">{!! __('Cancel') !!}</a>
                     <button class="text-16-medium">{!! __('Delete') !!}</button>
                  </div>
            </div>
        </div>
    </div>    
</div>



{{-- edit modal :st--}}
<div class="pay_method_modal">
    <div class="modal fade " id="add_new_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-20-semibold">{!! __('Add Sub User') !!}</h3>
                    <button type="button" class="btn-close evt_close_modal" data-form-name="#addsubUserForm" data-modal-name="#add_new_user" aria-label="Close"></button>
                </div>
                <form action="{{ route('profile.store') }}" method="post" novalidate="novalidate"
                name="addsubUserForm" id="addsubUserForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <input type="hidden" name="action" id="action" value="">
                    <div class="modal-body">
                        <div class="profile_inputbox">
                            <label for="first_name" class="text-14-medium">{!! __('Name') !!}</label>
                            <input type="text" class="text-14-medium" id="first_name" name="first_name" required data-msg-required="{{ __('This field is required') }}">
                        </div>
                        <div class="profile_inputbox">
                            <label for="last_name" class="text-14-medium">{!! __('Last Name') !!}</label>
                            <input type="text" class="text-14-medium" id="last_name" name="last_name" required data-msg-required="{{ __('This field is required') }}">
                        </div>

                        <div class="profile_inputbox">
                            <label for="email" class="text-14-medium">{!! __('Email') !!}</label>
                            <input type="text" class="text-14-medium" id="email" name="email" required data-msg-required="{{ __('This field is required') }}">
                        </div>

                        <div class="profile_inputbox">
                            <label for="email" class="text-14-medium">{!! __('Password') !!}</label>
                            <input type="text" class="text-14-medium" id="password" name="password" required data-msg-required="{{ __('This field is required') }}">
                        </div>

                        <div class="profile_inputbox">
                            <label for="email" class="text-14-medium">{!! __('Confirm Password') !!}</label>
                            <input type="text" class="text-14-medium" id="password_confirmation" name="password_confirmation" required data-msg-required="{{ __('This field is required') }}">
                        </div>
                        
                        <div class="profile_inputbox">
                            <label for="phone_number" class="text-14-medium">{!! __('Phone Number') !!}</label>
                            <input type="text" class="text-14-medium" id="phone_number" name="phone_number" required data-msg-required="{{ __('This field is required') }}">
                        </div>
                        <div class="profile_inputbox">
                            <label for="role" class="text-14-medium">{!! __('Role') !!}</label>
                            <select class="form-select selectbox text-14-medium init_nice_select" name="role_id" id="role_id" required data-msg-required="{{ __('This field is required') }}">
                                <option value="">{{ __('Select a role') }}</option>
                                    @if ($roles->count() > 0)
                                        @foreach ($roles as $val)
                                            <option value="{{ $val->id }}">{{ $val->display_name }}</option>
                                        @endforeach
                                    @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="text-16-medium close evt_close_modal" data-form-name="#addsubUserForm" data-modal-name="#add_new_user">{!! __('Close') !!}</a>
                        <button type="submit" class="text-16-medium add">{!! __('Save') !!}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


{{-- user not created --}}
{{-- offered not found :st --}}
<div class="ope_notfoundWrap no_user_create_wrap" id="evt_no_sub_user">
<div class="imgbox">
    <div class="day"><img src="{{ asset('images/mipo/noUserCreateDay.svg') }}" alt="no-image"></div>
    <div class="night"><img src="{{ asset('images/mipo/noUserCreateNight.svg') }}" alt="no-image"></div>
<strong class="text-20-semibold">{!! __('No user created') !!}</strong>
<p class="text-16-medium">{!! __('Add Sub User to account') !!}</p>

<div class="add_subuserBtn">
    <a href="javascript:;" class="text-16-medium evt_user_modal_open" data-action="Add" data-bank-object="" data-form-name="#addsubUserForm" data-modal-name="#add_new_user"><i><img src="{{ asset('images/mipo/payplus.svg') }}" alt="no-image"></i> {!! __('Add Sub User') !!}</a>
</div>
</div>
</div>
{{-- offered not found :nd --}}