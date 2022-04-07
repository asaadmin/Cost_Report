@extends('layouts.default')
@section('content')

    <div>
        <button id="ajax-trigger">Load Data</button>
    </div>

    <div id="example-table"></div>


    <script>
     // https://jsfiddle.net/nzxbcf7g/

    var edit_etc = function(cell, onRendered, success, cancel){

        if(cell.getElement().getAttribute('data-accountNumber') == 'condition_2'){
            return
        }

        input = document.createElement("input");
        input.style.padding = "4px";
        input.style.width = "100%";
        input.style.boxSizing = "border-box";

        // do formatting here
        var cellValue = cell.getValue();
        input.value = cellValue;
        // render input field
        onRendered(function(){
            input.focus();
            input.style.height = "100%";
        });

        function onChange(){
            if(input.value != cellValue){
                success(input.value);
            }else{
                cancel();
            }
        }

        //submit new value on blur or change
        input.addEventListener("blur", onChange);
        //submit new value on enter
        input.addEventListener("keydown", function(e){
            if(e.keyCode == 13){
                onChange();
            }

            if(e.keyCode == 27){
                cancel();
            }
        });

        return input;
    };

    var edit_efc = function(cell, onRendered, success, cancel){

        if(cell.getElement().getAttribute('data-accountNumber') == 'condition_2'){
            return
        }

        input = document.createElement("input");
        input.style.padding = "4px";
        input.style.width = "100%";
        input.style.boxSizing = "border-box";

        var cellValue = cell.getValue();
        input.value = cellValue;
        // render input field
        onRendered(function(){
            input.focus();
            input.style.height = "100%";
        });

        function onChange(){
            if(input.value != cellValue){
                success(input.value);
                // over under
                var sameRowdata = cell.getData();
                var row = cell.getRow();
                row.update({
                    "over_under": Number(input.value) - Number(sameRowdata.budget),
                    "variance": Number(input.value) - Number(sameRowdata.last_efc),
                });
            }else{
                cancel();
            }
        }
        //submit new value on blur or change
        input.addEventListener("blur", onChange);

        //submit new value on enter
        input.addEventListener("keydown", function(e){
            if(e.keyCode == 13){
                onChange();
            }
            if(e.keyCode == 27){
                cancel();
            }
        });

        return input;
    };

    var addAccountNumberToCell = function(cell, formatterParams, onRendered){
        //cell - the cell component
        //formatterParams - parameters set for the column
        //onRendered - function to call when the formatter has been rendered
        //var cell = $("#example-table").tabulator("getRow", 24).getCell("name");
        //$("#example-table").tabulator("getRow", 24).update({name:"steve");
        //var data = table.getData();
        //console.log(data)
        
        var sameRowdata = cell.getData();

        onRendered(function(){
            //cell.getElement().style.backgroundColor = "#1e3b20"
            cell.getElement().setAttribute('data-accountNumber', sameRowdata.account_no)

            if(sameRowdata.account_no == 'condition_2' || sameRowdata.account_no == 'condition_1'){
                var row = cell.getRow();
                row.update({
                    "account_no": ""
                });
            }
            
        });
        return cell.getValue();
    }

    // https://jsfiddle.net/nzxbcf7g/
    var updateSum = (cell) => {
        var data = cell.getData();
        var sum = Number(data.etc) + Number(data.b)
        var row = cell.getRow();
        row.update({
            "ab": sum
        });
    }



    //create Tabulator on DOM element with id "example-table"
    var table = new Tabulator("#example-table", {
        height:"800px",
        layout:"fitColumns",
        headerSort:false,
        placeholder:"No Data Set",
        columns:[
            {title:"Account Numbe", field:"account_no"},
            {title:"Account Description", field:"description"},
            {title:"Period Cost", field:"period_cost"},
            {title:"Cost To Date", field:"cost_to_date"},
            {title:"Pos", field:"pos"},
            {title:"Total Costs", field:"total_costs"},
            {
                title:"ETC", field:"etc", hozAlign:"center", 
                editor:edit_etc,
                formatter:addAccountNumberToCell
            },
            {
                title:"EFC", field:"efc", hozAlign:"center", 
                editor:edit_efc,
                formatter:addAccountNumberToCell
            },
            {title:"Budget", field:"budget", hozAlign:"center"},
            {title:"Approved Overage", field:"approved_overage", hozAlign:"center"},
            {title:"Total Budget", field:"total_budget", hozAlign:"center"},
            {
                title:"Over/(Under)", field:"over_under", hozAlign:"center"
            },
            {title:"Variance", field:"variance", hozAlign:"center"},
            {title:"Last ctd", field:"last_ctd", visible: false},
            {title:"Last efc", field:"last_efc", visible: false},

        ],
        rowFormatter:function(row){
            //row - row component
            var data = row.getData();
            var element = row.getElement()
            //console.log(element);
            if(data.col == "etc"){
                row.getElement().style.backgroundColor = "#1e3b20"; //apply css change to row element
            }
        }
    });
    //table.hideColumn("Last ctd")

    //trigger AJAX load on "Load Data via AJAX" button click
    document.getElementById("ajax-trigger").addEventListener("click", function(){
        table.setData("/api/tabledata");
    });
    //trigger an alert message when the row is clicked
    table.on("rowClick", function(e, row){ 
        //alert("Row " + row.getData().id + " Clicked!!!!");
    });

    // download
    //table.download("xlsx", "data.xlsx", {sheetName:"Costs"});
</script>


@stop
