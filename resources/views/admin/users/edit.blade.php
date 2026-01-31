@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Edit User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('superadmin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <small class="text-muted">(Leave empty to keep
                                    current)</small></label>
                            <input type="password" name="password" class="form-control" minlength="6">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Superadmin
                                </option>
                                <option value="doctor" {{ $user->role == 'doctor' ? 'selected' : '' }}>Dokter</option>
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (Staff)</option>
                                <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir & Tagihan</option>
                                <option value="apotek" {{ $user->role == 'apotek' ? 'selected' : '' }}>Apotek</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a href="{{ route('superadmin.users.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
