@php
    $rolepermissions_en_es = config('rolepermissions');
@endphp
<li> <input type="checkbox" name="permissions[]" value="{{ $child_permission->id }}" @if(isset($roleAssignPermission) && in_array($child_permission->id,$roleAssignPermission)) checked @endif />
    @if(App()->isLocale('en') == 'en')
    <span>{{ $child_permission->display_name }}  </span>
    @else
        <span>{{ $rolepermissions_en_es[$child_permission->display_name] ??   $child_permission->display_name }}  </span>
    @endif
@if ($child_permission->permissions->count() > 0)
    <ul class="child">
        @foreach ($child_permission->permissions as $childPermission)
            @include('admin.roles.child_permission', ['child_permission' => $childPermission,'roleAssignPermission'=> $roleAssignPermission ?? null])
        @endforeach
    </ul>
@endif
</li>