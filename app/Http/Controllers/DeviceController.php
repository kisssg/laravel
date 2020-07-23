<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use App\Imports\ImportDevices;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\ExcelHandle;

class DeviceController extends Controller {

    use ExcelHandle;

    protected $excelTitle = [];

    public function index() {
        $key = \Request::get('s');
        return view('device.index')->withDevices(Device::paginate(50));
    }

    public function show($id, Request $request) {
        $device = Device::where('employee_id','=',$id)->get();
        return response()->json($device);
    }

    public function upload() {
        return view('device.upload');
    }

    public function import() {
        try {
            Excel::import(new ImportDevices(), request()->file('file'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            return back()->withErrors('文件大小超限');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return redirect('device');
    }

    public function export() {
        $key = \Request::get('s');
        $data = collector::where("name_cn", "like", "%" . $key . "%")->get()->toArray();
        return $this->arrayToExcel($data, 'collectors', $this->excelTitle, "A2");
    }

    public function delete(Request $request) {
        $ids = $request->input('ids');
        if ($ids == null) {
            return json_encode($ids);
        }
        foreach ($ids as $id) {
            $collector = collector::findOrFail($id);
            $collector->delete();
        }
        return json_encode($ids);
    }
}
