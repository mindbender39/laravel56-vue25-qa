@if ($answersCount > 0)
    {{-- v-cloak is a attribute that you can add to a element you want to hide, while Vue is mounting.
    Soon as Vue is ready, this attribute is removed. --}}
    <div class="row mt-4" v-cloak>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{"{$answersCount} ". str_plural('Answer', $answersCount)}}</h2>
                    </div>
                    <hr>

                    @include('partials._messages')

                    @foreach($answers as $answer)
                        @include('answers.partials._answer')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
