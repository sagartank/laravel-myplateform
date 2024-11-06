<x-app-admin-layout>
    @section('pageTitle', 'Role Edit')
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
            {{ __('Edit Role') }}
            <x-slot name="right"></x-slot>
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name">{{ __('Name') }}</label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Role Name" value="{{ old('name', $role->display_name) }}" readonly required>
                                            @error('name')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="description">{{ __('Responsibility')}}</label>
                                            <textarea type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Define Responsibility">{{ old('description', $role->description) }}</textarea>
                                            @error('description')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" id="is-active" type="checkbox" name="is_active" value="1" @if($role->is_active) checked @endif>
                                                <label class="form-check-label" for="is-active">{{ __('Is Active?')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <fieldset class="mt-5">
                                    <legend class="mb-4">{{ __('Permissions') }}</legend>
                                    <div class="row">
                                        <div id="permissionsDiv">
                                            @include('admin.roles.permission')
                                        </div>
                                    </div>
                                </fieldset>
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
