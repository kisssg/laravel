<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collector;
use Illuminate\Validation\Rule;
use App\Imports\ImportCollectors;
use Maatwebsite\Excel\Facades\Excel;

class CollectorController extends Controller
{

    public function index()
    {
        return view('collector.index')->withCollectors(Collector::paginate(30));
    }

    public function show($id)
    {
        return view('collector.show')->withCollector(Collector::findOrFail($id)->toArray());
    }

    public function create()
    {
        return view('collector.create')->withCollector(Collector::findOrFail(88004)->only(['name_cn', 'area', 'city', 'position', 'name_en', 'employee_id',
                            'onboard_date', 'email', 'province', 'city_cn', 'tl', 'sv', 'manager', 'type', 'status',
                            'phone_number', 'cfc_hm_id', 'gc_hm_id', 'person_id', 'district',
        ]));
    }

    public function store(Request $request)
    {
        $request->flash();
        $rules = ['name_en' => 'required|min:3',
            'type' => Rule::in('lli', 'agency'),
            'status' => Rule::in('on-job', 'intern', 'departured'),
            'email' => 'email'
        ];
        $this->validate($request, $rules);
        if (Collector::create($request->only(['name_cn', 'area', 'city', 'position', 'name_en', 'employee_id',
                            'onboard_date', 'email', 'province', 'city_cn', 'tl', 'sv', 'manager', 'type', 'status'])))
        {
            return redirect()->back();
        }
        else
        {
            return redirect()->back()->withInput()->withErrors('添加催收者失败！');
        }
    }

    public function edit($id)
    {
        return view('collector.edit')->withCollector(Collector::findOrFail($id)->toArray());
    }

    public function update($id, Request $request)
    {
        $request->flash();
        $rules = [
            'type' => 'required',
            'type' => Rule::in('lli', 'agency'),
            'status' => Rule::in('on-job', 'intern', 'departured'),
            'email' => 'email',
        ];
        $this->validate($request, $rules);
        $collector = Collector::findOrFail($id)
                ->update($request->only(['name_cn', 'area', 'city', 'position', 'name_en', 'employee_id',
                    'onboard_date', 'email', 'province', 'city_cn', 'tl', 'sv', 'manager', 'type', 'status',
                    'phone_number', 'cfc_hm_id', 'gc_hm_id', 'person_id', 'district',
        ]));
        if ($collector == true)
        {
            return redirect()->back();
        }
        else
        {

            return redirect()->back()->withErrors();
        }
    }

    public function upload()
    {
        return view('collector.upload');
    }

    public function import()
    {
        try {
            Excel::import(new ImportCollectors(), request()->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return back()->withErrors($failures);
        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            return back()->withErrors('文件大小超限');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return redirect('collector');
    }
    public function delete(Request $request){
        $ids=$request->input('ids');
        foreach($ids as $id){
            $collector=Collector::findOrfail($id);
            $collector->delete();
        }
        return json_encode($ids);
    }
    
}
