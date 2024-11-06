    <table>
        <thead>
            <tr class="forbg">
                <th class="text-14-medium">{!! __('Name') !!}</th>
                <th class="text-14-medium">{!! __('Action') !!}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($roles as $role)
            <tr>
                <td class="text-12-medium">
                    <div class="user_namebox">
                        <div class="imgbox"><img src="{{ asset('images/mipo/usericon1.png') }}" alt="no-image"></div>
                        <p class="text-14-medium">{{ $role->display_name }}</p>
                    </div>
                </td>
                <td class="text-12-medium">
                    <div class="actionbtnbox">
                        <a  href="javascript:void(0)" class="evt_role_modal_open" data-action="Update"
                        data-bank-object="{{ $role->toJson() }}" data-form-name="#addUserBankForm"
                        data-modal-name="#add_new_bank_modal" data-modal-url="{{ route('role.ajax-edit', $role->id) }}"><i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i><span class="text-12-medium edit">{!! __('Edit') !!}</span></a>
                        <a href="javascript:void(0)" onclick="deleteRecord(this, () => loadMoreRoleData())"
                            data-href="{{ route('profile.ajax-role-delete', ['role_id' => $role->id]) }}"
                            data-name="delete"><i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i><span class="text-12-medium delete">{!! __('Delete') !!}</span></a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2">
                    <p class="text-center font-weight-bold text-danger mt-3">
                        {{ __('No Record Found.') }}
                    </p>
                </td>
            </tr>
            @endforelse
        </tbody>    
    </table>