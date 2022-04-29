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
        //maxHeight:"100%",
        layout:"fitColumns",
        //columnMinWidth:80,
        columnHeaderSortMulti:false,
        columns:[
            {title:"Account Number", field:"account_no", headerSort:false, hozAlign:"left", resizable: false},
            {title:"Account Description", field:"description", headerSort:false, hozAlign:"left", resizable: false, maxWidth:200},
            {
                title:"Period Cost", field:"period_cost", headerSort:false, hozAlign:"right", resizable: false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Cost To Date", field:"cost_to_date", headerSort:false, hozAlign:"right", resizable: false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Pos", field:"pos", headerSort:false, hozAlign:"right", resizable: false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Total Costs", field:"total_costs", headerSort:false, hozAlign:"right", resizable: false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"ETC", field:"etc", hozAlign:"right", headerSort:false, resizable: false,
                editor:tabultorHelper.etcEditor,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"EFC", field:"efc", hozAlign:"right", headerSort:false, resizable: false,
                editor:tabultorHelper.efcEditor,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Budget", field:"budget", hozAlign:"right", headerSort:false, resizable: false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Approved Overage", field:"approved_overage", hozAlign:"right", headerSort:false, resizable: false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Total Budget", field:"total_budget", hozAlign:"right", headerSort:false, resizable: false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Over/(Under)", field:"over_under", hozAlign:"right", headerSort:false, resizable: false,
                formatter:tabultorHelper.addAccountNumberToCell
            },
            {
                title:"Variance", field:"variance", hozAlign:"right", headerSort:false, resizable: false,
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

        var headers = document.getElementsByClassName("tabulator-header")[0];
        var stickyAfterScroll = headers.offsetTop
        function pinHeader()
        {
            if (window.scrollY > 53) {
                headers.classList.add('sticky');
            }
            else {
                headers.classList.remove('sticky');
            }
        }
        //window.onscroll = function() {pinHeader()};
    });

}






