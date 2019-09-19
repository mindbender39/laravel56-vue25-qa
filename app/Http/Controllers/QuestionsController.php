<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // analysing query by using DB::enableQueryLog()
        //\DB::enableQueryLog();
        $questions = Question::with('user')->latest()->paginate(5);

        return view('questions.index', compact('questions'));

        // view query log by using DB::getQueryLog()
        //dd(\DB::getQueryLog());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Question $question)
    {
        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->except('_token'));

        return redirect()->route('questions.index')->with('success', 'Your question has been submitted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');

        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        // Authorization using Gate
        //if (\Gate::allows('update-question', $question)) {
            // move to view
        //}
        // or
        /*if (\Gate::denies('update-question', $question)) {
            abort('403', 'Access denied.');
        }*/

        // Authorization using Policy
        $this->authorize('update', $question);

        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\AskQuestionRequest $request, Question $question)
    {
        // Authorization using Gate
        //if (\Gate::allows('update-question', $question)) {
            // move to view
        //}
        // or
        /*if (\Gate::denies('update-question', $question)) {
            abort('403', 'Access denied.');
        }*/

        // Authorization using Policy
        $this->authorize('update', $question);

        $question->update($request->except('_token'));

        return redirect()->route('questions.index')->with('success', 'Your question has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        // Authorization using Gate
        //if (\Gate::allows('delete-question', $question)) {
            // execute delete
        //}
        // or
        /*if (\Gate::denies('delete-question', $question)) {
            abort('403', 'Access denied.');
        }*/

        // Authorization using Policy
        $this->authorize('delete', $question);

        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Question has been deleted.');
    }
}
