@extends('layouts.app')

@section('title', 'Login - UKMC Smart Todo')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8">

            <div class="brand-gradient text-white p-4 rounded-4 mb-3 shadow-sm">
                <div class="small text-uppercase opacity-75 mb-1">
                    Pemrograman Basis Mobile - Informatika UKMC
                </div>
                <h2 class="fw-bold mb-1">Smart Todo Web</h2>
                <p class="mb-0 opacity-75">
                    Pilih login SQL atau Google Authentication.
                </p>
            </div>

            <div class="card card-modern">
                <div class="card-body p-4 p-md-5">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h4 class="fw-bold mb-4">Login SQL</h4>

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                placeholder="nama@email.com"
                                required
                                autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Minimal 6 karakter"
                                required>
                        </div>

                        <button class="btn btn-primary w-100 py-2">
                            Login SQL
                        </button>
                    </form>

                    <div class="d-flex align-items-center gap-3 my-4">
                        <hr class="flex-grow-1">
                        <span class="text-secondary small">ATAU</span>
                        <hr class="flex-grow-1">
                    </div>

                    <a
                        href="{{ route('google.redirect') }}"
                        class="btn btn-outline-dark w-100 py-2">
                        Masuk dengan Google
                    </a>

                    <p class="text-center mt-4 mb-0 text-secondary">
                        Belum memiliki akun SQL?
                        <a href="{{ route('register') }}" class="fw-semibold">
                            Register
                        </a>
                    </p>
                </div>
            </div>

            <p class="text-center small text-secondary mt-3">
                Dr. Latius Hermawan, S.T., M.Kom.
            </p>
        </div>
    </div>
</div>
@endsection
