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
    <div class="modal-header">
        <h3 class="text-20-semibold">{!! __('Add New Role') !!}</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form  action="{{ route('role.ajax-store') }}" method="post" novalidate="novalidate"
    name="addRoleForm" id="addRoleForm" enctype="multipart/form-data">
    @csrf
        <div class="modal-body">
            <div class="profile_inputbox">
                <label for="name" class="text-14-medium">{!! __('Name') !!}</label>
                <input type="text" class="text-14-medium" id="name" name="name" placeholder="Role Name" required>
            </div>
            <div class="profile_inputbox">
                <label for="description" class="text-14-medium">{!! __('Description') !!}</label>
                <textarea placeholder="Define Role" name="description" id="description" required></textarea>
            </div>
            <div class="role_check_wrap">
                <div class="profile_inputbox">
                    <label for="description" class="text-14-medium">{!! __('Permissions') !!}</label>
                </div> 
                <div class="filter_modal_topcol">
                    <div id="permissionsDiv">
                    @include('admin.roles.permission')
                    {{-- <div class="filter_modal_cattitle"><a href="javascript:void(0)"> SELLERS STATUS <i>
                        <img src="http://localhost:8000/images/mipo/filtercheveron-down.svg" alt="no-image"></i></a></div>

                    <div class="filter_catlist">
                        <div class="filter_checkbox_wrap">
                            <input type="checkbox" name="user_level" value="Noobie" id="user_level_0">
                            <label for="user_level_0">Noobie</label>
                        </div>
                        <div class="filter_checkbox_wrap">
                            <input type="checkbox" name="user_level" value="Bronze" id="user_level_1">
                            <label for="user_level_1">Bronze</label>
                        </div>
                        <div class="filter_checkbox_wrap">
                            <input type="checkbox" name="user_level" value="Silver" id="user_level_2">
                            <label for="user_level_2">Silver</label>
                        </div>
                        <div class="filter_checkbox_wrap">
                            <input type="checkbox" name="user_level" value="Gold" id="user_level_3">
                            <label for="user_level_3">Gold</label>
                        </div>
                        <div class="filter_checkbox_wrap">
                            <input type="checkbox" name="user_level" value="Platinum" id="user_level_4">
                            <label for="user_level_4">Platinum</label>
                        </div>
                    </div> --}}
                </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="text-16-medium close"  data-bs-dismiss="modal" aria-label="Close">{!! __('Close') !!}</a>
            <button type="submit" class="text-16-medium add">{!! __('Add') !!}</button>
        </div>
    </form>
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