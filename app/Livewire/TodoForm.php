<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TodoForm extends Component
{
    public string $todoName;

    public function render(): object
    {
        return view('livewire.todo-form');
    }

    public function createTodo(): void
    {
        $this->validate([
            'todoName' => 'required|min:3',
        ]);

        $todo = Auth::user()->todos()->create([
            'name' => $this->todoName,
        ]);

        $this->reset('todoName');
        $this->dispatch('todo-created', id: $todo->id);
    }
}
