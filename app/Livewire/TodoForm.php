<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TodoForm extends Component
{
    #[Validate('required|string|min:3')]
    public string $todoName;

    public function render(): object
    {
        return view('livewire.todo-form');
    }

    public function createTodo(): void
    {
        $this->validate();
        $todo = Auth::user()->todos()->create([
            'name' => $this->todoName,
        ]);

        $this->reset('todoName');
        $this->dispatch('todo-created', id: $todo->id);
    }
}
