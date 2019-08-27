<?php

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */
Auth::routes(['register' => false]);
Route::get('/', 'HomeController@index')->middleware('auth');
Route::get('/home', 'HomeController@index')->middleware('auth');
Route::group([
    'middleware' => 'auth',
    'namespace' => 'Admin',
    'prefix' => 'admin'
        ], function () {
    Route::get('/', 'HomeController@index');
    Route::resource('articles', 'ArticleController');
    Route::resource('comments', 'CommentController');
});
Route::group([
    'middleware' => 'auth',
    'namespace' => 'Issue',
    'prefix' => 'issue'
        ], function() {
    Route::get('upload', 'IssueController@upload');
    Route::post('import', 'IssueController@import');
    Route::get('search', 'IssueController@search');
});
Route::resource('issue','Issue\IssueController')->middleware('auth');
Route::get('article/{id}', 'ArticleController@show');
Route::post('comment', 'CommentController@store');

Route::group([
    'namespace' => 'Violation',
    'prefix' => 'violation',
    'middleware' => 'auth',
        ], function() {
    Route::get('upload', 'ViolationController@upload');
    Route::post('import','ViolationController@import');
    Route::get('search', 'ViolationController@search');
});
Route::resource('violation', 'Violation\ViolationController')->middleware('auth');
Route::get('test/{date}','Issue\IssueController@generateViolations');
Route::get('test','Issue\IssueController@test');
Route::get('collector/upload','CollectorController@upload')->middleware('auth');
Route::get('collector/export','CollectorController@export')->middleware('auth');
Route::post('collector/import','CollectorController@import')->middleware('auth');
Route::post('collector/delete','CollectorController@delete')->middleware('auth');
Route::resource('collector','CollectorController')->middleware('auth');
Route::get('overview/{id}','CollectorController@overview')->middleware('auth');