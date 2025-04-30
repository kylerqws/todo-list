<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $todoName = '';

    public function with(): array
    {
        return [
            'todos' => Auth::user()->todos()->get(),
        ];
    }

    public function createTodo(): void
    {
        $this->validate([
            'todoName' => 'required|min:3',
        ]);

        Auth::user()->todos()->create([
            'name' => $this->pull('todoName'),
        ]);
    }

    public function deleteTodo(int $id): void
    {
        $todo = Auth::user()->todos()->find($id);
        $this->authorize('delete', $todo);

        $todo->delete();
    }
}; ?>

<div>
    <form wire:submit='createTodo'>
        <x-text-input wire:model='todoName'/>
        <x-primary-button type="submit">Create</x-primary-button>
        <x-input-error :messages="$errors->get('todoName')"/>
    </form>
    @foreach($todos as $todo)
        <div wire:key='{{ $todo->id }}'>
            <div>{{ $todo->name }}</div>
            <form wire:submit='deleteTodo({{ $todo->id }})'>
                <x-secondary-button type="submit">Delete</x-secondary-button>
            </form>
        </div>
    @endforeach
</div>
