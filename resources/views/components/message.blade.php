@if(session()->has('success'))
    <div class="alert alert-success  alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session()->get('success') }}.
        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger  alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ session()->get('error') }}.
        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="btn-errors-close">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close btn-errors-close" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div id="ajax_res_success" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none">
    <strong>Success!</strong> <span id="ajax_msg_success"></span>
    <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
</div>

<div id="ajax_res_danger" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none">
    <strong>Error!</strong> <span id="ajax_msg_danger"></span>
    <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
</div>