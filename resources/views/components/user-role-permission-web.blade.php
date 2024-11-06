<div class="protabdetail">
    <div class="protab_outerbox">
        <div class="permission_rolebox">
            <div class="titlebox">
                <h3 class="text-20-semibold">{!! __('Role') !!}</h3>
                <div class="newuserbtn">
                    <a href="javascript:;" class="text-16-medium evt_role_modal_open" 
                    data-action="Add"
                    data-bank-object=""
                    data-modal-url="{{route('role.get-modal')}}">
                    <i><img src="{{ asset('images/mipo/payplus.svg') }}" alt="no-image"></i>{!! __('New Role') !!}</a>
                </div>
            </div>
        </div>
        <div class="permission_role_table" id="ajax_role_list">
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
                                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#add_new_role"><i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i><span class="text-12-medium edit">{!! __('Edit') !!}</span></a>
                                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#roledelete_confirm"><i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i><span class="text-12-medium delete">{!! __('Delete') !!}</span></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>    
                </table>
            </div>
    </div>
</div>            


{{-- edit modal :st--}}
<div class="role_notification_modal">
    <div class="modal fade" id="role_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" id="role_modal_dailog">

        </div>
    </div>
</div>



{{--delete modal st --}}
<div class="delete_modal">
    <div class="modal fade" id="roledelete_confirm" tabindex="-1" aria-labelledby="delete_confirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-24-medium">{!! __('Remove User Role') !!}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="text-14-medium ">{!! __('Are you sure you wish to erase a user role?') !!}</p>
                <div class="modal-footer">
                    <a href="javascript:;" class="text-16-medium close" data-bs-dismiss="modal">{!! __('Cancel') !!}</a>
                    <button class="text-16-medium">{!! __('Delete') !!}</button>
                </div>
            </div>
        </div>
    </div>    
</div>
