tabultorHelper = {

    formatNumber: function (number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    },
    
    etcEditor: function(cell, onRendered, success, cancel){

        var conditionRowsToAvoid = [
            "condition_1",
            "condition_2",
            "condition_3",
            "condition_4",
            "grand_total"
        ]
        // Rows blocked
        if(conditionRowsToAvoid.indexOf(cell.getData().condition) > -1){
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
                }).then(function(){
                    $.ajax({
                        type:'PUT',
                        url:"/updaterow",
                        data:sameRowdata,
                        success:function(data){
                           console.log('row updated')
                        }
                     });
                });

                // Update category total
                var rowsToBeSumed  = table.searchData([
                    {field:"condition", type: "=", value: "condition_5"},
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
    },
    efcEditor: function(cell, onRendered, success, cancel){

        var conditionRowsToAvoid = [
            "condition_1",
            "condition_2",
            "condition_3",
            "condition_4",
            "grand_total"
        ]
        // Rows blocked
        if(conditionRowsToAvoid.indexOf(cell.getData().condition) > -1){
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
                    {field:"condition", type: "=", value: "condition_5"},
                    {field:"collectCategory", type: "=", value: sameRowdata.collectCategory},
                ]);
                console.log(rowsToBeSumed)
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
    },

    addAccountNumberToCell: function(cell, formatterParams, onRendered){
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
            if(sameRowdata.condition == 'condition_3')
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

            if(sameRowdata.condition == 'condition_4')
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

            if(sameRowdata.condition == 'condition_5')
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
    },

    tableToExcel: function (tableID, fileName) {
        // Define your style class template.
        var style = "<style>thead{font-weight: bold; color: #000;} th{border: none; color: black;font-weight: bold;} .bold{ font-weight: bold;} .borderTopAndBottom {border-top: 1px solid #000; border-bottom: 1px solid #000;}.borderDoubleTopBottom {border-top: 3px double #000;border-bottom: 3px double #000;} .borderTop {  border-top: 1px solid #000; } .borderDoubleTop{border-top: 3px double #000;}</style>";
        var uri = 'data:application/vnd.ms-excel;base64,'
        var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->' + style + '</head><body><table>{table}</table></body></html>'
        var base64 = function (s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            }
        var format = function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; })
            }
        if (!tableID.nodeType) table = document.getElementById(tableID)
        var ctx = { worksheet: fileName || 'Worksheet', table: table.innerHTML }
        window.location.href = uri + base64(format(template, ctx))
        return;
    }

}



