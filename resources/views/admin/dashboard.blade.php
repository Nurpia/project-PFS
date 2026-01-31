@extends('layouts.app')

@section('content')
    <h2>Superadmin Dashboard</h2>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">User Management</h5>
                            <p class="card-text">Total Users: {{ \App\Models\User::count() }}</p>
                        </div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                    <a href="{{ route('superadmin.users.index') }}"
                        class="text-white stretched-link mt-3 d-block text-decoration-none">Manage Users &rarr;</a>
                </div>
            </div>
        </div>
    </div>
@endsection
