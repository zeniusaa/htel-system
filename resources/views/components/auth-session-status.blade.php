@props(['status'])

@if ($status)
    <div {{ $attributes->merge([
        'class' => 'mb-4 p-3 text-sm bg-[#E6F6F5] border border-[#00A39D] text-[#006D69] rounded-lg'
    ]) }}>
        {{ $status }}
    </div>
@endif