<table id="productTable" class="table table-bordered table-striped speedy-table">
    <thead>
        <tr>
            <th>Email</th>
            <th>Description</th>
            <th>Type</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @forelse($uTransactions as $uTransaction)
        <tr>
            <td>{{ $uTransaction->customerUser->email }}</td>
            <td>{{ $uTransaction->description }}</td>
            <td>{{ $uTransaction->type }}</td>
            <td>{{ $uTransaction->amount }}</td>
        </tr>
        @empty
        <tfoot>
            <tr>
                <td class="text-center" colspan="6">
                    <span>No data available in the table...</span>
                </td>
            </tr>
        </tfoot>
        @endforelse
    </tbody>
</table>
