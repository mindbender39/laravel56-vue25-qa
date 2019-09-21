<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3>Your Answer</h3>
                </div>
                <hr>
                <form method="post" action="{{route('questions.answers.store', $question->id)}}">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" class="form-control {{$errors->has('body') ? 'is-invalid' : ''}}" rows="7"></textarea>

                        @if ($errors->has('body'))
                            <div class="invalid-feedback">
                                <strong>{{$errors->first('body')}}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
