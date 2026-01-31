@extends('layouts.auth')

@section('content')
    <div class="mb-4 text-sm text-muted">
        Lupa kata sandi Anda? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan
        penyetelan ulang kata sandi yang memungkinkan Anda memilih yang baru.
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            @if($errors->has('email'))
                <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="d-flex align-items-center justify-content-between mt-4">
            <a href="{{ route('login') }}" class="text-decoration-none small">
                Kembali ke Login
            </a>
            <button type="submit" class="btn btn-primary">
                Kirim Link Reset
            </button>
        </div>
    </form>
@endsection