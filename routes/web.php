<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// php artisan make:controller QuestionsController --resource --model=Question
Route::resource('questions', 'QuestionsController')->except('show');

// create answers route nested to questions route
//Route::post('/questions/{question}/answers', 'AnswersController@store')->name('answers.store');
// or by resource route
// we can see those routes using: php artisan route:list --name=questions
// create resource controller with model reference:
// php artisan make:controller AnswersController -r -m Answer
Route::resource('questions.answers', 'AnswersController')->except(['index', 'create', 'show']);

/* slug binding functionality is implemented in RouteServiceProvider */
Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');

Route::post('/answers/{answer}/accept', 'AnswersController@acceptAnswer')->name('answers.accept');
// or we can use Single Action Controller without using @ sign with action name and
// inside controller create an action/function using _invoke(Answer $answer) {}
//Route::post('/answers/{answer}/accept', 'AcceptAnswersController')->name('answers.accept');

Route::post('/questions/{question}/favorites', 'FavoritesController@store')->name('questions.favorite');
Route::delete('/questions/{question}/favorites', 'FavoritesController@destroy')->name('questions.unfavorite');

// single action controller for question votes
Route::post('/questions/{question}/vote', 'VoteQuestionController');

// single action controller for answer votes
Route::post('/answers/{answer}/vote', 'VoteAnswerController');
