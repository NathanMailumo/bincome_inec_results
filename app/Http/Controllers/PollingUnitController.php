<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollingUnitController extends Controller
{
    public function showPolling(Request $request)
    {
        $polling_unit = DB::table('polling_unit')
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

    public function create(Request $request)
    {
        $lgas = DB::table('lga')->where('state_id', 25)->get();
        $parties = DB::table('party')->get();

        $selected_lga = $request->input('lga_id');
        $wards = [];

        if ($selected_lga) {
            $wards = DB::table('ward')->where('lga_id', $selected_lga)->get();
        }

        return view('add_polling_unit', compact('lgas', 'parties', 'selected_lga', 'wards'));
    }

    public function getWards($lga_id)
    {
        $wards = DB::table('ward')->where('lga_id', $lga_id)->get();

        return response()->json($wards);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lga_id' => 'required',
            'ward_id' => 'required',
            'polling_unit_name' => 'required|string|max:255',
            'scores' => 'required|array',
        ]);

        $maxPuId = DB::table('polling_unit')->max('polling_unit_id') ?? 0;
        $nextPuId = $maxPuId + 1;

        $pollingUnitId = DB::table('polling_unit')->insertGetId([
            'polling_unit_id' => $nextPuId,
            'polling_unit_name' => $request->polling_unit_name,
            'ward_id' => $request->ward_id,
            'lga_id' => $request->lga_id,
            'uniquewardid' => $request->ward_id,
            'entered_by_user' => 'Admin',
            'date_entered' => now(),
            'user_ip_address' => $request->ip(),
        ]);

        foreach ($request->scores as $party => $score) {
            DB::table('announced_pu_results')->insert([
                'polling_unit_uniqueid' => $pollingUnitId,
                'party_abbreviation' => substr($party, 0, 4),
                'party_score' => $score ?? 0,
                'entered_by_user' => 'Admin',
                'date_entered' => now(),
                'user_ip_address' => $request->ip(),
            ]);
        }

        return redirect()->back()->with('success', 'Polling Unit and party results successfully recorded!');
    }
}
