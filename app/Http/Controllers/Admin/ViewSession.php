<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Format;
use Session;
use  App\Services\BuildTableFormat;
use  App\Http\Controllers\Controller;

class ViewSession extends Controller
{

    public function index()
    {
        $costs = Cost::select('sessionID')->groupBy('sessionID')->get();
        foreach($costs as $cost){
            echo $cost->sessionID;
        }
        return '';
    }

}

