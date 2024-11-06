<div class="sidebar-brand d-none d-md-flex">
    <img src="{{ asset('images/logo.png') }}" width="116">
</div>
<ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
    <li class="nav-item">
        <a class="nav-link" href="index.html">
            Dashboard
{{--            <span class="badge badge-sm bg-info ms-auto">NEW</span>--}}
        </a>
    </li>
    <li class="nav-title">Modules</li>
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group"></i> User Master
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <span class="nav-icon"></span> User List
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.create') }}">
                    <span class="nav-icon"></span> Add New
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group"></i> Role Master
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.roles.index') }}">
                    <span class="nav-icon"></span> Role List
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.roles.create') }}">
                    <span class="nav-icon"></span> Add New
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group"></i> Permission Master
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                    <span class="nav-icon"></span> Permission List
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.permissions.create') }}">
                    <span class="nav-icon"></span> Add New
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="icon icon-2xl mr-2 cil-group"></i> Operations Master
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.operations.index') }}">
                    <span class="nav-icon"></span> Operations List
                </a>
            </li>
        </ul>
    </li>
</ul>
<button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
