<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-8">
                    <h3 class="text-lg font-medium mb-4">Tambah Data User</h3>
                    <form action="{{ route('admin.user.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        @csrf
                        <input type="text" name="name" placeholder="Nama Lengkap" required 
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        
                        <input type="email" name="email" placeholder="Email" required 
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        
                        <input type="password" name="password" placeholder="Password" required 
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        
                        <select name="role" required 
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="peminjam">Peminjam</option>
                        </select>
                        
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md text-sm transition duration-150">
                            Tambah User
                        </button>
                    </form>
                </div>

                <hr class="mb-8">

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                <th class="px-6 py-3 border-b">Nama Lengkap</th>
                                <th class="px-6 py-3 border-b">Email</th>
                                <th class="px-6 py-3 border-b">Role</th>
                                <th class="px-6 py-3 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($users as $u)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ $u->name }}</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ $u->email }}</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-700">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $u->role == 'admin' ? 'bg-red-100 text-red-800' : ($u->role == 'petugas' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($u->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 border-b text-sm text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.user.edit', $u->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-xs font-bold transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.user.destroy', $u->id) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs font-bold transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>