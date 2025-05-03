<div class="p-2">
    @isset($todos)
        @foreach($todos as $todo)
            <div wire:key='{{ $todo->id }}' class="flex items-center h-14">
                <button type="button" wire:click="toggleStatus({{ $todo->id }})"
                        class="w-6 h-6 relative focus:outline-none">
                    @if ($todo->status)
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="#f97316" stroke-width="2" />
                            <circle cx="12" cy="12" r="6" fill="#f97316" />
                        </svg>
                    @else
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                        </svg>
                    @endif
                </button>
                <div class="w-full ml-3">{{ $todo->name }}</div>
                <div class="px-2 ml-3">
                    <x-danger-button wire:click="deleteTodo({{ $todo->id }})" wire:loading.attr="disabled">
                        {{ __('Delete') }}
                    </x-danger-button>
                </div>
            </div>
        @endforeach
    @endisset
</div>
