@extends('layouts.app')

@section('title', 'Edit To-Do - UKMC Smart Todo')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card card-modern">
                <div class="card-body p-4 p-md-5">
                    <span class="badge text-bg-primary mb-2">UPDATE</span>
                    <h3 class="fw-bold mb-4">Edit To-Do</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('todos.update', $todo->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input
                                name="title"
                                class="form-control"
                                value="{{ old('title', $todo->title) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea
                                name="note"
                                class="form-control"
                                rows="5">{{ old('note', $todo->note) }}</textarea>
                        </div>

                        <div class="form-check mb-4">
                            <input
                                type="checkbox"
                                name="done"
                                value="1"
                                class="form-check-input"
                                id="done"
                                {{ $todo->done ? 'checked' : '' }}>

                            <label class="form-check-label" for="done">
                                Tandai tugas selesai
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary">
                                Simpan Perubahan
                            </button>

                            <a
                                href="{{ route('todos.index') }}"
                                class="btn btn-light">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
