<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LGAController extends Controller
{
    public function show(Request $request)
    {
        $lga = DB::table('lga')
                ->where('state_id', 25)
                ->get();

        $selected_lga = $request->input('lga_id');

        $result= [];
        $lgaDetail = null;

        if($selected_lga){
            $lgaDetail = DB::table('lga')
                            ->where('lga_id', $selected_lga)
                            ->first();

            $result = DB::table('announced_pu_results')
            ->join('polling_unit', 'announced_pu_results.polling_unit_uniqueid', '=', 'polling_unit.uniqueid')
            ->where('polling_unit.lga_id', $selected_lga)
            ->select('announced_pu_results.party_abbreviation', DB::raw('SUM(announced_pu_results.party_score) as party_score'))
            ->groupBy('announced_pu_results.party_abbreviation')
            ->get();
        }
        
        

        return view('lga_results', compact('lga','result', 'selected_lga', 'lgaDetail'));
    }
}
