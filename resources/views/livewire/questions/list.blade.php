<?php

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;

new class extends Component {
    public Collection $questions;

    public function mount(): void
    {
        $this->get_questions();
    }

    public function get_questions(): void
    {
        $this->questions = Question::latest('id')->get();
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
                        <div class="@if($option->is_correct) bg-green-100 italic @endif p-1 text-gray-700">{{$option->text}}</div>
                    @endforeach
                </div>
                <div class="p-2">{{__('توضیح: ')}}{{$question->description}}</div>

            </div>
        @endforeach
        <div>
        </div>
    </section>

</div>
