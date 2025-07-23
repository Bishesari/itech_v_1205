<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new class extends Component {
    #[Locked]
    public Permission $permission;

    public Collection $roles;

    public array $permissionRolesIds;

    public function mount()
    {
        $this->get_roles();
        $this->get_permission_roles_ids();

    }

    public function get_roles(): void
    {
        $this->roles = Role::all();
    }

    public function get_permission_roles_ids(): void
    {
        $this->permissionRolesIds =  $this->permission->roles->pluck('id')->toArray();
    }

    public function toggleRole($role_id): void
    {
        $role = Role::findOrFail($role_id);
        if (in_array($role_id, $this->permissionRolesIds)) {
            $this->permission->roles()->detach($role);
        } else {
            $this->permission->roles()->attach($role, [
                'created' => j_d_stamp_en(),
            ]);
        }
        $this->get_permission_roles_ids();
    }




}; ?>

<div>
    <div class="bg-zinc-100 dark:bg-zinc-600 dark:text-zinc-300 py-3 relative">
        <p class="font-semibold text-center">{{__('جزئیات مجوز کاربری:')}} ( {{$permission['name_fa']}}، {{$permission['name_en']}}
            )</p>
        <section class="absolute left-1 top-2">
            <flux:button href="{{route('permissions')}}" variant="ghost" size="sm" class="cursor-pointer" wire:navigate>
                <flux:icon.arrow-up-circle class="text-blue-500 size-6"/>
            </flux:button>
        </section>

    </div>

        <flux:checkbox.group wire:model="Subscription" label="Subscription preferences" variant="cards" class="max-sm:flex-col">
            <div class="flex flex-wrap justify-start">
            @foreach($roles as $role)
                @if(in_array($role->id, $permissionRolesIds))
                    <flux:checkbox wire:click="toggleRole({{$role->id}})" class="min-w-36 m-2"
                                   value="{{$role->id}}"
                                   label="{{$role->name_fa}}"
                                   description="Learn about new features and products."
                                   checked
                    />
                @else
                    <flux:checkbox wire:click="toggleRole({{$role->id}})" class="min-w-36 m-2"
                                   value="{{$role->id}}"
                                   label="{{$role->name_fa}}"
                                   description="Learn about new features and products."
                    />
                @endif

            @endforeach
            </div>
        </flux:checkbox.group>


</div>
