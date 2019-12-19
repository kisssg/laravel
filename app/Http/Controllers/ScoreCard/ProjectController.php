<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\ScoreCard;

use App\Http\Controllers\Controller;
use App\ScoreCard\ScoreProject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Description of ProjectController
 *
 * @author Sucre.xu
 */
class ProjectController extends Controller
{

    public function index()
    {
        return view('score.project.index')->withProjects(ScoreProject::all());
    }

    public function show($id, Request $request)
    {
        $project = ScoreProject::findOrFail($id);
        if (!$request->user()->can('use project' . $project->id))
        {
            return "Not authorized!"; //permission controll,permission will be 'use project+project ID'
        }
        $data = new \App\ScoreCard\DataToScore;
        $key = $request->get('s');
        $result = $data->setProject($project)->where(function($query) use ($key) {
                    if (preg_match('/\[range\:(\d{4}\-\d{2}\-\d{2})\s(\d{4}\-\d{2}\-\d{2})\]/', $key, $matches))
                    {
                        $query->whereBetween('ACTION_DATE', [$matches[1], $matches[2]]);
                    }
                })->paginate(50);
        return view('score.project.show')->withProject($project)->withData($result);
    }

    public function create(Request $request)
    {
        if (!$request->user()->can('create projects'))
        {
            return "Have no permission";
        }
        return view('score.project.create');
    }

    public function store(Request $request)
    {
        $request->flash();
        $rules = ['name' => 'required|min:3',
            'description' => 'required',
            'data_to_score' => 'required|min:3|unique:score_projects',
            'score_save_to' => 'required|min:3|unique:score_projects',
            'audit_save_to' => 'required|min:3|unique:score_projects',
            'data_fillable' => 'required',
            'audit_fillable' => 'required',
            'score_fillable' => 'required'
        ];
        $this->validate($request, $rules);
        if (ScoreProject::create($request->only(['name', 'description', 'data_to_score', 'score_save_to', 'audit_save_to', 'data_fillable', 'audit_fillable', 'score_fillable'])))
        {
            return redirect('project');
        }
        return redirect()->back()->withInput()->withErrors('Failed creating!');
    }

    public function edit($id)
    {
        return view('score.project.edit')->withProject(ScoreProject::find($id));
    }

    public function update($id, Request $request)
    {
        $request->flash();
        $rules = ['name' => 'required|min:3',
            'description' => 'required',
            'data_to_score' => ['required', 'min:3', Rule::unique('score_projects')->ignore($id)],
            'score_save_to' => ['required', 'min:3', Rule::unique('score_projects')->ignore($id)],
            'audit_save_to' => ['required', 'min:3', Rule::unique('score_projects')->ignore($id)],
            'data_fillable' => 'required',
            'audit_fillable' => 'required',
            'score_fillable' => 'required'
        ];
        $this->validate($request, $rules);
        $result = ScoreProject::findOrFail($id)
                ->update($request->only(['name', 'description', 'data_to_score', 'score_save_to', 'audit_save_to', 'data_fillable', 'audit_fillable', 'score_fillable']));
        if ($result == true)
        {
            return redirect('project');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors('Failed creating!');
        }
    }

    public function remove()
    {
        
    }

}
