<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TodoList extends Component
{
    public function render(): object
    {
        return view('livewire.todo-list', [
            'todos' => $this->todos(),
        ]);
    }

    #[Computed]
    public function todos(): Collection
    {
        return Auth::user()->todos()
            ->orderByDesc('created_at')
            ->get();
    }

    #[On('todo-created')]
    public function addTodo(int $id): void
    {
        $todo = $this->todos()->find($id);
        $this->authorize('view', $todo);
    }

    public function deleteTodo(int $id): void
    {
        $todo = $this->todos()->find($id);
        $this->authorize('delete', $todo);

        $todo->delete();
    }

    public function toggleStatus(int $id): void
    {
        $todo = $this->todos()->find($id);
        $this->authorize('update', $todo);

        $todo->update(attributes: ['status' => !$todo->status]);
    }
}
