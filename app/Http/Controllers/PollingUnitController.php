<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollingUnitController extends Controller
{
    public function show(Request $request)
    {
        $polling_unit = DB::table('polling_unit')
                            ->select('uniqueid', 'polling_unit_name')
                            ->get();
        
        $selected_polling_unit = $request->input('polling_unit_id');

        $result = [];
        $unitDetail = null;

        if ($selected_polling_unit) {
            $unitDetail = DB::table('polling_unit')
                            ->where('uniqueid', $selected_polling_unit)
                            ->first();

            $result = DB::table('announced_pu_results')
                        ->where('polling_unit_uniqueid', $selected_polling_unit)
                        ->get();
        }

        return view('polling_unit_result', compact('polling_unit', 'result', 'unitDetail', 'selected_polling_unit'));
    }
}
