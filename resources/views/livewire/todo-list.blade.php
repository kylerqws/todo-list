<div class="p-2">
    @isset($todos)
        @foreach($todos as $todo)
            <div wire:key='{{ $todo->id }}' class="flex items-center h-14">
                <input type="checkbox" wire:click="toggleStatus({{ $todo->id }})" @checked($todo->status) />
                <div class="w-full">{{ $todo->name }}</div>
                <div class="px-2 ml-3">
                    <x-danger-button wire:click="deleteTodo({{ $todo->id }})" wire:loading.attr="disabled">
                        {{ __('Delete') }}
                    </x-danger-button>
                </div>
            </div>
        @endforeach
    @endisset
</div>
