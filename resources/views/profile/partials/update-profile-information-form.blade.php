<form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
    @csrf
    @method('PATCH')

    @if (session('status') === 'profile-updated')
        <div class="flex items-center gap-2 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Profil berhasil diperbarui.
        </div>
    @endif

    {{-- Nama --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:ring-2 focus:ring-[#00A39D] focus:border-transparent outline-none transition">
        @error('name')
            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email (read-only) --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
        <div class="relative">
            <input type="email" value="{{ $user->email }}" disabled
                class="w-full border border-gray-100 rounded-lg px-3 py-2.5 text-sm text-gray-400 bg-gray-50 cursor-not-allowed pr-10">
            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-1.5">Email tidak dapat diubah.</p>
    </div>

    <div class="flex justify-end pt-1">
        <button type="submit"
            class="bg-[#00A39D] hover:bg-[#008C86] text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-colors duration-200">
            Simpan Perubahan
        </button>
    </div>

</form>
