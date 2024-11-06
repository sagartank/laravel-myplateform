<x-app-admin-layout>
    @section('pageTitle', 'User Level Edit')
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
                {{ __('Edit User Level') }}
                <x-slot name="right">
                    <a href="{{ route('admin.user-level.index') }}">
                        <button type="button" class="btn btn-sm btn-dark">{{ __('Back') }}</button>
                    </a>
                </x-slot>
            </x-header>
        </x-slot>
        <div class="py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form action="{{ route('admin.user-level.update', $edit) }}" method="POST">
                                <div class="card-body">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="name">{{ __('Name') }}</label>
                                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"  placeholder="Name" value="{{ old('name', $edit->name) }}" required autofocus>
                                                @error('name')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="number_of_deals">{{ __('No Of Deals') }}</label>
                                                <input type="number" name="number_of_deals" id="number_of_deals" class="form-control @error('number_of_deals') is-invalid @enderror" placeholder="No Of Deals" value="{{ old('number_of_deals', $edit->number_of_deals) }}">
                                                @error('number_of_deals')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="amount_of_sales_pyg">{{ __('Amount Of Sale') }}</label>
                                                <input type="number" name="amount_of_sales_pyg" id="amount_of_sales_pyg" class="form-control @error('amount_of_sales_pyg') is-invalid @enderror" placeholder="Amount Of Sale" value="{{ old('amount_of_sales_pyg', $edit->amount_of_sales_pyg) }}">
                                                @error('amount_of_sales_pyg')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="can_view_upto_amount_pyg">{{ __('Amount Of View') }}</label>
                                                <input type="number" name="can_view_upto_amount_pyg" id="can_view_upto_amount_pyg" class="form-control @error('can_view_upto_amount_pyg') is-invalid @enderror" placeholder="Amount of View" value="{{ old('can_view_upto_amount_pyg', $edit->can_view_upto_amount_pyg) }}">
                                                @error('can_view_upto_amount_pyg')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="description">{{ __('Permissions') }}</label>
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
                                                {{ __('Update') }}
                                            </x-submit-button>
                                            <a href="{{ route('admin.user-level.index') }}">
                                                <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md">{{ __('Cancel')  }}</button>
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
    