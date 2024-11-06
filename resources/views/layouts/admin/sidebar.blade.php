<div class="sidebar-brand d-none d-md-flex">
    <img src="{{ asset('images/logo-white.svg') }}">
</div>
<ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
    @permission('dashboard')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            {{ __('Dashboard') }}
{{--            <span class="badge badge-sm bg-info ms-auto">NEW</span>--}}
        </a>
    </li>
    @endpermission
    <li class="nav-title">{{ __('Modules') }}</li>
    @permission('user_master')
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <circle cx="9" cy="7" r="4" />
                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
            </svg>
            </i> {{ __('Users') }}
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <span class="nav-icon flxrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="12" cy="7" r="4" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                    </span> {{ __('User List') }}
                </a>
            </li>
            @permission('add-user')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.create') }}">
                    <span class="nav-icon flxrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="9" cy="7" r="4" />
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    <path d="M16 11h6m-3 -3v6" />
                    </svg>
                    </span> {{ __('Add New') }}
                </a>
            </li>
            @endpermission
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.company') }}">
                    <span class="nav-icon flxrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="12" cy="7" r="4" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                    </span> {{ __('Company List') }}
                </a>
            </li>
        </ul>
    </li>
    @endpermission
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <circle cx="9" cy="7" r="4" />
                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
            </svg>
            </i> {{ __('Issuer Banks') }}
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.issuer-bank.index') }}">
                    <span class="nav-icon flxrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="12" cy="7" r="4" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                    </span> {{ __(' Issuer Bank List') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.issuer-bank.create') }}">
                    <span class="nav-icon flxrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="9" cy="7" r="4" />
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    <path d="M16 11h6m-3 -3v6" />
                    </svg>
                    </span> {{ __('Add New') }}
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <circle cx="9" cy="7" r="4" />
                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
            </svg>
            </i> {{ __('Pages') }}
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.pages.index') }}">
                    <span class="nav-icon flxrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="12" cy="7" r="4" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                    </span> {{ __('Pages List') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.pages.create') }}">
                    <span class="nav-icon flxrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="9" cy="7" r="4" />
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    <path d="M16 11h6m-3 -3v6" />
                    </svg>
                    </span> {{ __('Add New') }}
                </a>
            </li>
        </ul>
    </li>
    @permission('role_master')
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-git-fork" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <circle cx="12" cy="18" r="2" />
                <circle cx="7" cy="6" r="2" />
                <circle cx="17" cy="6" r="2" />
                <path d="M7 8v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2 -2v-2" />
                <line x1="12" y1="12" x2="12" y2="16" />
            </svg>
            </i> {{ __('Roles') }}
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.roles.index') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-git-pull-request" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="6" cy="18" r="2" />
                        <circle cx="6" cy="6" r="2" />
                        <circle cx="18" cy="18" r="2" />
                        <line x1="6" y1="8" x2="6" y2="16" />
                        <path d="M11 6h5a2 2 0 0 1 2 2v8" />
                        <polyline points="14 9 11 6 14 3" />
                    </svg>
                    </span> {{ __('Role List') }}
                </a>
            </li>
            @permission('add-role')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.roles.create') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-git-compare" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="6" cy="6" r="2" />
                        <circle cx="18" cy="18" r="2" />
                        <path d="M11 6h5a2 2 0 0 1 2 2v8" />
                        <polyline points="14 9 11 6 14 3" />
                        <path d="M13 18h-5a2 2 0 0 1 -2 -2v-8" />
                        <polyline points="10 15 13 18 10 21" />
                    </svg>
                    </span> {{ __('Add New') }}
                </a>
            </li>
            @endpermission
        </ul>
    </li>
    @endpermission
    {{--<li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shield-lock" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" />
                <circle cx="12" cy="11" r="1" />
                <line x1="12" y1="12" x2="12" y2="14.5" />
            </svg>
            </i> Permission Master
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-fingerprint" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M18.9 7a8 8 0 0 1 1.1 5v1a6 6 0 0 0 .8 3" />
                        <path d="M8 11a4 4 0 0 1 8 0v1a10 10 0 0 0 2 6" />
                        <path d="M12 11v2a14 14 0 0 0 2.5 8" />
                        <path d="M8 15a18 18 0 0 0 1.8 6" />
                        <path d="M4.9 19a22 22 0 0 1 -.9 -7v-1a8 8 0 0 1 12 -6.95" />
                    </svg>
                    </span> Permission List
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.permissions.create') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hand-stop" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M8 13v-7.5a1.5 1.5 0 0 1 3 0v6.5" />
                        <path d="M11 5.5v-2a1.5 1.5 0 1 1 3 0v8.5" />
                        <path d="M14 5.5a1.5 1.5 0 0 1 3 0v6.5" />
                        <path d="M17 7.5a1.5 1.5 0 0 1 3 0v8.5a6 6 0 0 1 -6 6h-2h.208a6 6 0 0 1 -5.012 -2.7a69.74 69.74 0 0 1 -.196 -.3c-.312 -.479 -1.407 -2.388 -3.286 -5.728a1.5 1.5 0 0 1 .536 -2.022a1.867 1.867 0 0 1 2.28 .28l1.47 1.47" />
                    </svg>
                    </span> Add New
                </a>
            </li>
        </ul>
    </li>--}}
    @permission('operation_master')
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-zip" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M6 20.735a2 2 0 0 1 -1 -1.735v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-1" />
                <path d="M11 17a2 2 0 0 1 2 2v2a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-2a2 2 0 0 1 2 -2z" />
                <line x1="11" y1="5" x2="10" y2="5" />
                <line x1="13" y1="7" x2="12" y2="7" />
                <line x1="11" y1="9" x2="10" y2="9" />
                <line x1="13" y1="11" x2="12" y2="11" />
                <line x1="11" y1="13" x2="10" y2="13" />
                <line x1="13" y1="15" x2="12" y2="15" />
            </svg>
            </i> {{ __('Operations') }}
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.operations.index') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                        <line x1="9" y1="7" x2="13" y2="7" />
                        <line x1="9" y1="11" x2="13" y2="11" />
                    </svg>
                    </span> {{ __('Operations List') }}
                </a>
            </li>
        </ul>
    </li>
    @endpermission
    @permission('payer_issuer_master')
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <circle cx="9" cy="7" r="4" />
                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
            </svg>
            </i> {{__('Payer\'s Profiles')}} 
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.payer-issuer.index') }}">
                    <span class="nav-icon flxrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="12" cy="7" r="4" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                    </span> {{ __('Payer / Issuer List')}} 
                </a>
            </li>
            @permission('add-payer-issuer')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.payer-issuer.create') }}">
                    <span class="nav-icon flxrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="9" cy="7" r="4" />
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    <path d="M16 11h6m-3 -3v6" />
                    </svg>
                    </span>{{ __('Add New') }}
                </a>
            </li>
            @endpermission
        </ul>
    </li>
    @endpermission
    @permission('offer_master')
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-zip" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M6 20.735a2 2 0 0 1 -1 -1.735v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-1" />
                <path d="M11 17a2 2 0 0 1 2 2v2a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-2a2 2 0 0 1 2 -2z" />
                <line x1="11" y1="5" x2="10" y2="5" />
                <line x1="13" y1="7" x2="12" y2="7" />
                <line x1="11" y1="9" x2="10" y2="9" />
                <line x1="13" y1="11" x2="12" y2="11" />
                <line x1="11" y1="13" x2="10" y2="13" />
                <line x1="13" y1="15" x2="12" y2="15" />
            </svg>
            </i> {{ __('Offers') }}
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.offers.index') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                        <line x1="9" y1="7" x2="13" y2="7" />
                        <line x1="9" y1="11" x2="13" y2="11" />
                    </svg>
                    </span> {{ __('Offer List') }}
                </a>
            </li>
        </ul>
    </li>
    @endpermission
    @permission('deal_master')
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-zip" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M6 20.735a2 2 0 0 1 -1 -1.735v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-1" />
                <path d="M11 17a2 2 0 0 1 2 2v2a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-2a2 2 0 0 1 2 -2z" />
                <line x1="11" y1="5" x2="10" y2="5" />
                <line x1="13" y1="7" x2="12" y2="7" />
                <line x1="11" y1="9" x2="10" y2="9" />
                <line x1="13" y1="11" x2="12" y2="11" />
                <line x1="11" y1="13" x2="10" y2="13" />
                <line x1="13" y1="15" x2="12" y2="15" />
            </svg>
            </i>  {{ __('Deals') }}
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.deals.index') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                        <line x1="9" y1="7" x2="13" y2="7" />
                        <line x1="9" y1="11" x2="13" y2="11" />
                    </svg>
                    </span> {{ __('Deal List') }}
                </a>
            </li>
        </ul>
    </li>
    @endpermission
    @permission('progress_master')
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-zip" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M6 20.735a2 2 0 0 1 -1 -1.735v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-1" />
                <path d="M11 17a2 2 0 0 1 2 2v2a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-2a2 2 0 0 1 2 -2z" />
                <line x1="11" y1="5" x2="10" y2="5" />
                <line x1="13" y1="7" x2="12" y2="7" />
                <line x1="11" y1="9" x2="10" y2="9" />
                <line x1="13" y1="11" x2="12" y2="11" />
                <line x1="11" y1="13" x2="10" y2="13" />
                <line x1="13" y1="15" x2="12" y2="15" />
            </svg>
            </i> {{ __('Progress Bar') }}
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.progress.index') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                        <line x1="9" y1="7" x2="13" y2="7" />
                        <line x1="9" y1="11" x2="13" y2="11" />
                    </svg>
                    </span> {{ __('Progress List') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.progress.create') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                        <line x1="9" y1="7" x2="13" y2="7" />
                        <line x1="9" y1="11" x2="13" y2="11" />
                    </svg>
                    </span> {{ __('Add New') }}
                </a>
            </li>
        </ul>
    </li>
    @endpermission
    @permission('user_level_master')
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-zip" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M6 20.735a2 2 0 0 1 -1 -1.735v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-1" />
                <path d="M11 17a2 2 0 0 1 2 2v2a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-2a2 2 0 0 1 2 -2z" />
                <line x1="11" y1="5" x2="10" y2="5" />
                <line x1="13" y1="7" x2="12" y2="7" />
                <line x1="11" y1="9" x2="10" y2="9" />
                <line x1="13" y1="11" x2="12" y2="11" />
                <line x1="11" y1="13" x2="10" y2="13" />
                <line x1="13" y1="15" x2="12" y2="15" />
            </svg>
            </i> {{ __('User Levels') }}
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.user-level.index') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                        <line x1="9" y1="7" x2="13" y2="7" />
                        <line x1="9" y1="11" x2="13" y2="11" />
                    </svg>
                    </span> {{ __('User Level List') }}
                </a>
            </li>
            @permission('add-user-level')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.user-level.create') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                        <line x1="9" y1="7" x2="13" y2="7" />
                        <line x1="9" y1="11" x2="13" y2="11" />
                    </svg>
                    </span> {{ __('Add New') }}
                </a>
            </li>
            @endpermission
        </ul>
    </li>
    @endpermission
    @permission('company_types_master')
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-zip" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M6 20.735a2 2 0 0 1 -1 -1.735v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-1" />
                <path d="M11 17a2 2 0 0 1 2 2v2a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-2a2 2 0 0 1 2 -2z" />
                <line x1="11" y1="5" x2="10" y2="5" />
                <line x1="13" y1="7" x2="12" y2="7" />
                <line x1="11" y1="9" x2="10" y2="9" />
                <line x1="13" y1="11" x2="12" y2="11" />
                <line x1="11" y1="13" x2="10" y2="13" />
                <line x1="13" y1="15" x2="12" y2="15" />
            </svg>
            </i> {{ __('Company Types') }}
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.companies.index') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                        <line x1="9" y1="7" x2="13" y2="7" />
                        <line x1="9" y1="11" x2="13" y2="11" />
                    </svg>
                    </span> {{ __('Company Type List') }}
                </a>
            </li>
            @permission('add-company-types')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.companies.create') }}">
                    <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                        <line x1="9" y1="7" x2="13" y2="7" />
                        <line x1="9" y1="11" x2="13" y2="11" />
                    </svg>
                    </span> {{ __('Add New') }}
                </a>
            </li>
            @endpermission
        </ul>
    </li>
    @endpermission
    @permission('settings')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.settings.index') }}">
                <span class="nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                    <line x1="9" y1="7" x2="13" y2="7" />
                    <line x1="9" y1="11" x2="13" y2="11" />
                </svg>
                </span> {{ __('Settings') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.settings.invite') }}">
                <span class="nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                    <line x1="9" y1="7" x2="13" y2="7" />
                    <line x1="9" y1="11" x2="13" y2="11" />
                </svg>
                </span> {{ __('Invite Email') }}
            </a>
        </li>
        @endpermission
        @permission('marketing_master')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <i class="icon icon-2xl mr-2 cil-group">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="9" cy="7" r="4" />
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                </svg>
                </i> {{ __('Marketing') }}
            </a>
            <ul class="nav-group-items">
                @permission('home-text-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.home-texts.index') }}">
                        <span class="nav-icon flxrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="12" cy="7" r="4" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </span> {{ __('Home Text List') }}
                    </a>
                </li>
                @endpermission
                @permission('home-side-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.home-slides.index') }}">
                        <span class="nav-icon flxrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="12" cy="7" r="4" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </span> {{ __(' Home Slide List') }}
                    </a >
                </li>
                @endpermission
                @permission('home-partner-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.home-partners.index') }}">
                        <span class="nav-icon flxrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="12" cy="7" r="4" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </span> {{ __('Home Partner List') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.how-to-work.index') }}">
                        <span class="nav-icon flxrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="12" cy="7" r="4" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </span> {{ __('How To Work Text') }}
                    </a>
                </li>
                @endpermission
                @permission('blog-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.blogs.index') }}">
                        <span class="nav-icon flxrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="12" cy="7" r="4" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </span> {{ __('Blog List') }}
                    </a>
                </li>
                @endpermission
                @permission('faq-type-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.faq-types.index') }}">
                        <span class="nav-icon flxrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="12" cy="7" r="4" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </span> {{ __('FAQ Type List') }}
                    </a>
                </li>
                @endpermission
                @permission('faq-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.faqs.index') }}">
                        <span class="nav-icon flxrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="12" cy="7" r="4" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </span> {{ __('FAQ List') }}
                    </a>
                </li>
                @endpermission
                @permission('social-media-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.social-media.index') }}">
                        <span class="nav-icon flxrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="12" cy="7" r="4" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </span> {{ __(' Social Media List') }}
                    </a>
                </li>
                @endpermission
            </ul>
        </li>
        @endpermission
        @permission('plans')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.plans.index') }}">
                <span class="nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                    <line x1="9" y1="7" x2="13" y2="7" />
                    <line x1="9" y1="11" x2="13" y2="11" />
                </svg>
                </span> {{ __('Plans') }}
            </a>
        </li>
        @endpermission
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.logs.index') }}">
                <span class="nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                    <line x1="9" y1="7" x2="13" y2="7" />
                    <line x1="9" y1="11" x2="13" y2="11" />
                </svg>
                </span>{{ __('Logs') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.user-relation-chart') }}">
                <span class="nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                    <line x1="9" y1="7" x2="13" y2="7" />
                    <line x1="9" y1="11" x2="13" y2="11" />
                </svg>
                </span>{{ __('Graph') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.activity-log.index') }}">
                <span class="nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                    <line x1="9" y1="7" x2="13" y2="7" />
                    <line x1="9" y1="11" x2="13" y2="11" />
                </svg>
                </span>{{ __('Activity Logs') }}
            </a>
        </li>
    </li>
</ul>
<!-- <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button> -->
