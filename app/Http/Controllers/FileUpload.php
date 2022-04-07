<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Format;
use Session;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class FileUpload extends Controller
{
    public function index()
    {
        //$session_id = Session::getId();
        // excel-files/CrUu6C8PfCp70Wgz5pvhof9A476GcR3vZ54zdvfF.xlsx
        //$sheets = (new FastExcel)->importSheets(storage_path('app/excel-files/CrUu6C8PfCp70Wgz5pvhof9A476GcR3vZ54zdvfF.xlsx'));
        //dd($sheets[1]);

        return view('pages.home', [
            "costs" => Cost::where('sessionID', Session::getId())->get(),
            "formats" => Format::where('sessionID', Session::getId())->get(),
            "tableData" => $this->fixData()
        ]);
    }


    public function fixData()
    {
        $out['totals'] = [
            "period_cost_Grand" => 0,
            "cost_to_date_Grand"=>0,
            "pos_Grand" => 0,
            "total_costs_Grand"=>0,
            "etc_Grand"=> 0,
            "efc_Grand"=> 0,
            "budget_Grand"=> 0,
            "approved_overage_Grand"=> 0,
            "total_budget_Grand"=>  0,
            "variance_Grand"=> 0,
            "over_under_Grand"=> 0,
            "period_cost_sub"=>0,
            "cost_to_date_sub"=>0,
            "pos_sub"=> 0,
            "total_costs"=>0,
            "etc_sub"=> 0,
            "efc_sub"=> 0,
            "budget_sub"=> 0,
            "approved_overage_sub"=> 0,
            "total_budget_sub"=>  0,
            "variance_sub"=> 0,
            "over_under_sub"=> 0,
            "period_cost_ATL"=>0,
            "cost_to_date_ATL"=>0,
            "pos_ATL"=> 0,
            "total_costs_ATL"=>0,
            "etc_ATL"=> 0,
            "efc_ATL"=> 0,
            "budget_ATL"=> 0,
            "approved_overage_ATL"=> 0,
            "total_budget_ATL"=> 0,
            "variance_ATL"=> 0,
            "over_under_ATL"=>0,					   
            "period_cost_BTL"=>0,
            "cost_to_date_BTL"=>0,
            "pos_BTL"=>0,
            "total_costs_BTL"=>0,
            "etc_BTL"=> 0,
            "efc_BTL"=> 0,
            "budget_BTL"=> 0,
            "approved_overage_BTL"=> 0,
            "total_budget_BTL"=> 0,
            "variance_BTL"=> 0,
            "over_under_BTL"=> 0,					   
            "period_cost_Post"=>0,
            "cost_to_date_Post"=>0,
            "pos_Post"=> 0,
            "total_costs_Post"=>0,
            "etc_Post"=> 0,
            "efc_Post"=> 0,
            "budget_Post"=> 0,
            "approved_overage_Post"=> 0,
            "total_budget_Post"=>  0,
            "variance_Post"=> 0,
            "over_under_Post"=> 0,
            "period_cost_Other"=>0,
            "cost_to_date_Other"=>0,
            "pos_Other"=> 0,
            "total_costs_Other"=>0,
            "etc_Other"=> 0,
            "efc_Other"=> 0,
            "budget_Other"=> 0,
            "approved_overage_Other"=> 0,
            "total_budget_Other"=>  0,
            "variance_Other"=> 0,
            "over_under_Other"=> 0
        ];

        $formats = Format::where('sessionID', Session::getId())->orderBy('forder')->get();
        $i=1;
        foreach($formats as $format)
        {
            $accountCost = Cost::where(['sessionID' => Session::getId(), "account_no" => $format->account_no])->first();
            $getCost = !empty($accountCost) ? $accountCost : $this->emptyCostdata(0);

            $out['rows'][$i]["format"] = $format;
            $out['rows'][$i]["cost"] = $getCost;

            if(!empty($getCost))
            {
                switch ($format->production) {
                    case 'ATL':
                            $out['totals']["period_cost_ATL"] = $out['totals']["period_cost_ATL"]  + $getCost['period_cost'];
                            $out["cost_to_date_ATL"] = $out["totals"]["cost_to_date_ATL"] + $getCost['cost_to_date'];
                            $out["totals"]["pos_ATL"] = $out["totals"]["pos_ATL"]  + $getCost['pos'];
                            $out["totals"]["total_costs_ATL"] =$out["totals"]["total_costs_ATL"]  + $getCost['total_costs'];
                            $out["totals"]["etc_ATL"] = $out["totals"]["etc_ATL"]  + $getCost['etc'];
                            $out["totals"]["efc_ATL"]= $out["totals"]["efc_ATL"]  + $getCost['efc'];
                            $out["totals"]["budget_ATL"] = $out["totals"]["budget_ATL"]  + $getCost['budget'];
                            $out["totals"]["approved_overage_ATL"] = $out["totals"]["approved_overage_ATL"]  + $getCost['approved_overage'];
                            $out["totals"]["total_budget_ATL"] =  $out["totals"]["total_budget_ATL"]  + $getCost['total_budget'];
                            $out["totals"]["variance_ATL"] = $out["totals"]["variance_ATL"]  + $getCost['over_under'];
                            $out["totals"]["over_under_ATL"] = $out["totals"]["over_under_ATL"]  + $getCost['variance'];
                        break;
                    case 'BTL':
                            $out["totals"]["period_cost_BTL"] = $out["totals"]["period_cost_BTL"]  + $getCost['period_cost'];
                            $out["totals"]["cost_to_date_BTL"] = $out["totals"]["cost_to_date_BTL"] + $getCost['cost_to_date'];
                            $out["totals"]["pos_BTL"] = $out["totals"]["pos_BTL"]  + $getCost['pos'];
                            $out["totals"]["total_costs_BTL"] =$out["totals"]["total_costs_BTL"]  + $getCost['total_costs'];
                            $out["totals"]["etc_BTL"] = $out["totals"]["etc_BTL"]  + $getCost['etc'];
                            $out["totals"]["efc_BTL"]= $out["totals"]["efc_BTL"]  + $getCost['efc'];
                            $out["totals"]["budget_BTL"] = $out["totals"]["budget_BTL"]  + $getCost['budget'];
                            $out["totals"]["approved_overage_BTL"] = $out["totals"]["approved_overage_BTL"]  + $getCost['approved_overage'];
                            $out["totals"]["total_budget_BTL"] =  $out["totals"]["total_budget_BTL"]  + $getCost['total_budget'];
                            $out["totals"]["variance_BTL"] = $out["totals"]["variance_BTL"]  + $getCost['over_under'];
                            $out["totals"]["over_under_BTL"] = $out["totals"]["over_under_BTL"]  + $getCost['variance'];
                        break;
                    case 'Post':
                            $out["totals"]["period_cost_Post"] = $out["totals"]["period_cost_Post"]  + $getCost['period_cost'];
                            $out["totals"]["cost_to_date_Post"] = $out["totals"]["cost_to_date_Post"] + $getCost['cost_to_date'];
                            $out["totals"]["pos_Post"] = $out["totals"]["pos_Post"]  + $getCost['pos'];
                            $out["totals"]["total_costs_Post"] =$out["totals"]["total_costs_Post"]  + $getCost['total_costs'];
                            $out["totals"]["etc_Post"] = $out["totals"]["etc_Post"]  + $getCost['etc'];
                            $out["totals"]["efc_Post"]= $out["totals"]["efc_Post"]  + $getCost['efc'];
                            $out["totals"]["budget_Post"] = $out["totals"]["budget_Post"]  + $getCost['budget'];
                            $out["totals"]["approved_overage_Post"] = $out["totals"]["approved_overage_Post"]  + $getCost['approved_overage'];
                            $out["totals"]["total_budget_Post"] =  $out["totals"]["total_budget_Post"]  + $getCost['total_budget'];
                            $out["totals"]["variance_Post"] = $out["totals"]["variance_Post"]  + $getCost['over_under'];
                            $out["totals"]["over_under_Post"] = $out["totals"]["over_under_Post"]  + $getCost['variance'];
                        break;
                    case 'Other':
                            $out["totals"]["period_cost_Other"] = $out["totals"]["period_cost_Other"]  + $getCost['period_cost'];
                            $out["totals"]["cost_to_date_Other"] = $out["totals"]["cost_to_date_Other"] + $getCost['cost_to_date'];
                            $out["totals"]["pos_Other"] = $out["totals"]["pos_Other"]  + $getCost['pos'];
                            $out["totals"]["total_costs_Other"] =$out["totals"]["total_costs_Other"]  + $getCost['total_costs'];
                            $out["totals"]["etc_Other"] = $out["totals"]["etc_Other"]  + $getCost['etc'];
                            $out["totals"]["efc_Other"]= $out["totals"]["efc_Other"] + $getCost['efc'];
                            $out["totals"]["budget_Other"] = $out["totals"]["budget_Other"] + $getCost['budget'];
                            $out["totals"]["approved_overage_Other"] = $out["totals"]["approved_overage_Other"]  + $getCost['approved_overage'];
                            $out["totals"]["total_budget_Other"] =  $out["totals"]["total_budget_Other"]  + $getCost['total_budget'];
                            $out["totals"]["variance_Other"] = $out["totals"]["variance_Other"]  + $getCost['over_under'];
                            $out["totals"]["over_under_Other"] = $out["totals"]["over_under_Other"]  + $getCost['variance'];
                        break;
                }

                $out["totals"]["period_cost_Grand"] =$out["totals"]["period_cost_Grand"] + $getCost['period_cost'];
                $out["totals"]["cost_to_date_Grand"] =$out["totals"]["cost_to_date_Grand"]+ $getCost['cost_to_date'];
                $out["totals"]["pos_Grand"] = $out["totals"]["pos_Grand"] + $getCost['pos'];
                $out["totals"]["total_costs_Grand"] =$out["totals"]["total_costs_Grand"] + $getCost['total_costs'];
                $out["totals"]["etc_Grand"] = $out["totals"]["etc_Grand"] + $getCost['etc'];
                $out["totals"]["efc_Grand"]= $out["totals"]["efc_Grand"] + $getCost['efc'];
                $out["totals"]["budget_Grand"] = $out["totals"]["budget_Grand"] + $getCost['budget'];
                $out["totals"]["approved_overage_Grand"] = $out["totals"]["approved_overage_Grand"] + $getCost['approved_overage'];
                $out["totals"]["total_budget_Grand"] =  $out["totals"]["total_budget_Grand"] + $getCost['total_budget'];
                $out["totals"]["variance_Grand"] = $out["totals"]["variance_Grand"] + $getCost['over_under'];
                $out["totals"]["over_under_Grand"] = $out["totals"]["over_under_Grand"] + $getCost['variance'];
                $out["totals"]["period_cost_sub"] =$out["totals"]["period_cost_sub"] + $getCost['period_cost'];
                $out["totals"]["cost_to_date_sub"] =$out["totals"]["cost_to_date_sub"]+ $getCost['cost_to_date'];
                $out["totals"]["pos_sub"] = $out["totals"]["pos_sub"] + $getCost['pos'];
                $out["totals"]["total_costs"] =$out["totals"]["total_costs"] + $getCost['total_costs'];
                $out["totals"]["etc_sub"] = $out["totals"]["etc_sub"] + $getCost['etc'];
                $out["totals"]["efc_sub"] = $out["totals"]["efc_sub"] + $getCost['efc'];
                $out["totals"]["budget_sub"] = $out["totals"]["budget_sub"] + $getCost['budget'];
                $out["totals"]["approved_overage_sub"] = $out["totals"]["approved_overage_sub"] + $getCost['approved_overage'];
                $out["totals"]["total_budget_sub"] =  $out["totals"]["total_budget_sub"] + $getCost['total_budget'];
                $out["totals"]["variance_sub"] = $out["totals"]["variance_sub"] + $getCost['variance'];
                $out["totals"]["over_under_sub"] = $out["totals"]["over_under_sub"] + $getCost['over_under'];
            }// end cost not empty
            
            if($format->line_type==1 AND $format->line_top==1){
                $out['rows'][$i]['tr_style'] = 'singlelinetoponly '; 
            }
            else if($format->line_type==1 AND $format->line_top==2){
                $out['rows'][$i]['tr_style'] = 'singlelinetopbottom ';
            }
            else if($format->line_type==2 AND $format->line_top==1){
                $out['rows'][$i]['tr_style'] = 'doublelinetoponly '; 
            }
            else if($format->line_type==2 AND $format->line_top==2){
                $out['rows'][$i]['tr_style'] = 'doublelinetopbottom ';
            }
            // condition row 1
            if($format->heading==1 && $format->account==0 && $format->category==0  && $format->production != 'Grand')
            {
                $out['rows'][$i]['row']=[
                    "condition" . $format->account => "condition_1",
                    "description" . $format->account => $format->description,
                    "acct_" . $format->account => $format->account_no,
                    "period_cost" . $format->account => $getCost['period_cost'],
                    "cost_to_date_" . $format->account => $getCost['cost_to_date'],
                    "pos_" . $format->account => $getCost['pos'],
                    "total_costs" . $format->account => $format->account_no,
                    "etc" . $format->account => $getCost['etc'],
                    "efc" . $format->account => $getCost['efc'],
                    "budget" . $format->account => $getCost['budget'],
                    "approved_overage" . $format->account => $getCost['approved_overage'],
                    "total_budget" . $format->account => $getCost['total_budget'],
                    "over_under" . $format->account => $getCost['over_under'],
                    "variance" . $format->account => $getCost['variance'],
                    "last_ctd" . $format->account => $getCost['last_ctd'],
                    "last_efc" . $format->account => $getCost['last_efc'],
                ];
                

            }
            // condition row 2 category total
            else if($format->heading==2 && $format->account==2   && $format->production!='Grand')
            {
                $out['rows'][$i]['row'] = [
                    "condition" . $format->account => "condition_2",
                    "description" . $format->account => $format->description,
                    "acct_" . $format->account => $format->account_no,
                    "period_cost" . $format->account => $out["totals"]["period_cost_sub"],
                    "cost_to_date_" . $format->account => $out["totals"]["cost_to_date_sub"],
                    "pos_" . $format->account => $out["totals"]["pos_sub"],
                    "total_costs" . $format->account => $out["totals"]["total_costs"],
                    "etc" . $format->account => $out["totals"]["etc_sub"],
                    "efc" . $format->account => $out["totals"]["efc_sub"],
                    "budget" . $format->account => $out["totals"]["budget_sub"],
                    "approved_overage" . $format->account => $out["totals"]["approved_overage_sub"],
                    "total_budget" . $format->account => $out["totals"]["total_budget_sub"],
                    "over_under" . $format->account => $out["totals"]["over_under_sub"],
                    "variance" . $format->account => $out["totals"]["variance_sub"],
                    "last_ctd" . $format->account => $getCost['last_ctd'],
                    "last_efc" . $format->account => $getCost['last_efc'],
                ];
                $out["totals"]["period_cost_sub"]=0;
                $out["totals"]["cost_to_date_sub"]=0;
                $out["totals"]["pos_sub"]= 0;
                $out["totals"]["total_costs"]=0;
                $out["totals"]["etc_sub"]= 0;
                $out["totals"]["efc_sub"]=0;
                $out["totals"]["budget_sub"]= 0;
                $out["totals"]["approved_overage_sub"]= 0;
                $out["totals"]["total_budget_sub"]=  0;
                $out["totals"]["over_under_sub"]=0;
                $out["totals"]["variance_sub"]= 0;
            }
            // condition row 3 and above and below the line total
            else if($format->category==0 AND $format->description != ''  AND $format->production!='Grand')
            {
                $out['rows'][$i]['row'] = [
                    "condition" . $format->account => "condition_3",
                    "description" . $format->account => $format->description,
                    "acct_" . $format->account => $format->account_no,
                    "period_cost" . $format->account => $out["totals"]["period_cost_".$format->production],
                    "cost_to_date_" . $format->account => $out["totals"]["cost_to_date_".$format->production],
                    "pos_" . $format->account => $out["totals"]["pos_".$format->production],
                    "total_costs" . $format->account => $out["totals"]["total_costs_".$format->production],
                    "etc" . $format->account => $out["totals"]["etc_".$format->production],
                    "efc" . $format->account => $out["totals"]["efc_".$format->production],
                    "budget" . $format->account => $out["totals"]["budget_".$format->production],
                    "approved_overage" . $format->account => $out["totals"]["approved_overage_".$format->production],
                    "total_budget" . $format->account => $out["totals"]["total_budget_".$format->production],
                    "over_under" . $format->account => $out["totals"]["over_under_".$format->production],
                    "variance" . $format->account => $out["totals"]["variance_".$format->production],
                    "last_ctd" . $format->account => $getCost['last_ctd'],
                    "last_efc" . $format->account => $getCost['last_efc'],
                ];
            }
            // condition row 4
            else if($format->account==1 || $format->category!=0)
            {
                $out['rows'][$i]['row'] = [
                    "condition" . $format->account => $format->account_no,
                    "description" . $format->account => $format->description,
                    "acct_" . $format->account => $format->account_no,
                    "period_cost" . $format->account => $getCost['period_cost'],
                    "cost_to_date_" . $format->account => $getCost["cost_to_date"],
                    "pos_" . $format->account => $getCost["pos"],
                    "total_costs" . $format->account => $getCost["total_costs"],
                    "etc" . $format->account => $getCost["etc"],
                    "efc" . $format->account => $getCost["efc"],
                    "budget" . $format->account => $getCost["budget"],
                    "approved_overage" . $format->account => $getCost["approved_overage"],
                    "total_budget" . $format->account => $getCost["total_budget"],
                    "over_under" . $format->account => $getCost["over_under"],
                    "variance" . $format->account => $getCost["variance"],
                    "last_ctd" . $format->account => $getCost['last_ctd'],
                    "last_efc" . $format->account => $getCost['last_efc'],
                ];
            }else
            {
                $out['rows'][$i]['row'] = [
                    "condition" . $format->account => "Grand Total",
                    "description" . $format->account => "Grand Total",
                    "acct_" . $format->account => $format->account_no,
                    "period_cost" . $format->account => $out["totals"]["period_cost_Grand"],
                    "cost_to_date_" . $format->account => $out["totals"]["cost_to_date_Grand"],
                    "pos_" . $format->account => $out["totals"]["pos_Grand"],
                    "total_costs" . $format->account => $out["totals"]["total_costs_Grand"],
                    "etc" . $format->account => $out["totals"]["etc_Grand"],
                    "efc" . $format->account => $out["totals"]["efc_Grand"],
                    "budget" . $format->account =>$out["totals"]["budget_Grand"],
                    "approved_overage" . $format->account => $out["totals"]["approved_overage_Grand"],
                    "total_budget" . $format->account => $out["totals"]["total_budget_Grand"],
                    "over_under" . $format->account => $out["totals"]["over_under_Grand"],
                    "variance" . $format->account => $out["totals"]["variance_Grand"],
                    "last_ctd" . $format->account => $getCost['last_ctd'],
                    "last_efc" . $format->account => $getCost['last_efc'],
                ];
            }
            
            $i++;
        } // endforeach
        return $out;
    }



    public function save(Request $request)
    {
        Cost::Truncate();
        Format::Truncate();

        $path = $request->file('file')->store('excel-files');
        $sheets = (new FastExcel)->importSheets(storage_path('app/' . $path));
        $this->insertCosts($sheets[0]);
        $this->insertFormat($sheets[1]);
        return redirect('/');
    }

    public function export()
    {
        $sheets = new SheetCollection([
            "Costs" => Cost::all()->makeHidden(['created_at','updated_at', 'sessionID' ]),
            "Formats" => Format::all()->makeHidden(['created_at','updated_at', 'sessionID' ])
        ]);
        (new FastExcel($sheets))->export('file.xlsx');
        return response()->download('file.xlsx');
    }


    public function reset()
    {
        //Cost::Truncate();
        //Format::Truncate();
        Cost::where('sessionID', Session::getId())->delete();
        Format::Truncate('sessionID', Session::getId())->delete();
        return redirect()->back()->with('message', 'IT WORKS!');
    }


    private function insertCosts($rows)
    {
        foreach($rows as $row)
        {
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
            Format::create([
                "forder" =>  $row["Order"],
				"account_no" =>  $row["Account Num"],
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

    private function emptyCostdata($defaultValue)
    {
        return [
            "account_no" => $defaultValue,
            "description" => $defaultValue,
            "period_cost" => $defaultValue,
            "cost_to_date" => $defaultValue,
            "pos" => $defaultValue,
            "total_costs" => $defaultValue,
            "etc" => $defaultValue,
            "efc" => $defaultValue,
            "budget" => $defaultValue,
            "approved_overage" => $defaultValue,
            "total_budget" => $defaultValue,
            "over_under" => $defaultValue,
            "variance" => $defaultValue,
            "last_ctd" => $defaultValue,
            "last_efc" =>$defaultValue
        ];
    }

    public function tabledata()
    {
        $data = $this->fixData();
        $formatData = [];
        foreach($data['rows'] as $row){
            $formatData[]=[
                "id" => $row["format"]->id,
                "account_no" => $row['row']["condition" . $row["format"]->account],
                "description" => $row['row']["description" . $row["format"]->account],
                "period_cost" => $row['row']["period_cost" . $row["format"]->account],
                "cost_to_date" => $row['row']["cost_to_date_" . $row["format"]->account],
                "pos" => $row['row']["pos_" . $row["format"]->account],
                "total_costs" => $row['row']["total_costs" . $row["format"]->account],
                "etc" => $row['row']["etc" . $row["format"]->account],
                "efc" => $row['row']["efc" . $row["format"]->account],
                "budget" => $row['row']["budget" . $row["format"]->account],
                "approved_overage" => $row['row']["approved_overage" . $row["format"]->account],
                "total_budget" => $row['row']["total_budget" . $row["format"]->account],
                "over_under" => $row['row']["over_under" . $row["format"]->account],
                "variance" => $row['row']["variance" . $row["format"]->account],
                "last_ctd" => $row['row']["last_ctd" . $row["format"]->account],
                "last_efc" => $row['row']["last_efc" . $row["format"]->account],
            ];
        }

        return response()->json($formatData, 200);
    }

}
