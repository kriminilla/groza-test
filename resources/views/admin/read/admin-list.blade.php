@extends('admin.partials.master')

@section('title', 'GROZA | LIST ADMIN')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List Admin</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Admin</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" id="searchInput" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#modal-add">
                                <i class="fas fa-plus"></i> Tambah Admin
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->username }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->role->name }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit-{{ $admin->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="modal-edit-{{ $admin->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Admin</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('daftar.admin.update', $admin->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="editUsername{{ $admin->id }}">Username</label>
                                                                    <input type="text" name="username" class="form-control" id="editUsername{{ $admin->id }}" value="{{ $admin->username }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="editNama{{ $admin->id }}">Nama</label>
                                                                    <input type="text" name="name" class="form-control" id="editNama{{ $admin->id }}" value="{{ $admin->name }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="editEmail{{ $admin->id }}">Email</label>
                                                                    <input type="email" name="email" class="form-control" id="editEmail{{ $admin->id }}" value="{{ $admin->email }}" required>
                                                                </div>
                                                                {{-- <div class="form-group">
                                                                    <label for="editPassword{{ $admin->id }}">Password (kosongkan jika tidak diubah)</label>
                                                                    <input type="password" name="password" class="form-control" id="editPassword{{ $admin->id }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="editPasswordConfirmation{{ $admin->id }}">Konfirmasi Password</label>
                                                                    <input type="password" name="password_confirmation" class="form-control" id="editPasswordConfirmation{{ $admin->id }}">
                                                                </div> --}}
                                                                <div class="form-group">
                                                                    <label for="editRole{{ $admin->id }}">Role</label>
                                                                    <select name="role_id" id="editRole{{ $admin->id }}" class="form-control" required>
                                                                        @foreach($roles as $role)
                                                                            <option value="{{ $role->id }}" {{ $admin->role_id == $role->id ? 'selected' : '' }}>
                                                                                {{ $role->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                                                                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tombol Delete -->
                                            <form action="{{ route('daftar.admin.destroy', $admin->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus admin ini?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada admin</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Add -->
<div class="modal fade" id="modal-add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Admin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('daftar.admin.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputUsername">Username</label>
                        <input type="text" name="username" class="form-control" id="inputUsername" placeholder="Masukkan Username..." required>
                    </div>
                    <div class="form-group">
                        <label for="inputNama">Nama</label>
                        <input type="text" name="name" class="form-control" id="inputNama" placeholder="Masukkan Nama..." required>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Masukkan Email..." required>
                    </div>
                    {{-- <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Masukkan Password..." required>
                    </div>
                    <div class="form-group">
                        <label for="inputPasswordConfirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirmation" placeholder="Ulangi Password..." required>
                    </div> --}}
                    <div class="form-group">
                        <label for="inputRole">Role</label>
                        <select name="role_id" id="inputRole" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
