<div>
    <form wire:submit='createTodo'>
        <x-text-input wire:model='todoName'/>
        <x-input-error :messages="$errors->get('todoName')"/>

        <x-primary-button wire:loading.attr="disabled">
            {{ __('Create') }}
        </x-primary-button>
    </form>

    @isset($todos)
        @foreach($todos as $todo)
            <div wire:key='{{ $todo->id }}'>
                <div>{{ $todo->name }}</div>

                <x-danger-button wire:click="deleteTodo({{ $todo->id }})" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        @endforeach
    @endisset
</div>
