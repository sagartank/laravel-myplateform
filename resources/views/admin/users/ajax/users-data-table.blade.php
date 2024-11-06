@php
    function getSortingClassBySortColumn($sortType, $column, $reqColumn = '')
    {
        if ($reqColumn && $reqColumn == $column && $sortType) {
            return $sortType == 'asc' ? 'sorting_asc' : 'sorting_desc';
        } else {
            return null;
        }
    }
@endphp

<div>
    <table class="table table-bordered table-hover dt-responsive nowrap evt_user_data_table_list">
        <thead>
            <tr>
                <th class="no-sort text-center">{{ __('Actions') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'first_name', $sortColumn) }}" data-column-name="first_name">{{ __('First Name')}}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'last_name', $sortColumn) }}" data-column-name="last_name">{{ __('Last Name')}}</th>
                @if(!in_array('ruc_id', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'ruc_tax_id', $sortColumn) }}" data-column-name="ruc_tax_id">{{ __('RUC ID')}}</th>
                @endif
                @if(!in_array('email', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'email', $sortColumn) }}" data-column-name="email">{{ __('Email')}}</th>
                @endif
                @if(!in_array('phone', $column_names))
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'phone_number', $sortColumn) }}" data-column-name="phone_number">{{ __('Phone') }}</th>
                @endif
                @if(!in_array('address', $column_names))
                    <th>{{ __('Address')}}</th>
                @endif
                @if(!in_array('city', $column_names))
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'city', $sortColumn) }}" data-column-name="city">{{ __('City')}}</th>
                @endif
                {{-- <th class="sorting {{ getSortingClassBySortColumn($sortType, 'state', $sortColumn) }}"  data-column-name="state">{{ __('State')}}</th> --}}
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'account_type', $sortColumn) }}"  data-column-name="account_type">{{ __('Account')}} <br> {{ __('Type')}}</th>
                <th>{{ __('Address')}} <br> {{ __('Verify')}}</th>
                <th>{{ __('Is Registered')}}</th>
                <th>{{ __('Registered At')}}</th>
                <th>{{ __('Is Active') }}</th>
                <th>{{ __('KYC Address')}}</th>
                <th>{{ __('User Account Export')}}</th>
                <th>{{ __('Last Login At')}}</th>
                <th>{{ __('Last Login IP')}}</th>
            </tr>
        </thead>
        <tbody>
            @if ($users->isNotEmpty())
                @foreach ($users as $user)
                    <tr id="row-{{ $user->slug }}">
                        <td class="actions" align="center">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                    data-coreui-toggle="dropdown" aria-expanded="false">
                                    {{ __('Actions') }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    @permission('edit-user')
                                    <li><a href="{{ route('admin.users.edit', $user) }}"
                                            class="dropdown-item text-white btn btn-sm btn-primary">{{ __('Edit') }}</a></li>
                                    @endpermission
                                    @permission('view-user-detail')
                                    <li><a href="{{ route('admin.users.show', $user) }}"
                                            class="dropdown-item text-white btn btn-sm btn-info">{{ __('Details') }}</a></li>
                                    @endpermission
                                    @if ($user->trashed())
                                        <li><a href="javascript:;"
                                                data-href="{{ route('admin.users.delete', $user->slug) }}"
                                                onclick="deleteRecord(this)" data-name="restore"
                                                class="dropdown-item text-white btn btn-sm btn-success">{{ __('Restore') }}</a></li>
                                    @else
                                        @permission('delete-user')
                                        <li><a href="javascript:;"data-href="{{ route('admin.users.delete', $user->slug) }}"
                                                onclick="deleteRecord(this)" data-name="delete"
                                                class="dropdown-item text-white btn btn-sm btn-warning">{{ __('Delete') }}</a></li>
                                        @endpermission
                                    @endif
                                    @permission('permanent-delete-user')
                                    <li><a href="javascript:;"
                                            data-href="{{ route('admin.users.forcedelete', $user->slug) }}"
                                            onclick="permanentDeleteRecord(this)" data-slug="{{ $user->slug }}"
                                            class="dropdown-item text-white btn btn-sm btn-danger">{{ __('Permanent Delete') }}</a>
                                    </li>
                                    @endpermission
                                    @if($user->is_registered == '1' && $user->is_active == '1')
                                    <li><a href="{{ route('admin.users.login-as-user', $user->slug) }}"
                                            class="dropdown-item text-white btn btn-sm btn-primary">{{ __('Login As User') }}</a>
                                    </li>
                                    @endif
                                    <li><a href="{{ route('admin.users.update-plan-modal', $user->slug) }}"
                                            class="dropdown-item text-white btn btn-sm btn-primary get-user-plan-detail">{{ __('Update Plan') }}</a></li>
                                    <li>
                                        <a href="{{ route('admin.users.send-reset-password-link', $user->slug) }}" class="dropdown-item text-white btn btn-sm btn-primary send-user-reset-password-link">{{ __('Reset Password') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>{{ $user->first_name }} {!! ($user->companies->count()  == 0) ? '<span title="No Company" class="text-white badge text-bg-danger">No</span>' : '<span title="Yes Company" class="text-white badge text-bg-success">Yes</span>' !!}</td>
                        <td>{{ $user->last_name }}</td>
                        @if(!in_array('ruc_id', $column_names))
                            <td>{{ $user->issuer?->ruc_code }}</td>
                        @endif
                        @if(!in_array('email', $column_names))
                            <td>{{ $user->email }}</td>
                        @endif
                        @if(!in_array('phone', $column_names))
                            <td>{{ $user->phone_number }}</td>
                        @endif
                        @if(!in_array('address', $column_names))
                            <td>{{ $user->address }}</td>
                        @endif
                        @if(!in_array('city', $column_names))
                            <td>{{ $user->city?->name }}</td>
                        @endif
                        <td>{{ $user->account_type }}</td>
                        <td id="otp_send_user_{{ $user->id }}">
                            @if ($user->address_verify == 'Yes')
                                <span class="text-white badge text-bg-success">{{ __('Yes') }}</span>
                            @elseif($user->address_verify == 'No')
                                <span class="text-white badge text-bg-danger">{{ __('No') }}</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            @if ($user->is_registered == '1')
                                <span class="text-white badge text-bg-success">{{ __('Yes')}}</span>
                            @else
                                <span class="text-white badge text-bg-danger">{{ __('No') }}</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->is_active == '1')
                                <span class="text-white badge text-bg-success">{{ __('Yes')}}</span>
                            @else
                                <span class="text-white badge text-bg-danger">{{ __('No') }}</span>
                            @endif
                        </td>
                        <td>
                            @if (!$user->address_verify_at)
                                <span role="button" class="text-white badge text-bg-info evt_download_pdf_btn" data-file-name="{{$user->slug}}" data-href="{{ route('admin.users.ajax-kyc-address', [$user->slug, 'user-kyc']) }}" data-user-id="{{$user->id}}">{{ __('Download KYC')}}</span>
                            @else
                                <span class="text-white badge text-bg-success">{{ __('Verified')}}</span>
                            @endif
                        </td>
                        <td>
                            <span role="button" class="text-white badge text-bg-info evt_download_pdf_btn" data-file-name="{{$user->slug}}" data-href="{{ route('admin.users.ajax-kyc-address', [$user->slug, 'user-account']) }}" data-user-id="{{$user->id}}">{{ __('Download User Account')}}</span>
                        </td>
                        <td>{{ $user->last_login_at }}</td>
                        <td>{{ $user->last_login_ip }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="pt-1">
        <div
            class="d-flex justify-content-center justify-content-sm-between flex-wrap flex-sm-nowrap align-items-center">
            <div class="text-center text-sm-left">{{ $users->links() }}</div>
            @if ($users->isNotEmpty())
                <div class="mt-2 mt-sm-0 text-center text-sm-right">
                    <span>{{ __('Entries per page') }}:&nbsp;</span>
                    <select name="per_page" id="per-page" form="form-filter-user">
                        <option value="15" @if ($perPage == 15) selected @endif>15</option>
                        <option value="25" @if ($perPage == 25) selected @endif>25</option>
                        <option value="50" @if ($perPage == 50) selected @endif>50</option>
                        <option value="100" @if ($perPage == 100) selected @endif>100</option>
                    </select>
                </div>
            @endif
        </div>
    </div>
</div>
