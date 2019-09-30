<div class="media media-item">
    <div class="d-flex flex-column counters">
        <div class="vote">
            <strong>{{$question->votes_count}}</strong>
            {{str_plural('vote', $question->votes_count)}}
        </div>
        <div class="status {{$question->status}}">
            <strong>{{$question->answers_count}}</strong>
            {{str_plural('answer', $question->answers_count)}}
        </div>
        <div class="view">
            {{"{$question->views} ". str_plural('view', $question->views)}}
        </div>
    </div>
    <div class="media-body">
        <div class="d-flex align-items-center">
            <h3 class="mt-0">
                <a href="{{$question->url}}">{{$question->title}}</a>
            </h3>
            <div class="ml-auto">
                {{-- this authorization functionality created in AuthServiceProvider using Gate --}}
                {{--@if (auth()->user()->can('update-question', $question)) @endif--}}

                {{-- this authorization functionality created in QuestionPolicy using Policy --}}
                {{-- instead of using if statement and check with authenticated user we can just use @can directive --}}
                @can ('update', $question)
                    <a href="{{route('questions.edit', $question->id)}}" class="btn btn-outline-info btn-sm">Edit</a>
                @endcan

                {{--@if (auth()->user()->can('delete-question', $question)) @endif--}}
                @can ('delete', $question)
                    <form class="d-inline-block" method="post" action="{{route('questions.destroy', $question->id)}}">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                @endcan
            </div>
        </div>
        <p class="lead">
            Asked by
            <a href="{{$question->user->url}}">{{$question->user->name}}</a>
            <small class="text-muted">{{$question->created_date}}</small>
        </p>
        <div class="excerpt">
            {{$question->excerpt}}
        </div>
    </div>
</div>
