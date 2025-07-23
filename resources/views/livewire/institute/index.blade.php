<?php

use App\Models\Institute;
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
    #[On('Institute-created')]
    public function institutes()
    {
        return Institute::query()
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);

    }

    #[On('Institute-created')]
    public function reset_page(): void
    {
        $this->resetPage();
    }

    public string $name_fa = '';
    public string $name_en = '';

    public int $editing_id = 0;

    public function edit(Institute $institute): void
    {
        $this->editing_id = $institute['id'];
        $this->name_fa = $institute['name_fa'];
        $this->name_en = $institute['name_en'];
        $this->modal('edit-institute')->show();
    }

    public function update(): void
    {
        $editing_institute = Institute::find($this->editing_id);

        if (($editing_institute['name_fa'] != $this->name_fa) and ($editing_institute['name_en'] != $this->name_en)) {
            $validated = $this->validate([
                'name_fa' => 'required|unique:role|min:2',
                'name_en' => 'required|unique:role|min:3',
            ]);
            $validated['updated'] = j_d_stamp_en();
            $editing_institute->update($validated);
        } elseif (($editing_institute['name_fa'] != $this->name_fa) and ($editing_institute['name_en'] == $this->name_en)) {
            $validated = $this->validate([
                'name_fa' => 'required|unique:role|min:2',
                'name_en' => 'required|min:3',
            ]);
            $validated['updated'] = j_d_stamp_en();
            $editing_institute->update($validated);
        } elseif (($editing_institute['name_fa'] == $this->name_fa) and ($editing_institute['name_en'] != $this->name_en)) {
            $validated = $this->validate([
                'name_fa' => 'required|min:2',
                'name_en' => 'required|unique:role|min:3',
            ]);
            $validated['updated'] = j_d_stamp_en();
            $editing_institute->update($validated);
        }
        $this->modal('edit-role')->close();
        Flux::toast(
            heading: 'انجام شد.',
            text: 'نقش کاربری با موفقیت ویرایش شد.',
            variant: 'success'
        );
    }

    public function reset_edit(): void
    {
        $this->editing_id = 0;
    }

}; ?>

<div>
    <div class="bg-zinc-100 dark:bg-zinc-600 dark:text-zinc-300 py-3 relative">
        <p class="font-semibold text-center">{{__('لیست نقشهای کاربری')}}</p>
        <livewire:institute.create/>
    </div>
    <flux:table :paginate="$this->institutes" class="text-center">
        <flux:table.columns>
            <flux:table.column align="center" sortable :sorted="$sortBy === 'id'" :direction="$sortDirection"
                               wire:click="sort('id')">
                {{__('#')}}
            </flux:table.column>

            <flux:table.column align="center" sortable :sorted="$sortBy === 'short_name'" :direction="$sortDirection"
                               wire:click="sort('short_name')">
                {{__('نام کوتاه')}}
            </flux:table.column>


            <flux:table.column align="center" sortable :sorted="$sortBy === 'full_name'" :direction="$sortDirection"
                               wire:click="sort('full_name')">
                {{__('نام کامل')}}
            </flux:table.column>

            <flux:table.column align="center" sortable :sorted="$sortBy === 'abb'" :direction="$sortDirection"
                               wire:click="sort('abb')">
                {{__('نام اختصاری')}}
            </flux:table.column>

            <flux:table.column align="center" sortable :sorted="$sortBy === 'remain_credit'" :direction="$sortDirection"
                               wire:click="sort('remain_credit')">
                {{__('مانده اعتبار')}}
            </flux:table.column>

            <flux:table.column align="center">{{__('لوگو')}}</flux:table.column>

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
            @foreach ($this->institutes as $institute)
                @php($ed = '')
                @if($institute->id == $editing_id)
                    @php($ed = 'bg-amber-100')
                @endif

                <flux:table.row class="hover:bg-green-50 {{$ed}}" :key="$institute->id">
                    <flux:table.cell class="whitespace-nowrap">{{ $institute->id }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $institute->short_name }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $institute->full_name }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $institute->abb }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $institute->remain_credit }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $institute->logo_url }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        {{substr($institute['created'], 0, 10)}}
                        <hr>
                        {{substr($institute['created'], 11, 5)}}

                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        {{substr($institute['updated'], 0, 10)}}
                        @if($institute['updated'])
                            <hr>
                        @endif
                        {{substr($institute['updated'], 11, 5)}}
                    </flux:table.cell>

                    <flux:table.cell>

                        <flux:button wire:click="edit({{$institute}})" variant="ghost" size="sm" class="cursor-pointer">
                            <flux:icon.pencil-square variant="solid" class="text-amber-500 dark:text-amber-300 size-5"/>
                        </flux:button>
                        <flux:button href="{{URL::signedRoute('show_role', ['role'=>$institute->id])}}" variant="ghost"
                                     size="sm" class="cursor-pointer" wire:navigate>
                            <flux:icon.eye class="text-blue-500 size-5"/>
                        </flux:button>

                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <!-- Edit Modal -->
    <flux:modal @close="reset_edit" variant="flyout" position="left" name="edit-role" :show="$errors->isNotEmpty()"
                focusable class="w-80 md:w-96" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('فرم ویرایش نقش') }}</flux:heading>
                <flux:text class="mt-2">{{ __('توجه کنید این نقش را قبلا تعریف نکرده باشید.') }}</flux:text>
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


