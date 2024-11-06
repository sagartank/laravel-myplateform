<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-dark btn waves-effect waves-light inline-flex items-center border rounded-md transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
