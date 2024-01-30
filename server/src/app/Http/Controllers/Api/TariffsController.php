<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Resident;

use Illuminate\Support\Facades\Validator;

class TariffsController extends Controller
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
            $date_point = new DateTime($request['date_point']);

            $begin_date = $date_point->startOfMonth();
            $end_date = $date_point->endOfMonth();

            $data = new Period();

            $data->begin_date = $begin_date;
            $data->end_date = $end_date;

            $data->save();

            return response()->json($data, 200);
        }
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy(Request $request, $id)
    {
            $resident = Period::find($id);

            $resident->delete();

            return response()->json(Period::all(), 200);
        }

}
