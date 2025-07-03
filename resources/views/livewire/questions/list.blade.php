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
        $this->questions = Question::all();
    }

}; ?>

<div>
    <section class="w-full">
        <div class="bg-zinc-200 dark:bg-zinc-600 dark:text-zinc-300 mx-auto py-3 max-w-[940px] relative">
            <p class="font-semibold text-center">{{__('لیست سوالات')}}</p>
        </div>
        @foreach($questions as $question)
            <div class="bg-zinc-100 mx-auto my-1 p-1 max-w-[940px]">
                <div class="flex justify-around">
                    <div>{{__('شناسه : ')}}{{$question->id}}</div>
                    <div>{{__('درجه سختی : ')}}{{$question->level->title}}</div>
                </div>
                <div>{{$question->text}}</div>
                <div class="flex justify-around mt-2">
                    @foreach($question->options as $option)

                        <div class="@if($option->is_correct) text-green-600  @endif">{{$option->text}}</div>
                    @endforeach
                </div>

            </div>
        @endforeach
        <div>
        </div>
    </section>

</div>
