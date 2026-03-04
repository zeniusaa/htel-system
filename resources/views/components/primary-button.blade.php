<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex justify-center items-center px-4 py-2 bg-[#00A39D] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#008C86] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F8AD3C] transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>