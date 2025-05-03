<div class="p-6 w-full">
    <livewire:todo-form />
    <livewire:todo-list :filter-status="false" :title-empty-list="'List is empty'" />
    <livewire:todo-list :filter-status="true" :title-list="'Completed'" />
</div>
