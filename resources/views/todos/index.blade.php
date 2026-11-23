@extends('layouts.app')

@section('title', 'My To-Do - UKMC Smart Todo')

@section('content')
<div class="container app-shell py-4 py-md-5">

    <div class="brand-gradient text-white rounded-4 p-4 mb-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                @if (auth()->user()->avatar)
                    <img
                        src="{{ auth()->user()->avatar }}"
                        alt="Avatar"
                        width="58"
                        height="58"
                        class="rounded-circle border border-2 border-white object-fit-cover">
                @endif

                <div>
                    <div class="small text-uppercase opacity-75">
                        UKMC Smart Todo
                    </div>
                    <h2 class="fw-bold mb-1">
                        Halo, {{ auth()->user()->name }}
                    </h2>
                    <div class="opacity-75">
                        {{ strtoupper(session('auth_mode', 'SQL')) }}
                        • {{ $doneCount }} dari {{ $todos->count() }} tugas selesai
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-light px-4">
                    Logout
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="row g-4">

        <div class="col-lg-4">
            <div class="card card-modern sticky-lg-top" style="top: 24px;">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-1">Tambah To-Do</h4>
                    <p class="text-secondary small mb-4">
                        Data akan disimpan berdasarkan akun yang sedang login.
                    </p>

                    <form method="POST" action="{{ route('todos.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input
                                name="title"
                                value="{{ old('title') }}"
                                class="form-control"
                                placeholder="Contoh: Kerjakan modul Flutter"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Catatan</label>
                            <textarea
                                name="note"
                                class="form-control"
                                rows="5"
                                placeholder="Catatan tambahan...">{{ old('note') }}</textarea>
                        </div>

                        <button class="btn btn-primary w-100 py-2">
                            + Tambah To-Do
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            @forelse ($todos as $todo)
                <div class="card card-modern mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between gap-3">
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-2 {{ $todo->done ? 'todo-done' : '' }}">
                                    {{ $todo->title }}
                                </h5>
                                <p class="text-secondary mb-0">
                                    {{ $todo->note ?: 'Tidak ada catatan.' }}
                                </p>
                            </div>

                            <span class="badge align-self-start {{ $todo->done ? 'text-bg-success' : 'text-bg-warning' }}">
                                {{ $todo->done ? 'Selesai' : 'Belum' }}
                            </span>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <a
                                href="{{ route('todos.edit', $todo->id) }}"
                                class="btn btn-outline-primary">
                                Edit
                            </a>

                            <form
                                method="POST"
                                action="{{ route('todos.destroy', $todo->id) }}"
                                onsubmit="return confirm('Hapus To-Do ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-outline-danger">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card card-modern">
                    <div class="card-body text-center p-5">
                        <div class="display-6 mb-3">✓</div>
                        <h4 class="fw-bold">Belum ada To-Do</h4>
                        <p class="text-secondary mb-0">
                            Tambahkan tugas pertama dari form di sebelah kiri.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
