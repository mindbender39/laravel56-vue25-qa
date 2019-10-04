@if ($model instanceof \App\Models\Question)
    @php
        $name = 'question';
        $formAction = "/questions/{$model->id}/vote";
    @endphp
@elseif ($model instanceof \App\Models\Answer)
    @php
        $name = 'answer';
        $formAction = "/answers/{$model->id}/vote";
    @endphp
@endif
<div class="d-flex flex-column vote-controls">
    <a class="vote-up {{auth()->guest() ? 'off' : ''}}" title="This {{$name}} is useful"
       onclick="event.preventDefault(); document.getElementById('up-vote-{{$model->id}}').submit();">
        <i class="fas fa-caret-up fa-3x"></i>
    </a>
    <form id="up-vote-{{$model->id}}" method="post" action="{{$formAction}}" style="display: none; height: 0;">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>

    <span class="votes-count">{{$model->votes_count}}</span>

    <a class="vote-down {{auth()->guest() ? 'off' : ''}}" title="This {{$name}} is not useful"
       onclick="event.preventDefault(); document.getElementById('down-vote-{{$model->id}}').submit();">
        <i class="fas fa-caret-down fa-3x"></i>
    </a>
    <form id="down-vote-{{$model->id}}" method="post" action="{{$formAction}}" style="display: none; height: 0;">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>

    @if ($model instanceof \App\Models\Question)
        {{--@include('partials._favorite', ['model' => $model])--}}
        <favorite :question-model="{{$model}}"></favorite>
    @elseif ($model instanceof \App\Models\Answer)
        {{--@include('partials._answer-accept', ['model' => $model])--}}
        <answer-accept :answer-model="{{$model}}"></answer-accept>
    @endif
</div>
