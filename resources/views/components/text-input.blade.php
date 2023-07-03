@props(['disabled' => false, 'label' => ''])

<div class="relative">
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            'w-full border border-gray-300 px-4 py-2.5 rounded-md focus:border-[1.5px] focus:border-blue-500 focus:outline-none',
    ]) !!}>
    <label class="input-label text-sm text-blue-500">{{ $label }}</label>
</div>
