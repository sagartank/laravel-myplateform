<div class="user_Table">
    <table>
        <thead>
            <tr class="forbg">
                <th class="text-14-medium">{!! __('Name') !!}</th>
                <th class="text-14-medium">{!! __('Action') !!}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $user)
                <tr id="row-{{ $user->slug }}">
                    <td class="text-12-medium">
                        <div class="user_namebox">
                            <div class="imgbox"><img src="{{ $user->profile_image_url }}" alt="no-image"></div>
                            <p class="text-14-medium">{{ $user->name }}</p>
                        </div>
                    </td>
                    <td class="text-12-medium">
                        <div class="actionbtnbox">
                            @permission('user-side-profile-manage-users-edit')
                                <a href="javascipt:;" class="evt_user_modal_open" data-action="Update"
                                    data-user-object="{{ $user->toJson() }}" data-form-name="#addsubUserForm"
                                    data-modal-name="#add_new_user"><i><img src="{{ asset('images/mipo/payedit.svg') }}"
                                            alt="no-image"></i><span
                                        class="text-12-medium edit">{!! __('Edit') !!}</span></a>
                            @endpermission
                            @permission('user-side-profile-manage-users-delete')
                                <a href="javascipt:;" onclick="deleteRecord(this, () => loadMoreUserData())"
                                    data-href="{{ route('profile.ajax-enterprise-by-user-delete', ['user_id' => $user->slug]) }}"
                                    data-name="delete"><i><img src="{{ asset('images/mipo/paydelete.svg') }}"
                                            alt="no-image"></i><span
                                        class="text-12-medium delete">{!! __('Delete') !!}</span></a>
                            @endpermission
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mobile_cmn_table_wrap">
    @foreach ($users as $key => $user)
        <div class="mb_mngUser_table">
            <div class="mb_boxdata">
                <div class="lft">
                    <p class="text-16-medium">{!! __('Name') !!}</p>
                </div>
                <div class="right">
                    <div class="user_namebox">
                        <p class="text-16-medium">{{ $user->name }}</p>
                        <div class="imgbox"><img src="{{ $user->profile_image_url }}" alt="no-image"></div>
                    </div>
                </div>
            </div>
            <div class="mb_boxdata">
                <div class="lft">
                    <p class="text-16-medium">{!! __('Action') !!}</p>
                </div>
                <div class="right">
                    <div class="actionbtnbox">
                        <a href="javascipt:;" class="evt_user_modal_open" data-action="Update"
                            data-user-object="{{ $user->toJson() }}" data-form-name="#addsubUserForm"
                            data-modal-name="#add_new_user"><i><img src="{{ asset('images/mipo/payedit.svg') }}"
                                    alt="no-image"></i></a>
                        <a href="javascipt:;" onclick="deleteRecord(this, () => loadMoreUserData())"
                            data-href="{{ route('profile.ajax-enterprise-by-user-delete', ['user_id' => $user->slug]) }}"
                            data-name="delete"><i><img src="{{ asset('images/mipo/paydelete.svg') }}"
                                    alt="no-image"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
