<a class="favorite mt-2 {{auth()->guest() ? 'off' : ($model->is_favorited ? 'favorited' : '')}}"
   title="Click to mark as favorite question (Click again to undo)"
   onclick="event.preventDefault(); document.getElementById('favorite-question-{{$model->id}}').submit();">
    <i class="fas fa-star fa-2x"></i>
    <span class="favorites-count">{{$model->favorites_count}}</span>
</a>
<form id="favorite-question-{{$model->id}}" method="post" action="/questions/{{$model->id}}/favorites" style="display: none; height: 0;">
    @csrf
    @if ($model->is_favorited)
        @method('DELETE')
    @endif
</form>
