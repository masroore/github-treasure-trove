<div class="card">
    <div class="card-body">
        <h4 class="card-title">My Estimate</h4>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="estimate-listing" class="table">
                        <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Address</th>
                            <th>VIN</th>
                            <th>Year</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Color</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @include('workorder.partials.row')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
