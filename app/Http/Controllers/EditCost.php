<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Format;
use Session;

class EditCost extends Controller
{
    public function index()
    {
        $costs = Cost::where('sessionID', Session::getId());
        $formats = Format::where('sessionID', Session::getId());

        if( ($costs->count() > 0) && ($formats->count() > 0) ){
            return view('pages.tabulator');
        }else{
            $costs->delete();
            $formats->delete();
            return redirect("/");
        }
    }

}
