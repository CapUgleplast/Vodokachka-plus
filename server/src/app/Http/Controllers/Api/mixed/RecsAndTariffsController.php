<?php

namespace App\Http\Controllers\Api\mixed;

use App\Http\Controllers\Api\PeriodsController;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

use App\Models\Period;
use App\Models\Tariff;
use App\Models\PumpMeterRecord;

use Illuminate\Support\Facades\Validator;

class RecsAndTariffsController extends Controller
{
    public function rules()
    {
        return [
          'tariff' => 'sometimes|required_without:record',
          'record' => 'sometimes|required_without:tariff'
        ];
    }

    public function responseFormatter($value)
    {
            $data = $value->map(function ($item, $id){

                $start = Carbon::parse($item->begin_date);
                $start->setLocale('RU');

                $string_date = $start->translatedFormat('F Y');

                return [
                    'id' => $item->period_id,
                    'tariff' => $item->price_per_cubic_meter,
                    'expense' => $item->amount_volume,
                    'period_id' => $item->period_id,
                    'begin_date' => $item->begin_date,
                    'end_date' => $item->end_date,//$av_date->format('Y-m-d'),
                    'string_date' => $string_date
                ];
        });
        return $data;
    }

    public function getCollection()
    {
        $result = Period::select('periods.*', 'tariffs.*', 'pump_meter_records.*')
            ->leftJoin('tariffs', 'periods.id', '=', 'tariffs.period_id')
            ->leftJoin('pump_meter_records', 'periods.id', '=', 'pump_meter_records.period_id')
            ->addSelect('periods.id as period_id')
            ->get();

        return $result;
    }

    public function getPrevious()
    {
        $curr = new DateTime('now');

        $result = Period::select('periods.*', 'tariffs.*', 'pump_meter_records.*')
            ->where('periods.end_date', '<', $curr)
            ->leftJoin('tariffs', 'periods.id', '=', 'tariffs.period_id')
            ->leftJoin('pump_meter_records', 'periods.id', '=', 'pump_meter_records.period_id')
            ->addSelect('periods.id as period_id')
            ->get();

        return $result;
    }

    public function getPlanned()
    {
        $curr = new DateTime('now');

        $result = Period::select('periods.*', 'tariffs.*', 'pump_meter_records.*')
            ->where('periods.begin_date', '>', $curr)
            ->leftJoin('tariffs', 'periods.id', '=', 'tariffs.period_id')
            ->leftJoin('pump_meter_records', 'periods.id', '=', 'pump_meter_records.period_id')
            ->addSelect('periods.id as period_id')
            ->get();

        return $result;
    }

    public function getCurrent()
    {
        $curr = new DateTime('now');

        $data = Period::select('periods.*', 'tariffs.*', 'pump_meter_records.*')
            ->where('periods.begin_date', '<', $curr)
            ->where('periods.end_date', '>', $curr)
            ->leftJoin('tariffs', 'periods.id', '=', 'tariffs.period_id')
            ->leftJoin('pump_meter_records', 'periods.id', '=', 'pump_meter_records.period_id')
            ->addSelect('periods.id as period_id')
            ->get();

        if($data == null){
            $begin_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::now()->endOfMonth();

            $data = new Period();

            $data->begin_date = $begin_date;
            $data->end_date = $end_date;

            $data->save();
        }

        return $data;
    }

    public function getPlannedSQL(): \Illuminate\Http\JsonResponse
    {
        $data = $this->responseFormatter($this->getPlanned());

        return response()->json($data, 200);
    }

    public function getCurrentSQL(): \Illuminate\Http\JsonResponse
    {
        $data = $this->responseFormatter($this->getCurrent());

        return response()->json($data, 200);
    }

    public function getPreviousSQL(): \Illuminate\Http\JsonResponse
    {
        $data = $this->responseFormatter($this->getPrevious());


        return response()->json($data, 200);
    }



    public function index(): \Illuminate\Http\JsonResponse
    {
        $this->getCurrent();

        $data = $this->responseFormatter($this->getCollection());

        /*$separated = $data.map(function ($item, $id) {
            $past = [];
            $current = [];
            $planned = [];


            if($item[''])

            return [

                    ];
            });*/

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {

        $v = Validator::make($request->all(), $this->rules());

        if($v->fails()){

            return response()->json($v->messages(), 422);

        } else {

            return response()->json([], 200);
        }
    }

    public function update(Request $request, $id)
    {

        $v = Validator::make($request->all(), [
            'tariff' => 'sometimes|required_without:record',
            'record' => 'sometimes|required_without:tariff'
        ]);

        if($v->fails()){

            return response()->json($v->messages(), 422);

        } else {
            if(isset($request['tariff'])){
                $tariff = Tariff::where('period_id', '=', $id)->first();

                if(!$tariff){
                    $tariff = new Tariff();
                    $tariff->period_id = $id;
                }

                $tariff->price_per_cubic_meter = $request['tariff'];
                $tariff->save();
            }

            if(isset($request['record'])){
                $record = PumpMeterRecord::where('period_id', '=', $id)->first();

                if(!$record){
                    $record = new PumpMeterRecord();
                    $record->period_id = $id;
                }

                $record->amount_volume = $request['record'];
                $record->save();
            }

            return response()->json('OK', 200);
        }
    }

    public function destroy(Request $request, $id)
    {

            $tariff = Tariff::where('period_id', '=', $id)->first();
            if($tariff){
                $tariff->delete();
            }

            $record = PumpMeterRecord::where('period_id', '=', $id)->first();
            if($record){
                $record->delete();
            }

            PeriodsController::destroy($id);

            return response()->json('OK', 200);
        }

}
