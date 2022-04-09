@extends('layouts.default')
@section('content')

    <a class="button-42" style="max-width:80px;" href="{{route('reset')}}">Reset</a>

    <div id="cost-table" class="cost-table"></div>

    <script>
     // https://jsfiddle.net/nzxbcf7g/

    var addAccountNumberToCell = function(cell, formatterParams, onRendered){
        //cell - the cell component
        //formatterParams - parameters set for the column
        //onRendered - function to call when the formatter has been rendered
        //var cell = $("#example-table").tabulator("getRow", 24).getCell("name");
        //$("#example-table").tabulator("getRow", 24).update({name:"steve");
        //var data = table.getData();
        //console.log(data)
        var sameRowdata = cell.getData();
        var row = cell.getRow();
        var coloum = cell.getColumn()
        var currentElement = cell.getElement()

        onRendered(function(){
            if(sameRowdata.condition == 'condition_2')
            {
                row.getElement().style.border  = '1px solid #000000';

                switch (coloum.getField()) {
                    case 'total_costs':
                        currentElement.setAttribute('id', "total_costs_" + sameRowdata.cat_num)
                        break;
                    case 'etc':
                        currentElement.setAttribute('id', "total_etc_" + sameRowdata.cat_num)
                        break;
                    case 'efc':
                        currentElement.setAttribute('id', "total_efc_" + sameRowdata.cat_num)
                        break;
                    case 'over_under':
                        currentElement.setAttribute('id', "total_over_" + sameRowdata.cat_num)
                        break;
                    case 'variance':
                        currentElement.setAttribute('id', "total_variance_" + sameRowdata.cat_num)
                        break;
                }
                // row.update({"account_no": ""});
            }

            if(sameRowdata.condition == 'condition_3')
            {
                row.getElement().style.border  = '1px solid #000000';
                row.getElement().style.fontWeight  = '600';

                switch (coloum.getField()) {
                    case 'total_costs':
                        currentElement.setAttribute('id', "total_costs_" + sameRowdata.account_no)
                        break;
                    case 'etc':
                        currentElement.setAttribute('id', "total_" + sameRowdata.production)
                        break;
                    case 'efc':
                        currentElement.setAttribute('id', "total_" + sameRowdata.production)
                        break;
                    case 'over_under':
                        currentElement.setAttribute('id', "over_" + sameRowdata.account_no)
                        break;
                    case 'variance':
                        currentElement.setAttribute('id', "variance_" + sameRowdata.account_no)
                        break;
                }
            }

            if(sameRowdata.condition == 'condition_4')
            {
                switch (coloum.getField()) {
                    case 'total_costs':
                        currentElement.setAttribute('id', "total_costs_" + sameRowdata.account_no)
                        break;
                    case 'etc':
                        currentElement.setAttribute('id', "etc_" + sameRowdata.account_no)
                        currentElement.classList.add("etc_"+ sameRowdata.production)
                        currentElement.classList.add("etc_"+ sameRowdata.cat_num)
                        break;
                    case 'efc':
                        currentElement.setAttribute('id', "efc_" + sameRowdata.account_no)
                        currentElement.classList.add("efc_"+ sameRowdata.production)
                        currentElement.classList.add("efc_"+ sameRowdata.cat_num)
                        break;
                    case 'budget':
                        currentElement.setAttribute('id', "budget_" + sameRowdata.account_no)
                        currentElement.classList.add("budget_"+ sameRowdata.production)
                        currentElement.classList.add("budget_"+ sameRowdata.cat_num)
                        break;
                    case 'over_under':
                        currentElement.setAttribute('id', "over_" + sameRowdata.account_no)
                        currentElement.classList.add("over_"+ sameRowdata.production)
                        currentElement.classList.add("over_"+ sameRowdata.cat_num)
                        break;
                    case 'variance':
                        currentElement.setAttribute('id', "variance_" + sameRowdata.account_no)
                        currentElement.classList.add("variance_"+ sameRowdata.production)
                        currentElement.classList.add("variance_"+ sameRowdata.cat_num)
                        break;
                }
            }

            if(sameRowdata.condition == 'grand_total')
            {
                row.getElement().style.border  = '1px solid #000000';
                row.getElement().style.fontWeight  = '600';
            }

        });
        return cell.getValue();
    }


    //Create Tabulator on DOM element with id "example-table"
    var table = new Tabulator("#cost-table", {
        maxHeight:"100%",
        layout:"fitColumns",
        columnHeaderSortMulti:false,
        placeholder:"No Data Set",
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
                formatter:addAccountNumberToCell
            },
            {
                title:"EFC", field:"efc", hozAlign:"center", headerSort:false,
                editor:tabultorHelper.efcEditor,
                formatter:addAccountNumberToCell
            },
            {
                title:"Budget", field:"budget", hozAlign:"center", headerSort:false,
                formatter:addAccountNumberToCell
            },
            {
                title:"Approved Overage", field:"approved_overage", hozAlign:"center", headerSort:false,
                formatter:addAccountNumberToCell
            },
            {
                title:"Total Budget", field:"total_budget", hozAlign:"center", headerSort:false,
                formatter:addAccountNumberToCell
            },
            {
                title:"Over/(Under)", field:"over_under", hozAlign:"center", headerSort:false,
                formatter:addAccountNumberToCell
            },
            {
                title:"Variance", field:"variance", hozAlign:"center", headerSort:false,
                formatter:addAccountNumberToCell
            },
            {
                title:"Last ctd", field:"last_ctd", visible: false,
                formatter:addAccountNumberToCell
            },
            {
                title:"Last efc", field:"last_efc", visible: false,
                formatter:addAccountNumberToCell
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
        }
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
        table.setData("/api/tabledata");
    });

    // download
    //table.download("xlsx", "data.xlsx", {sheetName:"Costs"});

</script>


@stop
