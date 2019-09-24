@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h1>{{$question->title}}</h1>
                                <div class="ml-auto">
                                    <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">
                                        Back to All Question
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                <a class="vote-up {{auth()->guest() ? 'off' : ''}}" title="This question is useful"
                                   onclick="event.preventDefault(); document.getElementById('up-vote-{{$question->id}}').submit();">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <form id="up-vote-{{$question->id}}" method="post" action="/questions/{{$question->id}}/vote" style="display: none; height: 0;">
                                    @csrf
                                    <input type="hidden" name="vote" value="1">
                                </form>

                                <span class="votes-count">{{$question->votes_count}}</span>

                                <a class="vote-down {{auth()->guest() ? 'off' : ''}}" title="This question is not useful"
                                   onclick="event.preventDefault(); document.getElementById('down-vote-{{$question->id}}').submit();">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <form id="down-vote-{{$question->id}}" method="post" action="/questions/{{$question->id}}/vote" style="display: none; height: 0;">
                                    @csrf
                                    <input type="hidden" name="vote" value="-1">
                                </form>

                                <a class="favorite mt-2 {{auth()->guest() ? 'off' : ($question->is_favorited ? 'favorited' : '')}}"
                                   title="Click to mark as favorite question (Click again to undo)"
                                   onclick="event.preventDefault(); document.getElementById('favorite-question-{{$question->id}}').submit();">
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorites-count">{{$question->favorites_count}}</span>
                                </a>
                                <form id="favorite-question-{{$question->id}}" method="post" action="/questions/{{$question->id}}/favorites" style="display: none; height: 0;">
                                    @csrf
                                    @if ($question->is_favorited)
                                        @method('DELETE')
                                    @endif
                                </form>
                            </div>
                            <div class="media-body">
                                {!! $question->body_html !!}

                                <div class="float-right">
                                <span class="text-muted">
                                    Answered {{$question->created_date}}
                                </span>
                                    <div class="media mt-2">
                                        <a href="{{$question->user->url}}" class="pr-2">
                                            <img src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('answers.partials._answer-list', ['answers'=>$question->answers, 'answersCount'=>$question->answers_count])
        @include('answers.partials._create')
    </div>
@endsection
