<?php

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component {
    use \Livewire\WithPagination;

    public $sortBy = 'id';
    public $sortDirection = 'desc';

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function roles()
    {
        return Role::query()
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }


}; ?>

<div>
    <flux:table :paginate="$this->roles">
        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'id'" :direction="$sortDirection"
                               wire:click="sort('id')">{{__('#')}}</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'name_fa'" :direction="$sortDirection"
                               wire:click="sort('name_fa')">{{__('عنوان فارسی')}}</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'name_en'" :direction="$sortDirection"
                               wire:click="sort('name_en')">{{__('عنوان لاتین')}}</flux:table.column>
            <flux:table.column class="w-20 text-center" sortable :sorted="$sortBy === 'created'" :direction="$sortDirection"
                               wire:click="sort('created')">{{__('زمان ثبت')}}
            </flux:table.column>

            <flux:table.column sortable :sorted="$sortBy === 'updated'" :direction="$sortDirection"
                               wire:click="sort('updated')">{{__('زمان ویرایش')}}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->roles as $role)
                <flux:table.row :key="$role->id">
                    <flux:table.cell class="whitespace-nowrap">{{ $role->id }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $role->name_fa }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $role->name_en }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap text-center">
                        {{substr($role['created'], 0, 10)}}
                        <hr>
                        {{substr($role['created'], 11, 5)}}

                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $role->updated }}</flux:table.cell>


                    <flux:table.cell variant="strong">{{ $role->amount }}</flux:table.cell>

                    <flux:table.cell>
                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"
                                     inset="top bottom"></flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>


