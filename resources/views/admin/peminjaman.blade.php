<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Peminjaman Alat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                    <h3 class="text-lg font-medium mb-6">Data Peminjaman</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                <th class="px-6 py-3 border-b">Nama Peminjam</th>
                                <th class="px-6 py-3 border-b">Nama Alat</th>
                                <th class="px-6 py-3 border-b">Tgl Pinjam</th>
                                <th class="px-6 py-3 border-b">Tgl Kembali</th>
                                <th class="px-6 py-3 border-b">Status</th>
                                <th class="px-6 py-3 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($peminjamans as $p)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ $p->user->name }}</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ $p->alat->nama_alat }}</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ $p->tgl_pinjam }}</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ $p->tgl_kembali ?? '-' }}</td>
                                <td class="px-6 py-4 border-b text-sm">
                                    <span   class="px-2 py-1 inline-flex text-xs font-semibold rounded-full 
                                        {{ $p->status == 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 border-b text-sm text-center">
                                    <form action="{{ route('admin.peminjaman.destroy', $p->id) }}" method="POST" 
                                          onsubmit="return confirm('Hapus data peminjaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs font-bold transition">
                                            Hapus
                                        </button>
                                    </form>
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