<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{$answersCount .' '. str_plural('Answer', $answersCount)}}</h2>
                </div>
                <hr>

                @include('partials._messages')

                @foreach($answers as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a href="#" class="vote-up" title="This answer is useful">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">1230</span>
                            <a href="#" class="vote-down off" title="This answer is not useful">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            @can('allowAccept', $answer)
                                <a class="{{$answer->status}} mt-2" title="Mark this answer as best answer"
                                   onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit();">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                                <form id="accept-answer-{{$answer->id}}" method="post" action="{{route('answers.accept', $answer->id)}}" style="display: none; height: 0;">
                                    @csrf
                                </form>
                            @else
                                @if ($answer->isBestAnswer)
                                    <a class="{{$answer->status}} mt-2" title="The question owner accepted this answer as best answer">
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                @endif
                            @endcan
                        </div>

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
                                        <span class="text-muted">
                                            Answered {{$answer->created_date}}
                                        </span>
                                    <div class="media mt-2">
                                        <a href="{{$answer->user->url}}" class="pr-2">
                                            <img src="{{$answer->user->avatar}}" alt="{{$answer->user->name}}">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{$answer->user->url}}">{{$answer->user->name}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
