<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrainingTestResult;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;

/**
 * Description of OnlineTestController
 *
 * @author Sucre.xu
 */
class OnlineTestController extends Controller {

    //put your code here
    public function index(Request $request) {
        $s = $request->get('s');
        return view('training.index')->withTrainings(TrainingTestResult::where(function($query) use($s) {
                            if ($s) {
                                $query->where("employee_id", $s);
                            }
                        })->paginate(50));
    }

    public function upload(Request $request) {
        return view('training.upload');
    }

    public function import() {
        try {
            Excel::import(new \App\Imports\ImportTraingResults(), request()->file('file'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            return back()->withErrors('文件大小超限');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return redirect('training');
    }

    public function show($id) {
        $results = TrainingTestResult::where('employee_id', $id)->get()->toArray();
        return $results;
    }

}
