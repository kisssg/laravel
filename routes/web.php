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
Route::resource('roles','Permission\RolesController');
Route::resource('permissions','Permission\PermissionsController');
Route::resource('users','Permission\UsersController');
Route::get('/', 'HomeController@index')->middleware('auth');
Route::get('/home', 'HomeController@home');
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
    Route::get('issues',"IssueController@issues");
    Route::get('get-by-eid',"IssueController@findIssuesByEid");
});
Route::resource('issue', 'Issue\IssueController')->middleware('auth');
Route::get('article/{id}', 'ArticleController@show');
Route::post('comment', 'CommentController@store');

Route::post('violation/feedback/{id}', 'Violation\ViolationController@feedbackStore');
Route::group([
    'namespace' => 'Violation',
    'prefix' => 'violation',
    'middleware' => 'auth',
        ], function() {
    Route::get('upload', 'ViolationController@upload');
    Route::post('import', 'ViolationController@import');
    Route::get('search', 'ViolationController@search');
});
Route::post('violation/generate', 'Issue\IssueController@generateViolations')->middleware('auth');
Route::post('violation/propose', 'Violation\ViolationController@proposePunishment')->middleware('auth');
Route::post('violation/set/email', 'Violation\ViolationController@setEmail')->middleware('auth');
Route::get('violation/sendlink/{email}/{id}', 'Violation\ViolationController@sendFeedbackLink')->middleware('auth');
Route::post('violation/sendlinks','Violation\ViolationController@sendFeedbackLinks')->middleware('auth');
Route::resource('violation', 'Violation\ViolationController')->middleware('auth');
Route::get('collector/upload', 'CollectorController@upload')->middleware('auth');
Route::get('collector/export', 'CollectorController@export')->middleware('auth');
Route::post('collector/import', 'CollectorController@import')->middleware('auth');
Route::post('collector/delete', 'CollectorController@delete')->middleware('auth');
Route::get('collector/search', 'CollectorController@searchCollectors')->middleware('auth');
Route::get('collector/del-on-job-lli','CollectorController@deleteOnjobLLIs');
Route::get('collector/get','CollectorController@getCollector');
Route::resource('collector', 'CollectorController')->middleware('auth');
Route::get('payment/upload','PaymentController@upload')->middleware('auth');
Route::post('payment/import','PaymentController@import')->middleware('auth');
Route::resource('payment','PaymentController')->middleware('auth');
Route::get('device/upload','DeviceController@upload')->middleware('auth');
Route::post('device/import',"DeviceController@import")->middleware('auth');
Route::resource('device',"DeviceController")->middleware('auth');// vrd and tablet

Route::get('overview/{id}', 'CollectorController@overview')->middleware('auth');
Route::get('confirm-violation/{id}/{token}', 'Violation\ViolationController@feedback');
Route::get('project/{projectID}/progress','ScoreCard\ProjectController@progress')->middleware('auth');
Route::get('project/{projectID}/chartdata','ScoreCard\ProjectController@chartdata')->middleware('auth');
Route::resource('project/item','ScoreCard\ScoreItemController')->middleware('auth');
Route::resource('project/score','ScoreCard\ScoreController')->middleware('auth');
Route::get('project/data/pick/{id}','ScoreCard\DataToScoreController@pick')->middleware('auth');
Route::get('project/data/batchpick/{id}','ScoreCard\DataToScoreController@batchPick')->middleware('auth');//batchpick
Route::resource('project/data','ScoreCard\DataToScoreController')->middleware('auth');
Route::get("project/search_columns/{id}","ScoreCard\ProjectController@getDiySearchColumns")->middleware('auth');
Route::resource('project','ScoreCard\ProjectController')->middleware('auth');
Route::resource('project/audit','ScoreCard\AuditController')->middleware('auth');
Route::get('concentration/camera/{id}','ConcentrationController@camera')->middleware('auth');
Route::get('concentration',"ConcentrationController@index")->middleware('auth');
Route::get('training-test',"OnlineTestController@getTraingTestResults");
Route::get('online-test',"OnlineTestController@getOnlineTestResults");
Route::get('visit-records',"VisitRecordController@getVisitRecords")->middleware('auth');
Route::get('visit/quality',"VisitRecordController@qualityInfo")->middleware('auth');
Route::get('callback/call-records',"CallbackController@getCallRecords")->middleware('auth');
Route::get('callback/connect-info','CallbackController@connectInfo')->middleware('auth');
Route::get('callback/harass-info','CallbackController@harassInfo')->middleware('auth');
