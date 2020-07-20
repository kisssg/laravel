<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Imports\ImportPayments;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\ExcelHandle;

class PaymentController extends Controller {

    use ExcelHandle;

    protected $excelTitle = [];

    public function index() {
        $key = \Request::get('s');
        return view('payment.index')->withPayments(Payment::paginate(50));
    }

    public function show($id, Request $request) {
      
        $collector = Payment::select("year", "month", "payment", "assign_amt")->selectRaw("payment/assign_amt as rate_recovery")->where('employee_id', $id)->orderBy('year', 'asc', 'month', 'asc')->groupBy('year', 'month', "payment", "assign_amt", "rate_recovery")->get();
        $avg = Payment::selectRaw('year,month, avg(payment) as payment,avg(assign_amt) as assign_amt, avg(payment)/avg(assign_amt) as rate_recovery')->orderBy('year', 'asc', 'month', 'asc')->groupBy("year", "month")->get();
        
        $labels = [];
        $avg_assign_amt = [];
        $avg_payment = [];
        $avg_rate_recovery = [];
        $collector_assign_amt = [];
        $collector_payment = [];
        $collector_rate_recovery = [];
        
        foreach($collector as $item){
            array_push($labels,$item->year.$item->month);
            array_push($collector_assign_amt,$item->assign_amt);
            array_push($collector_payment,$item->payment);        
            array_push($collector_rate_recovery,$item->rate_recovery);            
        }
        foreach($avg as $item){
            array_push($avg_assign_amt,$item->assign_amt);
            array_push($avg_payment,$item->payment);        
            array_push($avg_rate_recovery,$item->rate_recovery);            
        }
        
        $chartdata = [
            "labels" => $labels,
            "datasets" => [
                [
                    "label" => 'avg_assign_amt',
                    "data" => $avg_assign_amt,
                    "stack" => "stack 1",
                    "backgroundColor" => 'lightgrey',
                    "yAxisID" => 'left-y-axis'
                ],
                [
                    "label" => 'avg_payment',
                    "data" => $avg_payment,
                    "stack" => "stack 1",
                    "backgroundColor" => 'lightgreen',
                    "yAxisID" => 'left-y-axis'
                ],
                [
                    "label" => 'avg_rate_recovery',
                    "data" => $avg_rate_recovery,
                    "type" => "line",
                    "borderColor" => "lightgreen",
                    "fill" => false,
                    "yAxisID" => 'right-y-axis'
                ],
                [
                    "label" => 'collector_assign_amt',
                    "data" => $collector_assign_amt,
                    "stack" => "stack 2",
                    "backgroundColor" => 'grey',
                    "yAxisID" => 'left-y-axis'
                ],
                [
                    "label" => 'collector_payment',
                    "data" => $collector_payment,
                    "stack" => "stack 2",
                    "backgroundColor" => 'green',
                    "yAxisID" => 'left-y-axis'
                ],
                [
                    "label" => 'collector_rate_recovery',
                    "data" => $collector_rate_recovery,
                    "type" => "line",
                    "borderColor" => "red",
                    "fill" => false,
                    "yAxisID" => 'right-y-axis'
                ]
            ]
        ];
        return response()->json($chartdata);
    }

    public function upload() {
        return view('payment.upload');
    }

    public function import() {
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
