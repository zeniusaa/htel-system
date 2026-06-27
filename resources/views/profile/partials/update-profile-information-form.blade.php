<section class="space-y-6">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Nama
        </label>
        <input type="text" name="name"
            value="{{ old('name', $user->name) }}"
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#00A39D] focus:border-[#00A39D]">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Email
        </label>
        <input type="email" name="email"
            value="{{ old('email', $user->email) }}"
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#00A39D] focus:border-[#00A39D]">
    </div>

    <div class="flex justify-end">
        <button type="submit"
            class="bg-[#00A39D] text-white px-5 py-2 rounded-lg hover:bg-[#008C86]">
            Simpan Perubahan
        </button>
    </div>

</section>