<form method="POST" action="{{ route('password.update') }}" class="space-y-6">
    @csrf
    @method('PUT')

    @if (session('status') === 'password-updated')
        <div class="text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg px-4 py-2">
            Password berhasil diperbarui.
        </div>
    @endif

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Password Lama
        </label>
        <input type="password" name="current_password"
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#00A39D] focus:border-[#00A39D]">
        @error('current_password', 'updatePassword')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Password Baru
        </label>
        <input type="password" name="password"
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#00A39D] focus:border-[#00A39D]">
        @error('password', 'updatePassword')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Konfirmasi Password Baru
        </label>
        <input type="password" name="password_confirmation"
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#00A39D] focus:border-[#00A39D]">
        @error('password_confirmation', 'updatePassword')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end">
        <button type="submit"
            class="bg-[#00A39D] text-white px-5 py-2 rounded-lg hover:bg-[#008C86]">
            Update Password
        </button>
    </div>

</form>
