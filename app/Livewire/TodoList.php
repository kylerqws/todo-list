<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TodoList extends Component
{
    public Collection $todos;

    public function render(): object
    {
        return view('livewire.todo-list');
    }

    public function mount(): void
    {
        $this->todos = Auth::user()->todos()->get();
    }

    #[On('todo-created')]
    public function addTodo(int $id): void
    {
        $todo = Auth::user()->todos()->find($id);
        $this->authorize('view', $todo);

        $this->todos->prepend($todo);
    }

    public function deleteTodo(int $id): void
    {
        $todo = Auth::user()->todos()->find($id);
        $this->authorize('delete', $todo);

        $todo->delete();
        $this->todos = $this->todos->filter(fn($t) => $t->id !== $id);
    }
}
