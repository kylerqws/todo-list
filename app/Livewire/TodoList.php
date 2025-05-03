<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TodoList extends Component
{
    public ?bool $filterStatus;

    public string $titleList = '';
    public string $titleEmptyList = '';

    public function render(): object
    {
        return view('livewire.todo-list', [
            'todos' => $this->todos(),
        ]);
    }

    #[Computed]
    public function todos(): Collection
    {
        $query = Auth::user()->todos();

        if (is_bool($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        return $query
            ->orderBy('status')
            ->orderByDesc('created_at')
            ->get();
    }

    #[On('todo-created'),On('todo-updated'),On('todo-deleted')]
    public function refresh(): void
    {
        // refresh component after modify todos list
    }

    public function deleteTodo(int $id): void
    {
        $todo = $this->todos()->find($id);
        $this->authorize('delete', $todo);

        $todo->delete();
        $this->dispatch('todo-deleted', id: $todo->id);
    }

    public function toggleStatus(int $id): void
    {
        $todo = $this->todos()->find($id);
        $this->authorize('update', $todo);

        $todo->update(attributes: ['status' => !$todo->status]);
        $this->dispatch('todo-updated', id: $todo->id);
    }
}
