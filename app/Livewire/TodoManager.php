<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TodoManager extends Component
{
    public Collection $todos;
    public string $todoName;

    public function render(): object
    {
        return view('livewire.todo-manager');
    }

    public function mount(): void
    {
        $this->todos = Auth::user()->todos()->get();
    }

    public function createTodo(): void
    {
        $this->validate([
            'todoName' => 'required|min:3',
        ]);

        $todo = Auth::user()->todos()->create([
            'name' => $this->pull('todoName'),
        ]);

        $this->reset('todoName');
        $this->todos->push($todo);
    }

    public function deleteTodo(int $id): void
    {
        $todo = Auth::user()->todos()->find($id);
        $this->authorize('delete', $todo);

        $todo->delete();
        $this->todos = $this->todos->filter(fn($t) => $t->id !== $id);
    }
}
