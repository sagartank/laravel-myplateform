@props(['status'])

@php
$classes = ($status)
            ? 'text-white badge text-bg-success'
            : 'text-white badge text-bg-danger';
@endphp
<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $status ? 'Yes' : 'No' }}
</span>
