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
        $key = $request->get('s') ?: "[owner:" . $request->user()->name . "]";
        $result = $data->setProject($project)->where(function($query) use ($key, $project) {
                    if (preg_match('/\[range\:(\d{4}\-\d{2}\-\d{2})\s(\d{4}\-\d{2}\-\d{2})\]/', $key, $matches))
                    {
                        $query->whereBetween($project->date_field, [$matches[1], $matches[2]]);
                    }
                    if (preg_match('/\[owner\:(.+?)\]/', $key, $matches1))
                    {
                        $query->where('owner', $matches1[1]);
                    }
                    if (preg_match('/\[checked\:(.+?)\]/', $key, $matches2))
                    {
                        $query->where('checked', $matches2[1]);
                    }
                    if (preg_match('/\[contract_no\:(.+?)\]/', $key, $matches3))
                    {
                        $query->where($project->contract_no_field, $matches3[1]);
                    }
                })->paginate(50)->appends(['s' => $key]);
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
            'score_fillable' => 'required',
            'date_field' => 'required',
            'contract_no_field' => 'required'
        ];
        $this->validate($request, $rules);
        if (ScoreProject::create($request->only(ScoreProject::fillables())))
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
            'score_fillable' => 'required',
            'date_field' => 'required',
            'contract_no_field' => 'required'
        ];
        $this->validate($request, $rules);
        $result = ScoreProject::findOrFail($id)
                ->update($request->all());
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
