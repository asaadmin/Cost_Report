@extends('layouts.default')
@section('content')

    <div id="cost-table" class="cost-table"></div>

    <script>
     // https://jsfiddle.net/nzxbcf7g/


    //Create Tabulator on DOM element with id "example-table"
    var table = new Tabulator("#cost-table", {
        height:"100%",
        layout:"fitColumns",
        columnHeaderSortMulti:false,
        placeholder:[
            {"id":1,"cost_id":0,"condition":"condition_1","account_no":"","producation":null,"description":"ABOVE THE LINE","period_cost":"","cost_to_date":"","pos":"","total_costs":"","etc":"","efc":"","budget":"","approved_overage":"","total_budget":"","over_under":"","variance":"","last_ctd":"","last_efc":"","cat_num":1,"category_id":"","collectCategory":"","is_producation_total":"","has_prodcuation_total":"","styling":" bold"},
            {"id":2,"cost_id":0,"condition":"condition_2","account_no":"1100","producation":null,"description":"STORY & SCENARIO","period_cost":"","cost_to_date":"","pos":"","total_costs":"","etc":"","efc":"","budget":"","approved_overage":"","total_budget":"","over_under":"","variance":"","last_ctd":"","last_efc":"","cat_num":1,"category_id":"","collectCategory":"","is_producation_total":"","has_prodcuation_total":"","styling":" bold"}
        ],
        columns:[
            {title:"Account Number", field:"account_no", headerSort:false},
            {title:"Account Description", field:"description", headerSort:false},
            {
                title:"Period Cost", field:"period_cost", headerSort:false
            },
            {
                title:"Cost To Date", field:"cost_to_date", headerSort:false
            },
            {
                title:"Pos", field:"pos", headerSort:false
            },
            {
                title:"Total Costs", field:"total_costs", headerSort:false
            },
            {
                title:"ETC", field:"etc", hozAlign:"center", headerSort:false,
                editor:tabultorHelper.etcEditor,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"EFC", field:"efc", hozAlign:"center", headerSort:false,
                editor:tabultorHelper.efcEditor,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Budget", field:"budget", hozAlign:"center", headerSort:false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Approved Overage", field:"approved_overage", hozAlign:"center", headerSort:false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Total Budget", field:"total_budget", hozAlign:"center", headerSort:false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Over/(Under)", field:"over_under", hozAlign:"center", headerSort:false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Variance", field:"variance", hozAlign:"center", headerSort:false,
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
        rowFormatter:function(row){
            //row - row component
            var data = row.getData();
            var rowElement = row.getElement()
            //console.log(element);
            if(data.col == "etc"){
                rowElement.style.backgroundColor = "#1e3b20"; //apply css change to row element
            }
            if(data.styling == " bold"){
                rowElement.style.fontWeight = "600"; //apply css change to row element
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

        var lastRow = document.querySelector('.tabulator-row:last-child');

        window.onscroll = function() {
            if (window.scrollY >= 60) {
                headers.classList.add('sticky');
                //headers.style["top"] = (window.scrollY - 38) +"px";
            }
            else {
                headers.classList.remove('sticky');
            }
        };
    });

    // download
    //table.download("xlsx", "data.xlsx", {sheetName:"Costs"});

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
    



</script>


@stop
