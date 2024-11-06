<button {{ $attributes->merge(['type' => 'button', 'class' => 'add-new-btn btn inline-flex items-center border rounded-md transition ease-in-out duration-150']) }}>
    <i class="icon icon-2xl cil-plus"></i> Add New {{ $slot }}
</button>
