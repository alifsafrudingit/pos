<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h4 class="font-weight-bold">Transactions List</h4>
                    </div>
                    <div class="col-md-4">
                        <input wire:model="search" type="text" class="form-control" placeholder="Search invoice number">
                    </div>
                </div>
                <div class="row">
                    <table class="table table-hover">
                        <thead class="table-success">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Invoice Number</th>
                                <th>User</th>
                                <th>Pay</th>
                                <th>Total Price</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $index=>$transaction)                                
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $transaction->invoice_number }}</td>
                                <td>{{ $transaction->user_id }}</td>
                                <td>IDR {{ number_format($transaction->pay) }}</td>
                                <td>IDR {{ number_format($transaction->total) }}</td>
                                <td>{{ $transaction->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="mt-4" style="display:flex; justify-content:center;">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


