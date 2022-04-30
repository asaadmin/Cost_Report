<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Format;
use Session;
use  App\Services\BuildTableFormat;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterFactory;
use Box\Spout\Common\Type;

use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Manager\Style\StyleMerger;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Common\Entity\Style\CellAlignment;
use \NumberFormatter;


class FormatExcel extends Controller
{

    public function index()
    {
        $filename = "report_".date('Y_m_d_h_s').".xlsx";
        $tableData = (new BuildTableFormat())->tableDataForTabulator();

        //$writer = WriterFactory::createFromType(Type::XLSX);
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToFile($filename);

        $row = WriterEntityFactory::createRowFromArray($this->_costSheetHeader());
        $writer->addRow($row);

        //Oh, figured it out--just added this line to Box\Spout\Writer\XLSX\Manager\WorksheetManager.php, startSheet(), between the header and the data:
        //fwrite($sheetFilePointer, '<cols><col min="1" max="1" width="30" customWidth="1"/><col min="2" max="6" width="30" customWidth="1"/></cols>');
        // echo number_format('1000', 0, ".", ",")

        $styleMerger = new StyleMerger();
        $removeCells = ['id', 'cost_id', 'condition', 'producation', 'styling', 'has_prodcuation_total', 'is_producation_total', 'collectCategory', 'category_id', 'cat_num', 'last_ctd', 'last_efc'];

        // need to build header
        foreach($tableData as $row){

            $style = new StyleBuilder();
            $borderBuilder = new BorderBuilder();

            if (strpos($row['styling'], 'bold')) {
                $style->setFontBold();
            }
            if (strpos($row['styling'], 'borderTop')) {
                $borderBuilder->setBorderTop(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID);
            }
            if (strpos($row['styling'], 'borderTopAndBottom')) {
                $borderBuilder->setBorderTop(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID);
                $borderBuilder->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID);
            }
            if (strpos($row['styling'], 'borderDoubleTop')) {
                $borderBuilder->setBorderTop(Color::BLACK, Border::WIDTH_THICK, Border::STYLE_SOLID);
            }
            if (strpos($row['styling'], 'borderDoubleTopBottom')) {
                $borderBuilder->setBorderTop(Color::BLACK, Border::WIDTH_THICK, Border::STYLE_SOLID);
                $borderBuilder->setBorderBottom(Color::BLACK, Border::WIDTH_THICK, Border::STYLE_SOLID);
            }
            //$style->setCellAlignment(CellAlignment::RIGHT)->setShouldWrapText();

            $borderStyle = (new StyleBuilder())->setBorder($borderBuilder->build())->build();
            $styleMerger = (new StyleMerger())->merge($borderStyle, $style->build());

            $row = array_diff_key($row, array_flip($removeCells));

            $rowCells = $this->_cellStyle($row);
            
            /** Create a row with cells and apply the style to all cells */
            $rowToadd = WriterEntityFactory::createRow($rowCells);
            $rowToadd->setStyle($styleMerger);
            /** Add the row to the writer */
            $writer->addRow($rowToadd);
        }        
        
        $writer->close();
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    private function _cellStyle($row)
    {
        $rowKeys = array_keys($row);
        $cells = [];
        foreach ($rowKeys as $key) {
            if ($key === 'account_no' || $key === 'description') {
                $cells[$key] =  WriterEntityFactory::createCell($row[$key], self::_wordCellStyling());
            }
            else{
                if(is_numeric($row[$key])){
                    $row[$key] = self::_accountingNumberFormat($row[$key]);
                 }
                $cells[$key] =  WriterEntityFactory::createCell($row[$key], self::_numberCellStyling());
            }
        }
        return $cells;
    }

    private static function _wordCellStyling(){
        return (new StyleBuilder())
        ->setCellAlignment(CellAlignment::LEFT)
        ->build();
    }
    private static function _numberCellStyling(){
        return (new StyleBuilder())
        ->setCellAlignment(CellAlignment::RIGHT)
        ->build();
    }

    private static function _accountingNumberFormat($value)
    {
        $nf = new NumberFormatter('en_US', NumberFormatter::CURRENCY_ACCOUNTING);
        $nf->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
        $nf->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
        return $nf->format($value);
    }

    private function _colWidths()
    {
        $out = "<cols>";
        foreach($this->_costSheetHeader() as $header)
        {
            $out .= '<col min="1" max="1" width="30" customWidth="1"/>';
        }
        $out .= "<cols>";
        return $out;
    }

    public function _costSheetHeader()
    {
        return [
            "Account Number",
            "Account Description",
            "Period Cost",
            "Cost To Date",
            "Pos",
            "Total Costs",
            "ETC",
            "EFC",
            "Budget",
            "Approved Overage",
            "Total Budget",
            " Over/(Under)",
            "Variance"
        ];
    }


}

