<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Resident;

use Illuminate\Support\Facades\Validator;

class PeriodsController extends Controller
{
    public function rules()
    {
        return [
            'date_point' => ['required', 'date'],
        ];
    }

    public function index()
    {
        $data = Period::all();

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {

        $v = Validator::make($request->all(), $this->rules());

        if($v->fails()){

            return response()->json($v->messages(), 422);

        } else {
            $begin_date = Carbon::parse($request['date_point'])->startOfMonth();
            $end_date = Carbon::parse($request['date_point'])->endOfMonth();

            $data = new Period();

            $data->begin_date = $begin_date->format('Y-m-d H:i:s');
            $data->end_date = $end_date->format('Y-m-d H:i:s');

            $data->save();

//            $data['string_date'] = '';

            $begin_date->setLocale('RU');

            $data->string_date = $begin_date->translatedFormat('F Y');

            return response()->json($data, 200);
        }
    }

    public function update(Request $request, $id)
    {

    }

    public static function destroy($id)
    {
            $resident = Period::find($id);

            $resident->delete();

            return response()->json(Period::all(), 200);
        }

}
