<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Format;
use Session;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

use Box\Spout\Common\Entity\Style\Style;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Common\Entity\Style\CellAlignment;



class EditedFile extends Controller
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

    public function templateFile()
    {
        return response()->download('uploadfileTemplate.xlsx');
    }

    public function updateCostRow(Request $request)
    {
        $cost = Cost::where('id', $request->get('cost_id'))->update([
            'etc' => $request->get('etc'),
            'efc' => $request->get('efc'),
            'over_under' => $request->get('over_under'),
            'variance' => $request->get('variance')
        ]);
        return response()->json($cost, 200);
    }

    public function save()
    {
        $sheets = new SheetCollection([
            "Costs" => Cost::where('sessionID', Session::getId())->select($this->_costSheetHeader())->get(),
            "Formats" => Format::where('sessionID', Session::getId())->select($this->_formatSheetHeader())->get()
        ]);
        $style = (new Style())
        ->setBackgroundColor(Color::YELLOW)
        ->setCellAlignment(CellAlignment::CENTER)
        ->setShouldWrapText(true)
        ->setFontBold(true)
        ;
        (new FastExcel($sheets))->headerStyle($style)->export('savedFile.xlsx');
        return response()->download('savedFile.xlsx');
    }

    public function _costSheetHeader()
    {
        return [
            "account_no AS Account Number",
            "description AS Account Description",
            "period_cost AS Period Cost",
            "cost_to_date AS Cost To Date",
            "pos AS Pos",
            "total_costs AS Total Costs",
            "etc AS ETC",
            "efc AS EFC",
            "budget AS Budget",
            "approved_overage AS Approved Overage",
            "total_budget AS Total Budget",
            "over_under AS Over/(Under)",
            "variance AS Variance",
            "last_ctd AS Last_CTD",
            "last_efc AS Last_EFC",
        ];
    }

    public function _formatSheetHeader()
    {
        return [
            "forder AS Order",
			"account_no AS Account Number",
			"description AS Account Description",
			"heading AS heading",
			"account AS account",
			"category AS category",
			"production AS production",
			"grand_total AS grand total",
			"line_type AS line type",
			"line_top AS line top",
			"bold AS bold",
			"height_percent AS height %",
        ];
    }

}
