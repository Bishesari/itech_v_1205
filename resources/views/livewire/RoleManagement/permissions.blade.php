<?php

use App\Models\Permission;
use App\Models\Role;
use Flux\Flux;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

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
    #[On('permission-created')]
    public function permissions()
    {
        return Permission::query()
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);

    }

    #[On('permission-created')]
    public function reset_page(): void
    {
        $this->resetPage();
    }

    public string $name_fa = '';
    public string $name_en = '';

    public int $editing_id = 0;

    public function edit(Permission $permission): void
    {
        $this->editing_id = $permission['id'];
        $this->name_fa = $permission['name_fa'];
        $this->name_en = $permission['name_en'];
        $this->modal('edit-permission')->show();
    }

    public function update(): void
    {
        $editing_permission = Permission::find($this->editing_id);

        if (($editing_permission['name_fa'] != $this->name_fa) and ($editing_permission['name_en'] != $this->name_en)) {
            $validated = $this->validate([
                'name_fa' => 'required|unique:roles|min:2',
                'name_en' => 'required|unique:roles|min:3',
            ]);
            $validated['updated'] = j_d_stamp_en();
            $editing_permission->update($validated);
        } elseif (($editing_permission['name_fa'] != $this->name_fa) and ($editing_permission['name_en'] == $this->name_en)) {
            $validated = $this->validate([
                'name_fa' => 'required|unique:roles|min:2',
                'name_en' => 'required|min:3',
            ]);
            $validated['updated'] = j_d_stamp_en();
            $editing_permission->update($validated);
        } elseif (($editing_permission['name_fa'] == $this->name_fa) and ($editing_permission['name_en'] != $this->name_en)) {
            $validated = $this->validate([
                'name_fa' => 'required|min:2',
                'name_en' => 'required|unique:roles|min:3',
            ]);
            $validated['updated'] = j_d_stamp_en();
            $editing_permission->update($validated);
        }
        $this->modal('edit-permission')->close();
        Flux::toast(
            heading: 'انجام شد.',
            text: 'مجوز با موفقیت ویرایش شد.',
            variant: 'success'
        );
    }

    public function reset_edit()
    {
        $this->editing_id = 0;
    }


}; ?>

<div>
    <div class="bg-zinc-100 dark:bg-zinc-600 dark:text-zinc-300 py-3 relative">
        <p class="font-semibold text-center">{{__('لیست مجوزها')}}</p>
        <livewire:RoleManagement.permission_create/>
    </div>
    <flux:table :paginate="$this->permissions" class="text-center">
        <flux:table.columns>
            <flux:table.column align="center" sortable :sorted="$sortBy === 'id'" :direction="$sortDirection"
                               wire:click="sort('id')">
                {{__('#')}}
            </flux:table.column>

            <flux:table.column align="center" sortable :sorted="$sortBy === 'name_fa'" :direction="$sortDirection"
                               wire:click="sort('name_fa')">
                {{__('عنوان فارسی')}}
            </flux:table.column>


            <flux:table.column align="center" sortable :sorted="$sortBy === 'name_en'" :direction="$sortDirection"
                               wire:click="sort('name_en')">
                {{__('عنوان لاتین')}}
            </flux:table.column>
            <flux:table.column align="center" sortable :sorted="$sortBy === 'created'" :direction="$sortDirection"
                               wire:click="sort('created')">
                {{__('زمان ثبت')}}
            </flux:table.column>

            <flux:table.column align="center" sortable :sorted="$sortBy === 'updated'" :direction="$sortDirection"
                               wire:click="sort('updated')">
                {{__('زمان ویرایش')}}
            </flux:table.column>
            <flux:table.column align="center">{{__('عملیات')}}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->permissions as $permission)
                @php($ed = '')
                @if($permission->id == $editing_id)
                    @php($ed = 'bg-amber-50')
                @endif

                <flux:table.row class="hover:bg-green-50 {{$ed}}" :key="$permission->id">
                    <flux:table.cell class="whitespace-nowrap">{{ $permission->id }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $permission->name_fa }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $permission->name_en }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        {{substr($permission['created'], 0, 10)}}
                        <hr>
                        {{substr($permission['created'], 11, 5)}}

                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        {{substr($permission['updated'], 0, 10)}}
                        @if($permission['updated'])
                            <hr>
                        @endif
                        {{substr($permission['updated'], 11, 5)}}
                    </flux:table.cell>

                    <flux:table.cell>

                        <flux:button wire:click="edit({{$permission}})" variant="ghost" size="sm" class="cursor-pointer">
                            <flux:icon.pencil-square variant="solid" class="text-amber-500 dark:text-amber-300 size-5"/>
                        </flux:button>


                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <!-- Edit Modal -->
    <flux:modal @close="reset_edit" name="edit-permission" :show="$errors->isNotEmpty()" focusable class="w-80 md:w-96"
                :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('فرم ویرایش مجوز') }}</flux:heading>
                <flux:text class="mt-2">{{ __('توجه کنید این مجوز را قبلا تعریف نکرده باشید.') }}</flux:text>
            </div>
            <form wire:submit="update" class="flex flex-col gap-6">
                <flux:input wire:model="name_fa" :label="__('عنوان فارسی')" type="text" class:input="text-center"
                            maxlength="35" required autofocus/>
                <flux:input wire:model="name_en" :label="__('عنوان لاتین')" type="text" class:input="text-center"
                            maxlength="35" required style="direction:ltr"/>
                <div class="flex justify-between space-x-2 rtl:space-x-reverse flex-row-reverse">
                    <flux:button variant="primary" color="orange" type="submit"
                                 class="cursor-pointer">{{ __('ویرایش') }}</flux:button>
                    <flux:modal.close>
                        <flux:button variant="filled" class="cursor-pointer">{{ __('انصراف') }}</flux:button>
                    </flux:modal.close>
                </div>
            </form>
        </div>
    </flux:modal>
</div>


