<?php

use App\Models\Poll;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

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

Route::post('/polls', function () {
    $poll = new Poll;

    $poll->question_text = request('question_text');
    $poll->choice_1 = request('question_choice_1');
    $poll->choice_2 = request('question_choice_2');
    $poll->choice_3 = request('question_choice_3');

    $poll->save();

    dd('Sondage créé avec succès!');
});

Route::get('/polls/{id}', function ($id) {
    $poll = Poll::findOrFail($id);

    return view('polls.show', compact('poll'));
});

Route::post('/polls/{id}/vote', function ($id) {


    Cache::store('file')->increment($id . request('choice'));

    $score = request('choice') . ' à été selectioné ' . Cache::store('file')->get($id . request('choice')) . ' fois';

    return view('polls.score', compact('score'));
});
