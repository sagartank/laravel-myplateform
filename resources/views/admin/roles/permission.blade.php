<ul class="role-permissions">
@php
    $rolepermissions_en_es = config('rolepermissions');
@endphp
    @foreach ($permissions as $permission)
    <li>
        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @if(isset($roleAssignPermission) && in_array($permission->id,$roleAssignPermission)) checked @endif />
        @if(App()->isLocale('en') == 'en')
            <span>{{ $permission->display_name }}</span>
        @else
            <span>{{ $rolepermissions_en_es[$permission->display_name] ?? $permission->display_name  }}</span>
        @endif
        @if ($permission->childrenPermissions->count() > 0)  
            <ul class="child">       
                @foreach ($permission->childrenPermissions as $childPermission)
                    @include('admin.roles.child_permission', ['child_permission' => $childPermission,'roleAssignPermission'=> $roleAssignPermission ?? null])
                @endforeach
            </ul>
        @endif
    </li>
@endforeach
</ul>