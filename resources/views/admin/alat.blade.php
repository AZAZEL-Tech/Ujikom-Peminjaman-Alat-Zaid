<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Alat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('admin.alat.store') }}" method="POST" class="space-y-4 mb-8">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Alat</label>
                        <input type="text" name="nama_alat" placeholder="Contoh: Kabel HDMI 2 Meter" required 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <div class="flex items-end gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="kategori_id" required 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoris as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-32">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                            <input type="number" name="stok" placeholder="0" required 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>

                        <div>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md shadow-sm text-sm transition duration-150">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>

                <hr class="my-6">

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="border px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Nama Alat</th>
                                <th class="border px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Kategori</th>
                                <th class="border px-4 py-2 text-center text-xs font-bold text-gray-500 uppercase">Stok</th>
                                <th class="border px-4 py-2 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($alats as $a)
                            <tr>
                                <td class="border px-4 py-2 text-sm text-gray-800">{{ $a->nama_alat }}</td>
                                <td class="border px-4 py-2 text-sm text-gray-500">{{ $a->kategori->nama_kategori ?? 'N/A' }}</td>
                                <td class="border px-4 py-2 text-sm text-center text-gray-800">{{ $a->stok }}</td>
                                <td class="border px-4 py-2 text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.alat.edit', $a->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    
                                    <form action="{{ route('admin.alat.destroy', $a->id) }}" method="POST" class="inline">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus alat ini?')" class="text-red-600 hover:text-red-900">
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