@extends('layouts.app')

@section('content')
    <question-page :question-model="{{$question}}"></question-page>
@endsection
