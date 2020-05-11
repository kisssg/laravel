<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\ScoreCard;

use App\Http\Controllers\Controller;
use App\ScoreCard\ScoreProject;
use App\ScoreCard\Audit;
use Illuminate\Http\Request;

/**
 * Description of ScoreController
 *
 * @author Sucre.xu
 */
class AuditController extends Controller {

    public function index() {
        try {
            $project = ScoreProject::findOrFail($request->project_id);
            $dataInstance = new Data;
            $data = $dataInstance->setProject($project)->findOrFail($request->data_id);
            if (strtolower($data->owner) != strtolower($request->user()->name)) {
                throw new \Exception('You can\'t update data owned by ' . $data->owner);
            }
            $score = new Score;
            $result = $score->setProject($project);
            $now = date('Y-m-d H:i:s');
            if (count($result->where("data_id", $request->data_id)->get())) {
                /**
                 * if record exists, update it; why firstOrCreate? actually the 'Create' part will never be triggered here,
                 * we only need the 'first-' part, only this way can the fillable() work.
                 * I don't know why this works, don't ask!
                 */
                $record = $result->firstOrCreate(["data_id" => $request->data_id], []);
                $record->fillable(explode(",", $project->score_fillable));
                $record->update($request->all());
                return '{"result":"success","score":' . $record . ',"msg":"score updated at ' . $now . '"}';
            }
            $result->fill($request->all());
            $result->save();
            $data->checked = 1;
            $data->save();
            return '{"result":"success","score":' . $result . ',"msg":"score added at ' . $now . '"}';
        } catch (\Exception $e) {
            return '{"result":"failed","msg":"' . $e->getMessage() . '","score":null}';
        }
    }

    public function create(Request $request) {
        $project = ScoreProject::findOrFail($request->get('project'));
        $audit = new Audit();
        $audit->setProject($project);
        $audit->fill(["1" => '1', "4" => '2', '3' => '3']);
        $audit->save();
        return $audit->fillable;
    }

    public function show(Request $req, $id) {
        $project = ScoreProject::findOrFail($req->get('project'));
        $audit = new Audit();
        $result = $audit->setProject($project)->where("data_id", $id)->first();
        return $result;
    }

    public function store(Request $request) {
        try {
            $project = ScoreProject::findOrFail($request->project_id);
            $audit = new Audit;
            $result = $audit->setProject($project);
            $now = date('Y-m-d H:i:s');
            if (count($result->where("data_id", $request->data_id)->get())) {
                /**
                 * if record exists, update it; why firstOrCreate? actually the 'Create' part will never be triggered here,
                 * we only need the 'first-' part, only this way can the fillable() work.
                 * I don't know why this works, don't ask!
                 */
                $record = $result->firstOrCreate(["data_id" => $request->data_id], []);
                //@todo:check if submittor is the one created it.
                if($record->auditor!=$request->user()->name){
                    throw new \Exception('You can\'t change audit not created by you.');
                }
                $record->fillable(explode(",", $project->audit_fillable));
                $record->update($request->all());
                return '{"result":"success","audit":' . $record . ',"msg":"Audit updated at ' . $now . '"}';
            }
            $result->fill($request->all());
            $result->auditor=$request->user()->name;
            $result->save();
            return '{"result":"success","audit":' . $result . ',"msg":"Audit added at ' . $now . '"}';
        } catch (\Exception $e) {
            return '{"result":"failed","msg":"' . $e->getMessage() . '","audit":null}';
        }        
    }

    public function edit() {
        
    }

    public function update() {
        
    }

}
