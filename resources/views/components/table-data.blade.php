<div class="container-fluid"  style="margin-top:0px;">

    <table class="raw_cost_table">
        <thead>
            <tr class="tableHead">
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
                <tr class="{{ $row['styling'] }}">
                    <td>{{ $row["acct_"] }}</td>
                    <td>{{ $row["description"] }}</td>
                    <td>{{ $row["period_cost"] }}</td>
                    <td>{{ $row["cost_to_date_"] }}</td>
                    <td>{{ $row["pos_"] }}</td>
                    <td>{{ $row["total_costs"] }}</td>
                    <td>{{ $row["etc"] }}</td>
                    <td>{{ $row["efc"] }}</td>
                    <td>{{ $row["budget"] }}</td>
                    <td>{{ $row["approved_overage"] }}</td>
                    <td>{{ $row["total_budget"] }}</td>
                    <td>{{ $row["over_under"] }}</td>
                    <td>{{ $row["variance"] }}</td>
                    <td>{{ $row["last_ctd"] }}</td>
                    <td>{{ $row["last_efc"] }}</td>
                </tr>

            @endforeach

        </tbody>
    </table>

</div>
