<form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
    @csrf
    @method('PATCH')

    @if (session('status') === 'profile-updated')
        <div class="text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg px-4 py-2">
            Profil berhasil diperbarui.
        </div>
    @endif

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Nama
        </label>
        <input type="text" name="name"
            value="{{ old('name', $user->name) }}"
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#00A39D] focus:border-[#00A39D]">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Email
        </label>
        <input type="email"
            value="{{ $user->email }}"
            disabled
            class="w-full border border-gray-200 rounded-lg p-2 bg-gray-50 text-gray-400 cursor-not-allowed">
        <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah.</p>
    </div>

    <div class="flex justify-end">
        <button type="submit"
            class="bg-[#00A39D] text-white px-5 py-2 rounded-lg hover:bg-[#008C86]">
            Simpan Perubahan
        </button>
    </div>

</form>
