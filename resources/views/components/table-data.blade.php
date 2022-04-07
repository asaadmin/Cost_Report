<div class="container-fluid"  style="margin-top:0px;">

    <table id="exported-table" class="table table-bordered">
        <thead>
            <tr class="tableHead">
                <td class="tableHeader large_size">Account Number</td>
                <td class="tableHeader large_size">Account Description</td>
                <td class="tableHeader large_size">Period Cost</td>
                <td class="tableHeader small_size_align large_size">Cost To Date</td>
                <td class="tableHeader small_size_align large_size">Pos</td>
                <td class="tableHeader small_size_align large_size">Total Costs</td>
                <td class="tableHeader small_size_align large_size">ETC</td>
                <td class="tableHeader small_size_align large_size">EFC</td>
                <td class="tableHeader small_size_align large_size">Budget</td>
                <td class="tableHeader small_size_align large_size">Approved Overage</td>
                <td class="tableHeader small_size_align large_size">Total Budget</td>
                <td class="tableHeader small_size_align large_size">Over/(Under)</td>
                <td class="tableHeader small_size_align large_size">Variance</td>
            </tr>
        </thead>

        <tbody>

            @foreach($data['rows'] as $row)
                <tr>
                    <td>{{ $row['row']["condition" . $row["format"]->account] }}</td>
                    <td>{{ $row['row']["description" . $row["format"]->account] }}</td>
                    <td>{{ $row['row']["acct_" . $row["format"]->account] }}</td>
                    <td>{{ $row['row']["cost_to_date_" . $row["format"]->account] }}</td>
                    <td>{{ $row['row']["pos_" . $row["format"]->account] }}</td>
                    <td>{{ $row['row']["total_costs" . $row["format"]->account] }}</td>
                    <td>{{ $row['row']["etc" . $row["format"]->account] }}</td>
                    <td>{{ $row['row']["efc" . $row["format"]->account] }}</td>
                    <td>{{ $row['row']["budget" . $row["format"]->account] }}</td>
                    <td>{{ $row['row']["approved_overage" . $row["format"]->account] }}</td>
                    <td>{{ $row['row']["total_budget" . $row["format"]->account] }}</td>
                    <td>{{ $row['row']["over_under" . $row["format"]->account] }}</td>
                    <td>{{ $row['row']["variance" . $row["format"]->account] }}</td>
                </tr>

            @endforeach

        </tbody>
    </table>

</div>
