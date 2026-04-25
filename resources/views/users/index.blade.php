<x-app-layout>

<x-slot name="header">
    <h2 class="text-xl font-semibold text-white">
        Kelola User
    </h2>
</x-slot>

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-4">

        <a href="{{ route('users.create') }}"
           class="bg-[#00A39D] hover:bg-[#008b86] text-white px-4 py-2 rounded-lg text-sm">
            + Tambah User
        </a>

    </div> 
    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-[#F0FBFA] text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Status PPAT</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($users as $user)

            <tr class="border-t hover:bg-gray-50">

                <td class="px-4 py-3">
                    {{ $user->name }}
                </td>

                <td class="px-4 py-3">
                    {{ $user->email }}
                </td>

                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded text-xs
                        {{ $user->role == 'BANK'
                        ? 'bg-blue-200 text-blue-800'
                        : 'bg-purple-200 text-purple-800' }}">
                        {{ $user->role }}
                    </span>
                </td>

                <td class="px-4 py-3">

                    @if($user->role == 'PPAT')

                        <span class="px-2 py-1 rounded text-xs font-medium
                        {{ $user->status_ppat == 'AKTIF'
                        ? 'bg-green-200 text-green-800'
                        : 'bg-red-200 text-red-800' }}">

                        {{ $user->status_ppat }}

                        </span>

                    @else

                        -

                    @endif

                </td>

                <td class="px-4 py-3">

                    @if($user->role == 'PPAT')

                    <form action="{{ route('users.toggle',$user->id) }}" method="POST">
                        @csrf

                        <button
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                            Toggle Status
                        </button>

                    </form>

                    @else
                    -
                    @endif

                </td>

            </tr>

            @empty

            <tr>
                <td colspan="5" class="text-center py-6 text-gray-500">
                    Belum ada user
                </td>
            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>