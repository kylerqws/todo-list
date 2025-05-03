<div class="p-2">
    @if($todos->isEmpty())
        @if($this->titleEmptyList)
            <div class="flex items-center justify-center h-14 p-2 text-lg-center text-gray-700">{{ __($this->titleEmptyList) }}</div>
        @endif
    @else
        @if($this->titleList)
            <div class="mt-4 mb-2 text-xs text-gray-400 uppercase">{{ __($this->titleList) }}</div>
        @endif
        @foreach($todos as $todo)
            <div wire:key='{{ $todo->id }}' class="flex items-center h-14 p-2">
                <div class="flex items-center">
                    <button wire:click="toggleStatus({{ $todo->id }})" wire:loading.attr="disabled"
                            class="px-2 rounded-md dark:hover:text-gray-100 dark:active:text-gray-300 transition ease-in-out duration-150 relative focus:outline-none">
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
                </div>
                <div class="w-full px-3">{{ $todo->name }}</div>
                <div class="flex items-center px-6 ml-3">
                    <button wire:click="deleteTodo({{ $todo->id }})" wire:loading.attr="disabled"
                            class="px-2 py-2 rounded-md dark:hover:text-gray-100 dark:active:text-gray-300 transition ease-in-out duration-150 relative focus:outline-none">
                        <svg class="w-4 h-4" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" clip-rule="evenodd" fill="currentColor"
                                  d="M4.11 2.697L2.698 4.11 6.586 8l-3.89 3.89 1.415 1.413L8 9.414l3.89 3.89 1.413-1.415L9.414 8l3.89-3.89-1.415-1.413L8 6.586l-3.89-3.89z" />
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach
    @endisset
</div>
