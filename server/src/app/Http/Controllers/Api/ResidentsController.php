<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Resident;

use Illuminate\Support\Facades\Validator;

class ResidentsController extends Controller
{
    public function index()
    {
        $residents = Resident::all();

        return response()->json($residents, 200);
    }

    public function store(Request $request)
    {

        $v = Validator::make($request->all(), Resident::$rules);

        if($v->fails()){

            return response()->json($v->messages(), 422);

        } else {

            $resident = new Resident();

            $resident->fio = $request->fio;
            $resident->area = $request->area;
            $resident->start_date = $request->start_date;

            $resident->save(); //column updated_at was not found

            return response()->json($resident, 200);
        }
    }

    public function update(Request $request, $id)
    {

        $v = Validator::make($request->all(), Resident::$rules);

        if($v->fails()){

            return response()->json($v->messages(), 422);

        } else {

            $resident = Resident::find($id);

            $resident->fio = $request->fio;
            $resident->area = $request->area;
            $resident->start_date = $request->start_date;

            $resident->save();

            return response()->json($resident, 200);
        }
    }

    public function destroy(Request $request, $id)
    {
            $resident = Resident::find($id);

            $resident->delete();

            return response()->json(Resident::all(), 200);
        }

}
