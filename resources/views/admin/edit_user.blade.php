<form action="{{ route('admin.user.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <input type="text" name="name" value="{{ $user->name }}" required>
    
    <input type="email" name="email" value="{{ $user->email }}" required>
    
    <select name="role">
        <option value="peminjam" {{ $user->role == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
        <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>

    <button type="submit">Update User</button>
    <a href="{{ route('admin.user') }}">Batal</a>
</form>