<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\ScoreCard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ScoreCard\ScoreProject as Project;
use App\ScoreCard\DataToScore as Data;
use Illuminate\Support\Arr;
use Carbon\Carbon;

/**
 * Description of ScoreController
 *
 * @author Sucre.xu
 */
class DataToScoreController extends Controller {

    public function index() {
        return 'index';
    }

    public function create(Request $request) {
        $project = Project::findOrFail($request->get('project_id'));
        $fillable = explode(',', $project->data_fillable);
        $columns = array_diff($fillable, ['owner']);
        return view('score.data.create')->withProject($project)->withColumns($columns);
    }

    public function store(Request $request) {
        $project = Project::findOrFail($request->post('project_id'));
        $required = explode(',', $project->data_new_required);
        $rules = [];
        foreach ($required as $k) {
            if (stripos($k, 'date') !== false) {
                $rules[$k] = "required|regex:/^\d{4}\-\d{2}\-\d{2}$/";
            } elseif (stripos($k, 'number') !== false) {
                $rules[$k] = "numeric";
            } elseif ($k === "type") {
                $rules[$k] = "in:" . $project->data_types_allowed;
            } else {
                $rules[$k] = "required";
            }
        }
        $request->flash();
        $this->validate($request, $rules);
        $data = new Data;
        $result = $data->setProject($project);
        $result->fill($request->all());
        $result->owner = $request->user()->name;
        $contract_field = $project->contract_no_field;
        if ($result->save()) {
            return redirect(url("project/" . $project->id . "?s=[contract_no:" . $result->$contract_field . "]"));
        }
        return redirect()->back()->withInput()->withErrors('Failed creating!');
    }

    public function edit($id, Request $request) {
        $project = Project::findOrFail($request->get('project_id'));
        $fillable = explode(',', $project->data_fillable);
        $columns = array_diff($fillable, ['owner']);
        $dataInstance = new Data();
        $data = $dataInstance->setProject($project)->findOrFail($id);
        return view('score.data.edit')->withData($data)->withProject($project)->withColumns($columns);
    }

    public function update($id, Request $request) {
        $project = Project::findOrFail($request->get('project_id'));
        $required = explode(',', $project->data_new_required);
        $rules = [];
        foreach ($required as $k) {
            if (stripos($k, 'date') !== false) {
                $rules[$k] = "required|regex:/^\d{4}\-\d{2}\-\d{2}$/";
            } elseif (stripos($k, 'number') !== false) {
                $rules[$k] = "numeric";
            } elseif ($k === "type") {
                $rules[$k] = "in:" . $project->data_types_allowed;
            } else {
                $rules[$k] = "required";
            }
        }
        $request->flash();
        $this->validate($request, $rules);
        $dataInstance = new Data();
        $data = $dataInstance->setProject($project)->find($id);
        $data->fillable(explode(",", $project->data_fillable));
        $actor = strtolower($request->user()->name);
        $owner = strtolower($data->owner);
        if ($owner <> $actor && !$request->user()->can('edit data of others in project'.$project->id)) {
            return redirect()->back()->withErrors(['msg' => 'Failed. You can\'t update data not created by you.(01)']);
        }
        $carbon =$data->created_at? Carbon::parse($data->created_at):'1900-01-01';
        $diff = (new Carbon)->diffInMinutes($carbon, true);
        if ($diff > $project->minutes_allow_edit_in && !$request->user()->can('edit data of others in project'.$project->id)) {
            return redirect()->back()->withInput(['msg' => 'You can\'t update the data created too long ago.' . $project->minutes_allow_edit_in]);
        }
        $data->updated_by = $actor;
        if ($data->update($request->all())) {
            return redirect()->back()->withInput(['msg' => "Data updated successfully."]);
        }
        return redirect()->back()->withErrors(['msg' => 'Failed. Try again.']);
    }

    public function destroy($id, Request $request) {
        //return 'destroy';
        $project = Project::findOrFail($request->get("project_id"));
        $dataInstance = new Data;
        $data = $dataInstance->setProject($project)->findOrFail($id);
        if ($data->created_at === null) {
            return redirect()->back()->withInput(['msg' => 'Failed deleting. You can\'t delete data not created by you.(00)']);
        }
        $actor = strtolower($request->user()->name);
        $owner = strtolower($data->owner);
        if ($owner <> $actor) {
            return redirect()->back()->withInput(['msg' => 'Failed deleting. You can\'t delete data not created by you.(01)']);
        }
        $carbon = Carbon::parse($data->created_at);
        $diff = (new Carbon)->diffInMinutes($carbon, true);
        if ($diff > $project->minutes_allow_edit_in) {
            return redirect()->back()->withInput(['msg' => 'You can\'t delete the data created too long ago.' . $project->minutes_allow_edit_in]);
        }
        $result = $data->delete();
        if ($result) {
            return redirect()->back()->withInput(['msg' => 'Data #' . $id . ' removed!']);
        }
        return redirect()->back()->withInput(['msg' => 'Failed deleting.Try again.']);
    }

    public function show($id, Request $request) {
        $project = Project::findOrFail($request->get('project'));
        $onCard = Arr::add(explode(",", $project->data_to_score_columns), '', 'id');
        $data = new Data;
        $result = $data->setProject($project)->findOrFail($id)->only($onCard);
        return $result; //->only(explode(",",$project->data_fillable));//->score($project,$id);
    }

    public function pick($id, Request $request) {
        //set owner to picker if data not picked yet
        try {
            $project = Project::findOrFail($request->get('project_id'));
            $ceil_uncheck = $project->uncheck_ceiling; //max count of data a person can leave uncheck;  
            if ($project->allow_single_pick === 0) {
                throw new \Exception('Single pick not allowed now.');
            }

            $dataInstance = new Data;
            $owner = $request->user()->name;
            $uncheck = $dataInstance->setProject($project)->selectRaw('count(*) as count')->where("owner", $owner)->where('checked', 0)->count();
            if ($uncheck >= $ceil_uncheck) {
                throw new \Exception("You can't pick more as you have data uncheck(" . $uncheck . ") reached ceil " . $ceil_uncheck);
            }
            $data = $dataInstance->setProject($project)->findOrFail($id);
            if ($data->owner !== null && $data->owner !== '') {
                throw new \Exception('Already picked by ' . $data->owner);
            }
            $data->owner = $request->user()->name;
            $data->picked_at = date("Y-m-d H:i:s");
            $data->save();
            return '{"result":"success","owner":"' . $data->owner . '","msg":""}';
        } catch (\Exception $e) {
            return '{"result":"failed","owner":"","msg":"' . $e->getMessage() . '"}';
        }
    }

    public function batchpick($id, Request $request) {
        /**
         * set all selected data to the picker
         */
        try {
            $project = Project::findOrFail($request->get('project_id'));

            $criterias = explode(',', $project->batchpick_depends_on); //['upload_batch', 'AGENT_EMPLOYEE_ID']; //fields that will be checked if align with data clicked
            $ceil_uncheck = $project->uncheck_ceiling; //max count of data a person can leave uncheck;  
            $dataInstance = new Data;
            $owner = $request->user()->name;
            $uncheck = $dataInstance->setProject($project)->selectRaw('count(*) as count')->where("owner", $owner)->where('checked', 0)->count();
            if ($uncheck >= $ceil_uncheck) {
                throw new \Exception("You can't pick more as you have data uncheck(" . $uncheck . ") reached ceil " . $ceil_uncheck);
            }
            $data = $dataInstance->setProject($project)->findOrFail($id);
            $result = $dataInstance->setProject($project)->where(function($query) use ($criterias, $data) {
                        foreach ($criterias as $criteria) {
                            if ($data->$criteria === '' || $data->$criteria === null) {
                                throw new \Exception($criteria . ' blank data can\'t be picked now. ');
                            }
                            $query->where($criteria, $data->$criteria);
                        }
                    })->where('owner', '');
            $count = $result->count();
            if ($count > $ceil_uncheck * 1.5) {
                throw new \Exception('You can\'t pick so much data, batch pick settings might be wrong. Please let the admin know.');
            }
            $update = $result->update(['owner' => $owner, "picked_at" => date('Y-m-d H:i:s')]);
            if ($update === 0) {
                throw new \Exception('You missed, try another.');
            }
            return '{"result":"success","owner":"' . $owner . '","msg":"+' . $update . '"}';
        } catch (\Exception $e) {
            return '{"result":"failed","owner":"","msg":"' . $e->getMessage() . '"}';
        }
    }

}
