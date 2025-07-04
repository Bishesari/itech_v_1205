<?php

use App\Models\Question;
use App\Models\QuestionLevel;
use App\Models\QuestionType;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;

new class extends Component {
    public Collection $questions;
    public Collection $levels;
    public Collection $types;

    public function mount(): void
    {
        $this->get_questions();
        $this->get_levels();
        $this->get_types();
    }

    public function get_questions(): void
    {
        $this->questions = Question::latest('id')->get();
    }

    public function get_levels(): void
    {
        $this->levels = QuestionLevel::all();
    }

    public function get_types(): void
    {
        $this->types = QuestionType::all();
    }

}; ?>

<div>
    <section class="w-full">
        <div class="text-sm mx-auto py-1 max-w-[1000px] relative">
            <p class="text-center">{{__('لیست سوالات')}}</p>
        </div>
        @foreach($questions as $question)
            <div class="border border-gray-400 rounded text-xs mx-auto mb-4 max-w-[1000px]">
                <div class="flex justify-between border-b p-1 text-gray-400">
                    <div>{{__('# ')}}{{$question->id}}</div>
                    <div>{{__('سختی : ')}}{{$question->level->title}}</div>
                    <div>{{__('نوع : ')}}{{$question->type->title}}</div>
                    <div style="direction: ltr">{{__('Created:')}} {{$question->created}}</div>
                    @if($question->updated)
                        <div style="direction: ltr">{{__('Updated:')}} {{$question->updated}}</div>
                    @endif
                </div>
                <div class="border-b p-2 font-medium">{{__('- ')}}{{$question->text}}</div>
                <div class="flex justify-around border-b">
                    @foreach($question->options as $option)
                        <div
                            class="@if($option->is_correct) bg-green-100 italic @endif p-1 text-gray-700">{{$option->text}}</div>
                    @endforeach
                </div>
                <div class="p-2">{{__('توضیح: ')}}{{$question->description}}</div>

            </div>
        @endforeach
        <div>
        </div>
    </section>

    <flux:modal.trigger name="edit-profile">
        <flux:button>Edit profile</flux:button>
    </flux:modal.trigger>

    <flux:modal name="edit-profile" class="md:w-[500px]" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Update profile</flux:heading>
                <flux:text class="mt-2">Make changes to your personal details.</flux:text>
            </div>

            <flux:radio.group wire:model="level_id" label="{{__('درجه سختی')}}" variant="segmented" size="sm">
                @foreach($levels as $level)
                    <flux:radio value="{{$level->id}}" label="{{$level->title}}"/>
                @endforeach
            </flux:radio.group>

            <flux:radio.group wire:model="type_id" label="{{__('نوع سوال')}}" variant="segmented" size="sm">
                @foreach($types as $type)
                    <flux:radio value="{{$type->id}}" label="{{$type->title}}"/>
                @endforeach
            </flux:radio.group>

            <flux:input label="Name" placeholder="Your name"/>

            <flux:input label="Date of birth" type="date"/>

            <div class="flex">
                <flux:spacer/>

                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </div>
        </div>
    </flux:modal>

</div>
