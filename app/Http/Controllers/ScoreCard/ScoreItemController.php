<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\ScoreCard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ScoreCard\ScoreProject;
use App\ScoreCard\ScoreItem;

/**
 * Description of ScoreItemController
 *
 * @author Sucre.xu
 */
class ScoreItemController extends Controller
{

    public function index(Request $request)
    {
        if ($request->get('json'))
        {
            return ScoreItem::where('project_id', $request->get('project'))->orderBy('order')->get();
        }
        $id = $request->get('project');
        $project = ScoreProject::findOrFail($id);
        return view('score.item.index')->withProject($project);
    }

    public function create(Request $request)
    {
        $id = $request->get('project');
        $project = ScoreProject::findOrFail($id);
        return view('score.item.create')->withProject($project);
    }

    public function store(Request $request)
    {        
        if (!$request->user()->can('edit project'.$request->get('project_id')))
        {
            return "Have no permission";
        }
        $request->flash();
        $rules = [
            "title" => "required|min:3",
            "score_field" => "required",
            "order" => "required",
            "option_type" => "required",
            "options" => "required"
        ];
        $this->validate($request, $rules);
        if (ScoreItem::create($request->only(['project_id', 'title', 'sub_title', 'score_field', 'order', 'option_type', 'options','scores'])) == true)
        {
            return redirect()->back()->withInput(['msg' => '1 item added!']);
        }
        return redirect()->back()->withInput()->withErrors('Failed creating!');
    }

    public function edit($id)
    {
        return view('score.item.edit')->withItem(ScoreItem::findOrFail($id));
    }

    public function update($id, Request $request)
    {        
        if (!$request->user()->can('edit project'.$request->get('project_id')))
        {
            return "Have no permission";
        }
        $request->flash();
        $rules = [
            "title" => "required|min:3",
            "score_field" => "required",
            "order" => "required",
            "option_type" => "required",
            "options" => "required",
            "scores" => "required"
        ];
        $this->validate($request, $rules);
        $result = ScoreItem::findOrFail($id)
                ->update($request->only(['title', 'sub_title', 'score_field', 'order', 'option_type', 'options', 'scores']));
        if ($result == true)
        {
            return redirect('project/item?project=' . $request->get('project_id'));
        }
        return redirect()->back()->withInput()->withErrors('Failed saving updates');
    }

    public function destroy($id)
    {
        ScoreItem::findOrFail($id)->delete();
        return redirect()->back()->withInput(['msg' => 'Item #'.$id.' removed!']);
    }

}
