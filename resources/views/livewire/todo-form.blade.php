<div>
    <form wire:submit='createTodo'>
        <x-text-input wire:model='todoName' />
        <x-input-error :messages="$errors->get('todoName')" />

        <x-primary-button wire:loading.attr="disabled">
            {{ __('Create') }}
        </x-primary-button>
    </form>
</div>
