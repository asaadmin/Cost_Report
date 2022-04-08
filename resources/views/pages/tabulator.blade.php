@extends('layouts.default')
@section('content')

    <a class="button-42" style="max-width:80px;" href="{{route('reset')}}">Reset</a>

    <div id="example-table"></div>

    <script>
     // https://jsfiddle.net/nzxbcf7g/
    var etc_editor = function(cell, onRendered, success, cancel){

        if(cell.getData().condition == 'condition_1' || cell.getData().condition == 'condition_2' || cell.getData().condition == 'condition_3'){
            return;
        }

        input = document.createElement("input");
        input.style.padding = "4px";
        input.style.width = "100%";
        input.style.boxSizing = "border-box";

        // do formatting here
        var cellValue = cell.getValue();
        var sameRowdata = cell.getData();
        input.value = cellValue;
        // render input field
        onRendered(function(){
            input.focus();
            input.style.height = "100%";
        });

        function onChange(){
            if(input.value != cellValue){
                success(input.value);

                var efc = Number(sameRowdata.total_costs) + Number(input.value); 
                var under = efc - Number(sameRowdata.budget); 
                var variance = efc - parseFloat(sameRowdata.last_efc);

                // over under
                var row = cell.getRow();
                row.update({
                    "efc": efc,
                    "over_under": under,
                    "variance": variance,
                });

                // Update category total
                var rowsToBeSumed  = table.searchData([
                    {field:"condition", type: "=", value: "condition_4"},
                    {field:"collectCategory", type: "=", value: sameRowdata.collectCategory},
                ]);
                var categoryEtcSum=0, categoryEfCSum=0, categoryOverUnderSum=0, categoryVarianceSum=0; 
                rowsToBeSumed.forEach((row) => {
                    categoryEtcSum += Number(row.etc)
                    categoryEfCSum += Number(row.efc)
                    categoryOverUnderSum += Number(row.over_under)
                    categoryVarianceSum += Number(row.variance)
                });

                var rowsToBeUpdate = table.searchData([
                    {field:"category_id", type: "=", value: sameRowdata.collectCategory},
                ])[0];

                table.updateData([
                    {
                        id:     rowsToBeUpdate.id, 
                        etc:    categoryEtcSum,
                        efc:    categoryEfCSum,
                        over_under: categoryOverUnderSum,
                        variance:   categoryVarianceSum
                    }
                ]);

                // Producation total -> ATL, BTL, Post, General
                var prodTotals = table.searchData([
                    {field:"has_prodcuation_total", type: "=", value: rowsToBeUpdate.has_prodcuation_total},
                ])
                var prodEtcSum=0, prodEfCSum=0, prodOverUnderSum=0, prodVarianceSum=0; 
                prodTotals.forEach((row) => {
                    prodEtcSum += Number(row.etc)
                    prodEfCSum += Number(row.efc)
                    prodOverUnderSum += Number(row.over_under)
                    prodVarianceSum += Number(row.variance)
                });

                var prodToBeUpdate = table.searchData([
                    {field:"is_producation_total", type: "=", value: rowsToBeUpdate.has_prodcuation_total},
                ])[0];
                table.updateData([
                    {
                        id:     prodToBeUpdate.id, 
                        etc:    prodEtcSum,
                        efc:    prodEfCSum,
                        over_under: prodOverUnderSum,
                        variance:   prodVarianceSum
                    }
                ]);

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

    var efc_editor = function(cell, onRendered, success, cancel){

        // category and total blocked
        if(cell.getData().condition == 'condition_1' || cell.getData().condition == 'condition_2' || cell.getData().condition == 'condition_3'){
            return;
        }

        input = document.createElement("input");
        input.style.padding = "4px";
        input.style.width = "100%";
        input.style.boxSizing = "border-box";

        var cellValue = cell.getValue();
        var sameRowdata = cell.getData();
        var row = cell.getRow();
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
                var etc = parseFloat(input.value) -  parseFloat(sameRowdata.total_costs);   
                var under = Number(input.value) - Number(sameRowdata.budget); 
                var variance = Number(input.value) - Number(sameRowdata.last_efc); 
                row.update({
                    "etc": etc,
                    "over_under": under,
                    "variance": variance,
                });

                // Update category total
                var rowsToBeSumed  = table.searchData([
                    {field:"condition", type: "=", value: "condition_4"},
                    {field:"collectCategory", type: "=", value: sameRowdata.collectCategory},
                ]);

                var categoryEtcSum=0, categoryEfCSum=0, categoryOverUnderSum=0, categoryVarianceSum=0; 
                rowsToBeSumed.forEach((row) => {
                    categoryEtcSum += Number(row.etc)
                    categoryEfCSum += Number(row.efc)
                    categoryOverUnderSum += Number(row.over_under)
                    categoryVarianceSum += Number(row.variance)
                });

                var rowsToBeUpdate = table.searchData([
                    {field:"category_id", type: "=", value: sameRowdata.collectCategory},
                ])[0];
                table.updateData([
                    {
                        id:     rowsToBeUpdate.id, 
                        etc:    categoryEtcSum,
                        efc:    categoryEfCSum,
                        over_under: categoryOverUnderSum,
                        variance:   categoryVarianceSum
                    }
                ]).then(function(){ });

                // producation total
                // Producation total -> ATL, BTL, Post, General
                var prodTotals = table.searchData([
                    {field:"has_prodcuation_total", type: "=", value: rowsToBeUpdate.has_prodcuation_total},
                ])
                var prodEtcSum=0, prodEfCSum=0, prodOverUnderSum=0, prodVarianceSum=0; 
                prodTotals.forEach((row) => {
                    prodEtcSum += Number(row.etc)
                    prodEfCSum += Number(row.efc)
                    prodOverUnderSum += Number(row.over_under)
                    prodVarianceSum += Number(row.variance)
                });

                var prodToBeUpdate = table.searchData([
                    {field:"is_producation_total", type: "=", value: rowsToBeUpdate.has_prodcuation_total},
                ])[0];
                table.updateData([
                    {
                        id:     prodToBeUpdate.id, 
                        etc:    prodEtcSum,
                        efc:    prodEfCSum,
                        over_under: prodOverUnderSum,
                        variance:   prodVarianceSum
                    }
                ]);

                // Grand Total
                var getAllTheProductionTotal = table.searchData([
                    {field:"is_producation_total", type: "!=", value: ""},
                ])
                var grandEtcSum=0, grandEfCSum=0, grandOverUnderSum=0, grandVarianceSum=0; 
                getAllTheProductionTotal.forEach((row) => {
                    grandEtcSum += Number(row.etc)
                    grandEfCSum += Number(row.efc)
                    grandOverUnderSum += Number(row.over_under)
                    grandVarianceSum += Number(row.variance)
                });
                var grandTotalUpdate = table.searchData([
                    {field:"condition", type: "=", value: "grand_total"},
                ])[0];
                table.updateData([
                    {
                        id:     grandTotalUpdate.id, 
                        etc:    grandEtcSum,
                        efc:    grandEfCSum,
                        over_under: grandOverUnderSum,
                        variance:   grandVarianceSum
                    }
                ]);

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

        });
        return cell.getValue();
    }


    //create Tabulator on DOM element with id "example-table"
    var table = new Tabulator("#example-table", {
        height:"100%",
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
                editor:etc_editor,
                formatter:addAccountNumberToCell
            },
            {
                title:"EFC", field:"efc", hozAlign:"center", headerSort:false,
                editor:efc_editor,
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
            var element = row.getElement()
            //console.log(element);
            if(data.col == "etc"){
                row.getElement().style.backgroundColor = "#1e3b20"; //apply css change to row element
            }
        }
    });
    
    //trigger an alert message when the row is clicked
    table.on("rowClick", function(e, row){ 
        //alert("Row " + row.getData().id + " Clicked!!!!");
    });

    table.on("tableBuilt", function(){
        table.setData("/api/tabledata");
    });

    // download
    //table.download("xlsx", "data.xlsx", {sheetName:"Costs"});

</script>


@stop
