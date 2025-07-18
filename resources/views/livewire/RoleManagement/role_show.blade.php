<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new class extends Component {
    #[Locked]
    public Role $role;

    public Collection $permissions;

    public function mount()
    {
        $this->get_permissions();

    }

    public function get_permissions()
    {
        $this->permissions = Permission::all();
    }
    public function update($permission_id)
    {


    }



}; ?>

<div>
    <div class="bg-zinc-100 dark:bg-zinc-600 dark:text-zinc-300 py-3 relative">
        <p class="font-semibold text-center">{{__('جزئیات نقش کاربری:')}} ( {{$role['name_fa']}}، {{$role['name_en']}}
            )</p>
        {{--        <livewire:RoleManagement.role_create/>--}}
    </div>

    <flux:checkbox.group wire:model="Subscription" label="Subscription preferences" variant="cards" class="max-sm:flex-col">
        @foreach($permissions as $permission)

            @if($role->permissions->contains('id', $permission->id))
                <flux:checkbox wire:click="update({{$permission->id}})"
                    value="{{$permission->id}}"
                    label="{{$permission->name_fa}}"
                    description="Learn about new features and products."
                    checked
                />
            @else
                <flux:checkbox wire:click="update({{$permission->id}})"
                    value="{{$permission->id}}"
                    label="{{$permission->name_fa}}"
                    description="Learn about new features and products."
                />
            @endif


        @endforeach
    </flux:checkbox.group>

</div>
