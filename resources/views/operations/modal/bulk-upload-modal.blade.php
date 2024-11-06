<style>
    #permissionsDiv ol,
    ul,
    menu {
        list-style: none;
        margin: 0;
        padding: revert;
    }
    #permissionsDiv{
        max-height: 300px;
        overflow-y: auto;  
    }
</style>
<div class="modal-content">
    <div class="modal-body">
        <div class="add_user_modal_top">
            <div class="add_new_user_title">
                <h3>{{ __('Add new role') }}</h3>
                <div class="add_new_user_btn">
                    <a href="javascript:void(0)" class="btn btn-secondary evt_close_modal"
                        data-form-name="#addRoleForm"
                        data-modal-name="#role_modal">{{ __('Close') }}</a>
                </div>
            </div>
            <form action="{{ route('role.ajax-store') }}" method="post" novalidate="novalidate"
                name="addRoleForm" id="addRoleForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Role Name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <x-error-alert :message="$message" />
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Define Role">{{ old('description') }}</textarea>
                                @error('description')
                                    <x-error-alert :message="$message" />
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="description">Permissions</label>
                                <div id="permissionsDiv">
                                    @include('admin.roles.permission')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                    <button type="button" id="btn_sub_user_form"
                        class="btn btn-secondary evt_close_modal" data-form-name="#addRoleForm"
                        data-modal-name="#role_modal">{{ __('Close') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
    $('#addRoleForm').submit(function(e) {
        e.preventDefault();
        let form = $(this);
        let form_valid = form.valid();
        if (form_valid) {
            setLoadin();
            let formData = new FormData($('#addRoleForm')[0]);
            let actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    unsetLoadin();
                    if (res.status == true) {
                        toastr.success(res.message);
                        $('#add_new_user').modal('hide');
                        $('#addRoleForm')[0].reset();
                        loadMoreRoleData();
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function(xhr) {
                    unsetLoadin();
                    ajaxErrorMsg(xhr);
                }
            });
        }
    });
</script>