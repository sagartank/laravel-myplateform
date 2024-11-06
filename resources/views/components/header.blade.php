<div class="d-flex align-items-center justify-content-center justify-content-sm-between">
    <div class="col-sm-6 text-center text-sm-start">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $slot }}
        </h2>
    </div>
    @if(isset($right))
        <div class="col-sm-6 mt-2 mt-sm-0 text-center text-sm-end">
            {{ $right }}
        </div>
    @endif
</div>
