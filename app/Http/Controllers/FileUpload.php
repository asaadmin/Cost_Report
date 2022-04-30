<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Format;
use Session;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;
use App\Services\BuildTableFormat;

class FileUpload extends Controller
{
    public function index()
    {
        $costs =  Cost::where('sessionID', Session::getId())->get();
        if($costs->count() > 0 && !Session::has('fileUploaded')){
            return redirect('/editdata');
        }
        return view('pages.home', []);
    }

    // /fileupload
    public function saveFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlx,xls,xlsx'
        ]);

        if($request->file())
        {
            $path = $request->file('file')->store('excel-files');
            $sheets = (new FastExcel)->importSheets(storage_path('app/' . $path));
            $this->insertCosts($sheets[0]);
            $this->insertFormat($sheets[1]);
            // delete the file after import
            unlink(storage_path('app/' . $path));
        }
        return back()->with('fileUploaded', 'File Imported Successfully.');
    }

    // /tableView
    public function tableView()
    {
        $tableData = (new BuildTableFormat())->fixData();
        $costs =  Cost::where('sessionID', Session::getId())->get();

        if($costs->isEmpty()){
            return redirect('/');
        }
        return view('pages.tableView', [
            "costs" => Cost::where('sessionID', Session::getId())->get(),
            "tableData" => $tableData
        ]);
    }


    // /reupload
    public function reset()
    {
        Cost::where('sessionID', Session::getId())->delete();
        Format::where('sessionID', Session::getId())->delete();
        return redirect("/");
    }

    // api/cleartables
    public function truncate()
    {
        Cost::Truncate();
        Format::Truncate();
        return response()->json(["success" => true], 200);
    }


    private function insertCosts($rows)
    {
        foreach($rows as $row)
        {
            if(empty($row["Account Number"])) { continue; }
            
            Cost::create([
                "account_no" =>  $row["Account Number"],
				"description" =>  $row["Account Description"],
				"period_cost" => $row["Period Cost"],
				"cost_to_date" => $row["Cost To Date"],
				"pos" => $row["Pos"],
				"total_costs" => $row["Total Costs"],
				"etc" => $row["ETC"],
				"efc" => $row["EFC"],
				"budget" => $row["Budget"],
				"approved_overage" => $row["Approved Overage"],
				"total_budget" =>  $row["Total Budget"],
				"over_under" => $row["Over/(Under)"],
				"variance" => $row["Variance"],
				"last_ctd" => $row["Last_CTD"],
				"last_efc" => $row["Last_EFC"],
				"sessionID" => Session::getId()
            ]);
        }
    }

    private function insertFormat($rows)
    {
        foreach($rows as $row)
        {
            if(!isset($row["Account Number"])) { continue; }
            Format::create([
                "forder" =>  $row["Order"],
				"account_no" =>  $row["Account Number"],
				"description" => $row["Account Description"],
				"heading" => $row["heading"],
				"account" => $row["account"],
				"category" => $row["category"],
				"production" => $row["production"],
				"grand_total" => $row["grand total"],
				"line_type" => $row["line type"],
				"line_top" => $row["line top"],
				"bold" =>  $row["bold"],
				"height_percent" => $row["height %"],
				"sessionID" => Session::getId()
            ]);
        }
    }

    public function tabledata()
    {
        $data = (new BuildTableFormat())->tableDataForTabulator();
        return response()->json($data, 200);
    }

}
