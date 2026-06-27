<x-app-layout>

<x-slot name="header">
    <h2 class="text-xl font-semibold text-white">
        Tambah User
    </h2>
</x-slot>

<div class="max-w-3xl mx-auto">

    <div class="bg-white shadow rounded-xl p-6">

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="grid gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                         Nama
                    </label>
                    <input type="text"
                        name="name"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#00A39D] focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input type="email"
                        name="email"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#00A39D] focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input type="password"
                        name="password"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#00A39D] focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Role
                    </label>
                    <select name="role"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#00A39D] focus:outline-none">
                        <option value="PPAT">PPAT</option>
                        <option value="BANK">BANK</option>
                    </select>
                </div>

            </div>

            <div class="flex gap-3 mt-6">

                <button
                    class="bg-[#00A39D] hover:bg-[#008b86] text-white px-5 py-2 rounded-lg text-sm font-medium">
                    Simpan
                </button>

                <a href="{{ route('users.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded-lg text-sm">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

</x-app-layout>