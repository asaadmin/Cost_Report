<?php

namespace App\Services;

use App\Models\Cost;
use App\Models\Format;
use Session;

class BuildTableFormat
{

    public $session_id = "";

    public function __construct()
    {
        $this->session_id =  Session::getId();
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

        $formats = Format::where('sessionID', $this->session_id)->orderBy('forder', 'ASC')->get();
        
        $i = 1;
        $cat_total =1;
        $collectCategory=1;
        $producationTotal='';
        
        foreach($formats as $format)
        {
            $accountCost = Cost::where(['sessionID' => $this->session_id, "account_no" => $format->account_no])->first();
            $getCost = !empty($accountCost) ? $accountCost : $this->_emptyCostdata(0);

            // total setup
            if(!empty($getCost))
            {
                switch ($format->production) {
                    // Above the line - Total
                    case 'ATL':
                            $out['totals']["period_cost_ATL"] = $out['totals']["period_cost_ATL"]  + $getCost['period_cost'];
                            $out["totals"]["cost_to_date_ATL"] = $out["totals"]["cost_to_date_ATL"] + $getCost['cost_to_date'];
                            $out["totals"]["pos_ATL"] = $out["totals"]["pos_ATL"]  + $getCost['pos'];
                            $out["totals"]["total_costs_ATL"] =$out["totals"]["total_costs_ATL"]  + $getCost['total_costs'];
                            $out["totals"]["etc_ATL"] = $out["totals"]["etc_ATL"]  + $getCost['etc'];
                            $out["totals"]["efc_ATL"]= $out["totals"]["efc_ATL"]  + $getCost['efc'];
                            $out["totals"]["budget_ATL"] = $out["totals"]["budget_ATL"]  + $getCost['budget'];
                            $out["totals"]["approved_overage_ATL"] = $out["totals"]["approved_overage_ATL"]  + $getCost['approved_overage'];
                            $out["totals"]["total_budget_ATL"] =  $out["totals"]["total_budget_ATL"]  + $getCost['total_budget'];
                            $out["totals"]["over_under_ATL"] = $out["totals"]["over_under_ATL"] + $getCost['over_under'];
                            $out["totals"]["variance_ATL"] = $out["totals"]["variance_ATL"] + $getCost['variance'];
                        break;
                    // Below the lin - total
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
                            $out["totals"]["over_under_BTL"] = $out["totals"]["over_under_BTL"]  + $getCost['over_under'];
                            $out["totals"]["variance_BTL"] = $out["totals"]["variance_BTL"]  + $getCost['variance'];
                        break;
                    // Producation total
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
                            $out["totals"]["over_under_Post"] = $out["totals"]["over_under_Post"]  + $getCost['over_under'];
                            $out["totals"]["variance_Post"] = $out["totals"]["variance_Post"]  + $getCost['variance'];
                        break;
                    // other/ general total
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
                            $out["totals"]["over_under_Other"] = $out["totals"]["over_under_Other"]  + $getCost['over_under'];
                            $out["totals"]["variance_Other"] = $out["totals"]["variance_Other"]  + $getCost['variance'];
                        break;
                }

                // this is total producation total and will be reset
                $out["totals"]["period_cost_sub"] =$out["totals"]["period_cost_sub"] + $getCost['period_cost'];
                $out["totals"]["cost_to_date_sub"] =$out["totals"]["cost_to_date_sub"]+ $getCost['cost_to_date'];
                $out["totals"]["pos_sub"] = $out["totals"]["pos_sub"] + $getCost['pos'];
                $out["totals"]["total_costs"] =$out["totals"]["total_costs"] + $getCost['total_costs'];
                $out["totals"]["etc_sub"] = $out["totals"]["etc_sub"] + $getCost['etc'];
                $out["totals"]["efc_sub"] = $out["totals"]["efc_sub"] + $getCost['efc'];
                $out["totals"]["budget_sub"] = $out["totals"]["budget_sub"] + $getCost['budget'];
                $out["totals"]["approved_overage_sub"] = $out["totals"]["approved_overage_sub"] + $getCost['approved_overage'];
                $out["totals"]["total_budget_sub"] =  $out["totals"]["total_budget_sub"] + $getCost['total_budget'];
                $out["totals"]["over_under_sub"] = $out["totals"]["over_under_sub"] + $getCost['over_under'];
                $out["totals"]["variance_sub"] = $out["totals"]["variance_sub"] + $getCost['variance'];

                // Grand Total
                $out["totals"]["period_cost_Grand"] =$out["totals"]["period_cost_Grand"] + $getCost['period_cost'];
                $out["totals"]["cost_to_date_Grand"] =$out["totals"]["cost_to_date_Grand"]+ $getCost['cost_to_date'];
                $out["totals"]["pos_Grand"] = $out["totals"]["pos_Grand"] + $getCost['pos'];
                $out["totals"]["total_costs_Grand"] =$out["totals"]["total_costs_Grand"] + $getCost['total_costs'];
                $out["totals"]["etc_Grand"] = $out["totals"]["etc_Grand"] + $getCost['etc'];
                $out["totals"]["efc_Grand"]= $out["totals"]["efc_Grand"] + $getCost['efc'];
                $out["totals"]["budget_Grand"] = $out["totals"]["budget_Grand"] + $getCost['budget'];
                $out["totals"]["approved_overage_Grand"] = $out["totals"]["approved_overage_Grand"] + $getCost['approved_overage'];
                $out["totals"]["total_budget_Grand"] =  $out["totals"]["total_budget_Grand"] + $getCost['total_budget'];
                $out["totals"]["over_under_Grand"] = $out["totals"]["over_under_Grand"] + $getCost['over_under'];
                $out["totals"]["variance_Grand"] = $out["totals"]["variance_Grand"] + $getCost['variance'];
            }
            $out['rows'][$i] =[];
            // end cost not empty
            $out['rows'][$i];
            
            // condition row 1 -> top heading
            if($format->heading == 1 && $format->account == 0 && $format->category == 0  && $format->production != 'Grand')
            {
                $out['rows'][$i]  = [
                    "condition"     => "condition_1",
                    "cost_id"       => $getCost['id'],
                    "format_id"     => $format->id,
                    "description"   => $format->description,
                    "acct_"         => $format->account_no,
                    "producation"   => $format->producation,
                    "period_cost"   => "",
                    "cost_to_date_" => "",
                    "pos_"          => "",
                    "total_costs"   => "",
                    "etc"           => "",
                    "efc"           => "",
                    "budget"        => "",
                    "approved_overage"  => "",
                    "total_budget"      => "",
                    "over_under"        => "",
                    "variance"          => "",
                    "last_ctd"          => "",
                    "last_efc"          => "",
                    "cat_num"           => $cat_total,
                    "styling"           =>$this->_rowStyling($format)
                ];
            }
            // condition_2 -- second heading
            elseif($format->account==1 && $format->account==1 && empty($format->producation) && $format->grand_total == 0)
            {
                $out['rows'][$i]  = [
                    "condition"     => "condition_2",
                    "cost_id"       => $getCost['id'],
                    "format_id"     => $format->id,
                    "description"   => $format->description,
                    "acct_"         => $format->account_no,
                    "producation"   => $format->producation,
                    "period_cost"   => "",
                    "cost_to_date_" => "",
                    "pos_"          => "",
                    "total_costs"   => "",
                    "etc"           => "",
                    "efc"           => "",
                    "budget"        => "",
                    "approved_overage"  => "",
                    "total_budget"      => "",
                    "over_under"        => "",
                    "variance"          => "",
                    "last_ctd"          => "",
                    "last_efc"          => "",
                    "cat_num"           => $cat_total,
                    "styling"           =>$this->_rowStyling($format)
                ];
            }
            // condition row 3 category total
            else if($format->heading == 2 && $format->account == 2  && $format->production != 'Grand')
            {
                $out['rows'][$i]  = [
                    "condition"  => "condition_3",
                    "format_id"     => $format->id,
                    "cost_id"       => $getCost['id'],
                    "description"   => "Total",
                    "acct_"         => $format->account_no,
                    "producation"   => $format->producation,
                    "period_cost"   => $out["totals"]["period_cost_sub"],
                    "cost_to_date_"  => $out["totals"]["cost_to_date_sub"],
                    "pos_"          => $out["totals"]["pos_sub"],
                    "total_costs"   => $out["totals"]["total_costs"],
                    "etc"           => $out["totals"]["etc_sub"],
                    "efc"           => $out["totals"]["efc_sub"],
                    "budget"        => $out["totals"]["budget_sub"],
                    "approved_overage"  => $out["totals"]["approved_overage_sub"],
                    "total_budget"      => $out["totals"]["total_budget_sub"],
                    "over_under"        => $out["totals"]["over_under_sub"],
                    "variance"          => $out["totals"]["variance_sub"],
                    "last_ctd"          => $getCost['last_ctd'],
                    "last_efc"          => $getCost['last_efc'],
                    "cat_num"           => $cat_total,
                    "category_id"       => $collectCategory,
                    "has_prodcuation_total" => $producationTotal,
                    "styling"           =>$this->_rowStyling($format)
                ];
                $out["totals"]["period_cost_sub"]   = 0;
                $out["totals"]["cost_to_date_sub"]  = 0;
                $out["totals"]["pos_sub"]           = 0;
                $out["totals"]["total_costs"]       = 0;
                $out["totals"]["etc_sub"]           = 0;
                $out["totals"]["efc_sub"]           = 0;
                $out["totals"]["budget_sub"]        = 0;
                $out["totals"]["approved_overage_sub"] = 0;
                $out["totals"]["total_budget_sub"]     = 0;
                $out["totals"]["over_under_sub"]       = 0;
                $out["totals"]["variance_sub"]         = 0;

                $collectCategory = $format->id;
                $cat_total++;
            }
            // condition row 4 and above and below the line total
            else if($format->category == 0 AND $format->description != ''  AND $format->production != 'Grand')
            {
                $out['rows'][$i]  = [
                    "condition"  => "condition_4",
                    "format_id"     => $format->id,
                    "cost_id"       => $getCost['id'],
                    "description"   => $format->description,
                    "acct_"         => $format->account_no,
                    "producation"   => $format->producation,
                    "period_cost"   => $out["totals"]["period_cost_".$format->production],
                    "cost_to_date_"     => $out["totals"]["cost_to_date_".$format->production],
                    "pos_"              => $out["totals"]["pos_".$format->production],
                    "total_costs"       => $out["totals"]["total_costs_".$format->production],
                    "etc"               => $out["totals"]["etc_".$format->production],
                    "efc"               => $out["totals"]["efc_".$format->production],
                    "budget"            => $out["totals"]["budget_".$format->production],
                    "approved_overage"  => $out["totals"]["approved_overage_".$format->production],
                    "total_budget"      => $out["totals"]["total_budget_".$format->production],
                    "over_under"        => $out["totals"]["over_under_".$format->production],
                    "variance"          => $out["totals"]["variance_".$format->production],
                    "last_ctd"          => $getCost['last_ctd'],
                    "last_efc"          => $getCost['last_efc'],
                    "cat_num"           => $cat_total,
                    "is_producation_total"=> $format->production,
                    "styling"           =>$this->_rowStyling($format)
                ];
        
            }
            // condition row 5
            else if($format->account==1 || $format->category!=0)
            {
                $out['rows'][$i] = [
                    "condition"     => "condition_5",
                    "format_id"     => $format->id,
                    "cost_id"       => $getCost['id'],
                    "acct_"         => $format->account_no,
                    "producation"   => $format->producation,
                    "description"   => $format->description,
                    "period_cost"   => $getCost['period_cost'],
                    "cost_to_date_" => $getCost["cost_to_date"],
                    "pos_"          => $getCost["pos"],
                    "total_costs"   => $getCost["total_costs"],
                    "etc"           => $getCost["etc"],
                    "efc"           => $getCost["efc"],
                    "budget"        => $getCost["budget"],
                    "approved_overage"  => $getCost["approved_overage"],
                    "total_budget"   => $getCost["total_budget"],
                    "over_under"     => $getCost["over_under"],
                    "variance"       => $getCost["variance"],
                    "last_ctd"       => $getCost['last_ctd'],
                    "last_efc"       => $getCost['last_efc'],
                    "cat_num"             => $cat_total,
                    "collectCategory"     => $collectCategory,
                    "styling"           =>$this->_rowStyling($format)
                ];
                $producationTotal = $format->production;
            }
            else
            {
                $out['rows'][$i]  = [
                    "condition"     => "grand_total",
                    "format_id"     => $format->id,
                    "cost_id"       => $getCost['id'],
                    "acct_"         => $format->account_no,
                    "producation"   => $format->producation,
                    "description"   => "Grand Total",
                    "period_cost"   => $out["totals"]["period_cost_Grand"],
                    "cost_to_date_"     => $out["totals"]["cost_to_date_Grand"],
                    "pos_"              => $out["totals"]["pos_Grand"],
                    "total_costs"       => $out["totals"]["total_costs_Grand"],
                    "etc"               => $out["totals"]["etc_Grand"],
                    "efc"               => $out["totals"]["efc_Grand"],
                    "budget"            =>$out["totals"]["budget_Grand"],
                    "approved_overage"  => $out["totals"]["approved_overage_Grand"],
                    "total_budget"  => $out["totals"]["total_budget_Grand"],
                    "over_under"    => $out["totals"]["over_under_Grand"],
                    "variance"      => $out["totals"]["variance_Grand"],
                    "last_ctd"      => $getCost['last_ctd'],
                    "last_efc"      => $getCost['last_efc'],
                    "cat_num"       => $cat_total,
                    "styling"           =>$this->_rowStyling($format)
                ];
            }
            
            $i++;
        } // endforeach
        return $out;
    }

    public function tableDataForTabulator()
    {
        $data = $this->fixData();
        $formatData = [];
        foreach($data['rows'] as $row){
            $formatData[]=[
                "id"            => $row['format_id'],
                "cost_id"       => $row['cost_id'],
                "condition"     => $row["condition"],
                "account_no"    => $row["acct_"],
                "producation"   => $row['producation'],
                "description"   => $row["description"],
                "period_cost"   => $row["period_cost"],
                "cost_to_date"  => $row["cost_to_date_"],
                "pos"           => $row["pos_"],
                "total_costs"   => $row["total_costs"],
                "etc"           => $row["etc"],
                "efc"           => $row["efc"],
                "budget"        => $row["budget"],
                "approved_overage"  => $row["approved_overage"],
                "total_budget"      => $row["total_budget"],
                "over_under"        => $row["over_under"],
                "variance"          => $row["variance"],
                "last_ctd"          => $row["last_ctd"],
                "last_efc"          => $row["last_efc"],
                "cat_num"           => $row['cat_num'],
                "category_id"       => !empty($row['category_id']) ? $row['category_id'] : '',
                "collectCategory"   => !empty($row['collectCategory']) ? $row['collectCategory'] : '',
                "is_producation_total"  => !empty($row['is_producation_total']) ? $row['is_producation_total'] : '',
                "has_prodcuation_total" => !empty($row['has_prodcuation_total']) ? $row['has_prodcuation_total'] : '',
                "styling"           => $row ['styling']
            ];
        }

        return $formatData;
    }

    private function _emptyCostdata($defaultValue)
    {
        return [
            "id" => $defaultValue,
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

    private function _rowStyling($format)
    {
        $style = '';
        if($format->bold == 'Y'){
            $style = ' bold';
        }
        if($format->line_type==1 AND $format->line_top==1) {
            $style .= " borderTop ";
        }else if($format->line_type==1 AND $format->line_top==2) {
            $style .= " borderTopAndBottom ";
        }else if($format->line_type==2 AND $format->line_top==1) {
            $style .= " borderDoubleTop ";
        }else if($format->line_type==2 AND $format->line_top==2) {
            $style .= " borderDoubleTopBottom ";
        }
        return $style;
    }

}

