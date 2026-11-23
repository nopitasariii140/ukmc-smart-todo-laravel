<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    private function ownerKey(Request $request): string
    {
        $ownerKey = $request->session()->get('owner_key');

        abort_if(!$ownerKey, 403, 'Owner key tidak tersedia.');

        return $ownerKey;
    }

    public function index(Request $request)
    {
        $ownerKey = $this->ownerKey($request);

        $todos = Todo::where('owner_key', $ownerKey)
            ->orderBy('done')
            ->orderByDesc('id')
            ->get();

        $doneCount = $todos->where('done', true)->count();

        return view('todos.index', compact('todos', 'doneCount'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        Todo::create([
            'owner_key' => $this->ownerKey($request),
            'title' => $data['title'],
            'note' => $data['note'] ?? '',
            'done' => false,
        ]);

        return redirect()
            ->route('todos.index')
            ->with('success', 'To-Do berhasil ditambahkan.');
    }

    public function edit(Request $request, int $todo)
    {
        $item = Todo::where('id', $todo)
            ->where('owner_key', $this->ownerKey($request))
            ->firstOrFail();

        return view('todos.edit', ['todo' => $item]);
    }

    public function update(Request $request, int $todo)
    {
        $item = Todo::where('id', $todo)
            ->where('owner_key', $this->ownerKey($request))
            ->firstOrFail();

        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'note' => ['nullable', 'string', 'max:1000'],
            'done' => ['nullable', 'boolean'],
        ]);

        $item->update([
            'title' => $data['title'],
            'note' => $data['note'] ?? '',
            'done' => $request->boolean('done'),
        ]);

        return redirect()
            ->route('todos.index')
            ->with('success', 'To-Do berhasil diperbarui.');
    }

    public function destroy(Request $request, int $todo)
    {
        $item = Todo::where('id', $todo)
            ->where('owner_key', $this->ownerKey($request))
            ->firstOrFail();

        $item->delete();

        return redirect()
            ->route('todos.index')
            ->with('success', 'To-Do berhasil dihapus.');
    }
}
