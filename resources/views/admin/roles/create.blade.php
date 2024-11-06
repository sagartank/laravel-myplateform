<x-app-admin-layout>
    @section('pageTitle', 'Role Add')
@section('custom_style')
<style>
    #permissionsDiv ol,
    ul,
    menu {
        list-style: none;
        margin: 0;
        padding: revert;
    }
    #permissionsDiv{
        display:inline;    
    }
</style>
@endsection

    <x-slot name="header">
        <x-header>
            {{ __('Create Role') }}
            <x-slot name="right"></x-slot>
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.roles.store') }}" method="POST">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name">{{ __('Name') }}</label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Role Name') }}" value="{{ old('name') }}" required autofocus>
                                            @error('name')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="description">{{ __('Description')}}</label>
                                            <textarea type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ __('Define Role') }}">{{ old('description') }}</textarea>
                                            @error('description')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="description">{{ __('Permissions')}}</label>
                                            <div id="permissionsDiv">
                                                @include('admin.roles.permission')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row py-2">
                                    <div class="col-md-12">
                                        <x-submit-button class="mr-4">
                                            {{ __('Submit') }}
                                        </x-submit-button>
                                        <a href="{{ route('admin.roles.index') }}">
                                            <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md">{{ __('Cancel') }}</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('custom_script')
<script>
     $('li :checkbox').on('click', function () {
        var $chk = $(this),
            $li = $chk.closest('li'),
            $ul, $parent;
        if ($li.has('ul')) {
            $li.find(':checkbox').not(this).prop('checked', this.checked)
        }
        do {
            $ul = $li.parent();
            $parent = $ul.siblings(':checkbox');
            if ($chk.is(':checked')) {
                $parent.prop('checked', true)
            }else{
                if($ul.has(':checked').length==0){
                    $parent.prop('checked', false)
                }
            }
            $chk = $parent;
            $li = $chk.closest('li');
        } while ($ul.is(':not(.role-permissions)'));      
        
    });
</script>
@endsection
</x-app-admin-layout>
