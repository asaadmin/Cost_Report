<div  style="margin-top:6%;">

    <table id="export_table_style" class="raw_cost_table">
        <thead>
            <tr class="tableHead bg-secondary-blue">
                <th>Account Number</th>
                <th>Account Description</th>
                <th>Period Cost</th>
                <th>Cost To Date</th>
                <th>Pos</th>
                <th>Total Costs</th>
                <th>ETC</th>
                <th>EFC</th>
                <th>Budget</th>
                <th>Approved Overage</th>
                <th>Total Budget</th>
                <th>Over/(Under)</th>
                <th>Variance</th>
                <th>Last CTD</th>
                <th>Last EFC</th>
            </tr>
        </thead>

        <tbody>

            @foreach($data['rows'] as $row)
                <tr class="{{ $row['styling'] }}" data-condition="{{ $row['condition'] }}">
                    <td class="text-left"> {{ $row["acct_"] }}</td>
                    <td class="text-left"> {{ $row["description"] }}</td>
                    <td class="text-right"> {{ $row["period_cost"] }}</td>
                    <td class="text-right"> {{ $row["cost_to_date_"] }}</td>
                    <td class="text-right"> {{ $row["pos_"] }}</td>
                    <td class="text-right"> {{ $row["total_costs"] }}</td>
                    <td class="text-right"> {{ $row["etc"] }}</td>
                    <td class="text-right"> {{ $row["efc"] }}</td>
                    <td class="text-right"> {{ $row["budget"] }}</td>
                    <td class="text-right"> {{ $row["approved_overage"] }}</td>
                    <td class="text-right"> {{ $row["total_budget"] }}</td>
                    <td class="text-right"> {{ $row["over_under"] }}</td>
                    <td class="text-right"> {{ $row["variance"] }}</td>
                    <td class="text-right"> {{ $row["last_ctd"] }}</td>
                    <td class="text-right"> {{ $row["last_efc"] }}</td>
                </tr>

            @endforeach

        </tbody>
    </table>

    <button type="button" onclick="tabultorHelper.tableToExcel('export_table_style', 'tableExcel.xlsx')">Download</button>

</div>





