require('./bootstrap');
window.$ = window.jQuery = require('jquery');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

import {TabulatorFull as Tabulator} from 'tabulator-tables';
import './tabulatorHelper';

if(document.getElementById("cost-table")){
    //Create Tabulator on DOM element with id "example-table"
    window.table = new Tabulator("#cost-table", {
        height:"100%",
        layout:"fitColumns",
        columnHeaderSortMulti:false,
        columns:[
            {title:"Account Number", field:"account_no", headerSort:false, hozAlign:"left"},
            {title:"Account Description", field:"description", headerSort:false, hozAlign:"left"},
            {
                title:"Period Cost", field:"period_cost", headerSort:false, hozAlign:"right",
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Cost To Date", field:"cost_to_date", headerSort:false, hozAlign:"right",
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Pos", field:"pos", headerSort:false, hozAlign:"right",
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Total Costs", field:"total_costs", headerSort:false, hozAlign:"right",
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"ETC", field:"etc", hozAlign:"right", headerSort:false,
                editor:tabultorHelper.etcEditor,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"EFC", field:"efc", hozAlign:"right", headerSort:false,
                editor:tabultorHelper.efcEditor,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Budget", field:"budget", hozAlign:"right", headerSort:false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Approved Overage", field:"approved_overage", hozAlign:"right", headerSort:false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Total Budget", field:"total_budget", hozAlign:"right", headerSort:false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Over/(Under)", field:"over_under", hozAlign:"right", headerSort:false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Variance", field:"variance", hozAlign:"right", headerSort:false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Last ctd", field:"last_ctd", visible: false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Last efc", field:"last_efc", visible: false,
                formatter:tabultorHelper.addAccountNumberToCell
            },

        ],
        rowFormatter: function(row){
            var data = row.getData();
            var rowElement = row.getElement()
            //apply css change to row element
            if(data.styling.search('bold') != -1){
                rowElement.style.fontWeight = "600"; 
            }
            if(data.styling.search('borderTop') != -1){
                rowElement.style.borderTop = "1px solid #000000";
            }
            if(data.styling.search('borderTopAndBottom') != -1){
                rowElement.style.borderTop = "1px solid #000000";
                rowElement.style.borderBottom = "1px solid #000000";
            }
            if(data.styling.search('borderDoubleTop') != -1){
                rowElement.style.borderTop = "2px solid #000000";
            }
            if(data.styling.search('borderDoubleTopBottom') != -1){
                rowElement.style.borderTop = "2px solid #000000";
                rowElement.style.borderBottom = "2px solid #000000";
            }
        },

    });

    // Table Events http://tabulator.info/docs/5.1/events#cell
    table.on("cellEditing", function(cell){
        //cell - cell component
    });
    table.on("dataChanged", function(data){
        //data - the updated table data
    });
    //trigger an alert message when the row is clicked
    table.on("rowClick", function(e, row){ 
        //alert("Row " + row.getData().id + " Clicked!!!!");
    });

    // Data Into Table
    table.on("tableBuilt", function(){
        // load data
        table.setData("/api/tabledata");

        var headers = document.getElementsByClassName("tabulator-headers")[0];
        window.onscroll = function() {
            if (window.scrollY >= 60) {
                headers.classList.add('sticky');
            }
            else {
                headers.classList.remove('sticky');
            }
        };
    });

}




function downloadExcelSheet(){

    table.download("xlsx", "data.xlsx",{
        documentProcessing:function(workbook){
            //workbook - sheetJS workbook object
            //set some properties on the workbook file
            
            

            var sheets = workbook.Sheets;
            for (var sheetKey in sheets) {
                // skip loop if the property is from prototype
                if (!sheets.hasOwnProperty(sheetKey)) continue;

                var sheet = sheets[sheetKey];

                //var range = XLSX.utils.decode_range(sheet['!ref']);
                //console.log(range)

                sheets[sheetKey]['!cols'] = [];
                sheets[sheetKey]['!rows'] = [];

                sheets[sheetKey]['!cols'][2] =  {'width' : 15};
                sheets[sheetKey]['!cols'][3] =  {'width' : 15};
                sheets[sheetKey]['!cols'][7] =  {'width' : 15};
                sheets[sheetKey]['!cols'][9] =  {'width' : 15};
                 
                for (var cellKey in sheet) {
                    // skip loop if the property is from prototype
                    if (!sheet.hasOwnProperty(cellKey) || cellKey == '!ref') continue;
                    
                    var cell = sheet[cellKey];

                    var rowNumber = Number(cellKey.replace( /^\D+/g, ''));

                    var boldWords = ["Total", "Grand Total"];
                    if(boldWords.includes(cell.v)){
                        sheets[sheetKey]['!rows'][rowNumber] = {'hpt': 12};
                    }
                    
                    var style  = {
                        font:{
                            bold:true
                        },
                        border:{
                            top:{
                                 style: 'thin', color: 'FFCC00' 
                            }
                        }
                    }
                    sheets[sheetKey][cellKey].s = boldWords.includes(cell.v) ? style : {}
                }
            }
            //console.log(XLSX.utils.sheet_to_json(workbook.Sheets.Sheet1, {header:1}))

            console.log(sheets)

            workbook.Props = {
                Title: "Cost Report",
                Subject: "Producation Cost",
                CreatedDate: new Date()
            };
            //workbook.SheetNames=['costs'];
            return workbook;
        },
        style:true
    });
    
}





