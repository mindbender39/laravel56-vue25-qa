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
                            {{--@include('partials._vote', ['model' => $question])--}}
                            <vote model-name="question" :model="{{$question}}"></vote>

                            <div class="media-body">
                                {!! $question->body_html !!}

                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        {{--@include('partials._author', ['model'=>$question, 'label'=>'Asked'])--}}
                                        <user-info :model="{{$question}}" label="Asked"></user-info>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--@include('answers.partials._answer-list', ['answers'=>$question->answers, 'answersCount'=>$question->answers_count])--}}
        <answers :question-model="{{$question}}"></answers>
        {{--@include('answers.partials._create')--}}
    </div>
@endsection
