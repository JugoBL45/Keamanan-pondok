@extends('layout.main')

@section('title', 'User Management')
@section('subtitle', 'Manajemen Pengguna')

@section('kont')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Pengguna</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#createUserModal"><i class="fas fa-plus mr-1"></i>
                            Buat Pengguna Baru
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <table id="usersTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Foto Profil</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Alamat</th>
                                <th>No-Telpon</th>
                                <th>Role</th>
                                <th>Last Login</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'path/to/default/image.jpg' }}" class="img-thumbnail" width="50" height="50" alt="User Photo">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ $user->role == 1 ? 'Admin' : ($user->role == 2 ? 'Pengurus' : 'Pengasuh') }}</td>
                                    <td>{{ $user->last_login ? $user->last_login->format('Y-m-d H:i:s') : 'Never' }}</td>
                                    <td>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')" style="padding: 5px;">
                                                <i class="fas fa-trash"></i>
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
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createName">Name</label>
                        <input type="text" name="name" id="createName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="createUsername">Username</label>
                        <input type="text" name="username" id="createUsername" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="createPassword">Password</label>
                        <input type="password" name="password" id="createPassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="createPasswordConfirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="createPasswordConfirmation" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="createRole">Role</label>
                        <select name="role" id="createRole" class="form-control" required>
                            <option value="1">Admin</option>
                            <option value="2">Pengurus</option>
                            <option value="3">Pengasuh</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="createAddress">Alamat</label>
                        <input type="text" name="address" id="createAddress" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="createPhoneNumber">No-Telpon</label>
                        <input type="text" name="phone_number" id="createPhoneNumber" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="createProfilePhoto">Foto Profil</label>
                        <input type="file" name="profile_photo" id="createProfilePhoto" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js_vendor')
<script src="{{ asset('assetadmin') }}/plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables (if used) -->
<script src="{{ asset('assetadmin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('assetadmin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable();
    });
</script>
@endpush

@endsection
