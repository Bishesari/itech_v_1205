<?php

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;

new class extends Component {
    public Collection $roles;

    public function mount(): void
    {
        $this->get_roles();
    }

    public function get_roles(): void
    {
        $this->roles = Role::all();
    }

}; ?>

<div>
    <section class="w-full">
        <div class="text-sm mx-auto py-1 max-w-[1000px] relative">
            <p class="text-center font-semibold text-gray-600">{{__('نقشهای کاربری')}}</p>
        </div>
        <table class="mx-auto text-xs text-gray-500 text-center font-semibold">
            <tr class="h-10 text-xs text-gray-600">
                <th class="border w-16 ">{{__('#')}}</th>
                <th class="border w-40 ">{{__('عنوان فارسی')}}</th>
                <th class="border w-40 ">{{__('عنوان لاتین')}}</th>
                <th class="border w-20 ">{{__('تعداد مجوزها')}}</th>
                <th class="border w-20 ">{{__('زمان ثبت')}}</th>
                <th class="border w-20 ">{{__('زمان ویرایش')}}</th>
                <th class="border w-20 ">{{__('عملیات')}}</th>

            </tr>
            @foreach($roles as $role)
                <tr class="hover:bg-sky-50 hover:text-sky-700">
                    <td class="border">{{$role['id']}}</td>
                    <td class="border">{{$role['name_fa']}}</td>
                    <td class="border">{{$role['name_en']}}</td>
                    <td class="border">{{$role->permissions->count()}}</td>

                    <td class="border pt-2 pb-1 px-2" style="direction: ltr">
                        {{substr($role['created'], 0, 10)}}
                        <hr>
                        {{substr($role['created'], 11, 5)}}
                    </td>
                    <td class="border pt-2 pb-1 px-2" style="direction: ltr">
                        {{substr($role['updated'], 0, 10)}}
                        @if($role['updated']) <hr> @endif
                        {{substr($role['updated'], 11, 5)}}
                    </td>
                </tr>
            @endforeach

        </table>

    </section>
</div>
