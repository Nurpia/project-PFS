@extends('layouts.auth')

@section('content')
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required value="superadmin@app.com">
        </div>
        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <label class="form-label">Password</label>
                @if (Route::has('password.request'))
                    <a class="small text-decoration-none" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <input type="password" name="password" class="form-control" required value="password">
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">
                    Ingat Saya
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">MASUK</button>
    </form>

    @if($errors->any())
        <div class="alert alert-danger mt-3 small">
            {{ $errors->first() }}
        </div>
    @endif
@endsection