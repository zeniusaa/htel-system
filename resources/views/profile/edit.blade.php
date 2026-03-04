<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white">
                Profile Pengguna
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- UPDATE PROFILE --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-[#00A39D] px-6 py-4">
                    <h3 class="text-white font-semibold">
                        Informasi Profil
                    </h3>
                </div>

                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- UPDATE PASSWORD --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-[#00A39D] px-6 py-4">
                    <h3 class="text-white font-semibold">
                        Ubah Password
                    </h3>
                </div>

                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- DELETE ACCOUNT --}}
            <div class="bg-white rounded-xl shadow-sm border border-red-200 overflow-hidden">
                <div class="bg-red-600 px-6 py-4">
                    <h3 class="text-white font-semibold">
                        Hapus Akun
                    </h3>
                </div>

                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
