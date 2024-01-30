<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Bill;
use App\Models\Period;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

use App\Models\Resident;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BillsController extends Controller
{
    public function responseFormatter($value)
    {
        $data = $value->map(function ($item, $id){

            $start = Carbon::parse($item->begin_date);
            $start->setLocale('RU');

            $string_date = $start->translatedFormat('F Y');

            return [
                'id' => $id+1,
                'fio' => $item->fio,
                'amount_rub' => $item->amount_rub,
                'begin_date' => $item->period->begin_date,
                'end_date' => $item->period->end_date,
                'string_date' => $string_date
            ];
        });
        return $data;
    }

    public function index()
    {
        $data = Period::select('periods.*')
            ->join('bills', 'periods.id', '=', 'bills.period_id')
            ->get();


        $result = [];

        foreach ($data as $value) {
            $date = new DateTime($value['begin_date']);
            $year = $date->format('Y');
            $month = $date->format('m');

            if(!isset($result[$year])){
                $result[$year] = [];
            }

            array_push($result[$year], $month);
        }
        return response()->json($result, 200);
    }

    public function getListByMonth(Request $request)
    {
        $v = Validator::make($request->all(), ['date_point' => ['required', 'date']]);

        if($v->fails()){

            return response()->json($v->messages(), 422);

        } else {
            $date_point = new DateTime($request['date_point']);

            $data = Bill::select('bills.*', 'residents.*')
                ->leftJoin('periods', 'bills.period_id', '=', 'periods.id')
                ->leftJoin('residents', 'bills.resident_id', '=', 'residents.id')
                ->where('periods.begin_date', '<', $date_point)
                ->where('periods.end_date', '>', $date_point)
                ->get();

            $result = $this->responseFormatter($data);

            return response()->json($result, 200);
        }

    }

    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy(Request $request, $id)
    {
            $resident = Bill::find($id);

            $resident->delete();

            return response()->json(Bill::all(), 200);
        }

}
