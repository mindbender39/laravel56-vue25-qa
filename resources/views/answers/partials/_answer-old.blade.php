<div class="media media-item">
    @include('partials._vote', ['model' => $answer])

    <div class="media-body">
        {!! $answer->body_html !!}

        <div class="row">
            <div class="col-4">
                <div class="ml-auto">
                    {{-- this authorization functionality created in AuthServiceProvider using Gate --}}
                    {{--@if (auth()->user()->can('update-question', $answer)) @endif--}}

                    {{-- this authorization functionality created in QuestionPolicy using Policy --}}
                    {{-- instead of using if statement and check with authenticated user we can just use @can directive --}}
                    @can ('update', $answer)
                        <a href="{{route('questions.answers.edit', [$question->id, $answer->id])}}" class="btn btn-outline-info btn-sm">Edit</a>
                    @endcan

                    {{--@if (auth()->user()->can('delete-question', $answer)) @endif--}}
                    @can ('delete', $answer)
                        <form class="d-inline-block" method="post" action="{{route('questions.answers.destroy', [$question->id, $answer->id])}}">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    @endcan
                </div>
            </div>
            <div class="col-4"></div>
            <div class="col-4">
                @include('partials._author', ['model'=>$answer, 'label'=>'Answered'])
            </div>
        </div>
    </div>
</div>
