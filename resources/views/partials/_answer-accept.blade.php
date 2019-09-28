@can('allowAccept', $model)
    <a class="{{$model->status}} mt-2" title="Mark this answer as best answer"
       onclick="event.preventDefault(); document.getElementById('accept-answer-{{$model->id}}').submit();">
        <i class="fas fa-check fa-2x"></i>
    </a>
    <form id="accept-answer-{{$model->id}}" method="post" action="{{route('answers.accept', $model->id)}}" style="display: none; height: 0;">
        @csrf
    </form>
@else
    @if ($model->isBestAnswer)
        <a class="{{$model->status}} mt-2" title="The question owner accepted this answer as best answer">
            <i class="fas fa-check fa-2x"></i>
        </a>
    @endif
@endcan
