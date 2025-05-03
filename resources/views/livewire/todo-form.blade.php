<div class="p-2">
    <form wire:submit.prevent="createTodo">
        <div class="flex items-center">
            <x-text-input wire:model="todoName" class="w-full" placeholder="{{ __('Enter todo...') }}" />
            <div class="px-2 ml-3">
                <x-primary-button wire:loading.attr="disabled">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </div>
        <div class="mt-2 px-2 h-4">
            <x-input-error :messages="$errors->get('todoName')" />
        </div>
    </form>
</div>
