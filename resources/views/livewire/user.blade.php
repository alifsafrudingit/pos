<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h4 class="font-weight-bold">Users</h4>
                    </div>
                    <div class="col-md-4">
                        <input wire:model="search" type="text" class="form-control" placeholder="Search invoice number">
                    </div>
                </div>
                <div class="row">
                    <table class="table table-hover">
                        <thead class="table-success">
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index=>$user)                                
                            <tr class="text-center">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


