<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Imports\ImportPayments;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\ExcelHandle;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    use ExcelHandle;

    protected $excelTitle = [];

    public function index()
    {
        $key = \Request::get('s');
        return view('payment.index')->withPayments(Payment::paginate(50));
    }

    public function upload()
    {
        return view('payment.upload');
    }

    public function import()
    {
        try {
            Excel::import(new ImportPayments(), request()->file('file'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            return back()->withErrors('文件大小超限');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return redirect('payment');
    }

    public function export()
    {
        $key = \Request::get('s');
        $data = Collector::where("name_cn", "like", "%" . $key . "%")->get()->toArray();
        return $this->arrayToExcel($data, 'collectors', $this->excelTitle, "A2");
    }

    public function delete(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids == null)
        {
            return json_encode($ids);
        }
        foreach ($ids as $id)
        {
            $collector = Collector::findOrFail($id);
            $collector->delete();
        }
        return json_encode($ids);
    }

}
