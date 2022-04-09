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
    }

}



