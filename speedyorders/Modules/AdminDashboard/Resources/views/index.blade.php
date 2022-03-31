@extends('layouts.main')

@section('content')



<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $orderCount??0 }}</h3>
                <p>
                    Total Orders
                </p>              
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
              </div>

        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $saleCount ?? 0}}</h3>
                <p>
                    Total Sales
                </p>              
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $customerCount ?? 0 }}</h3>
                <p>
                    Total Customer
                </p>              
            </div>
             <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $todayOrder??0 }} | ${{ $todayIncome??0 }}</h3>
                <p>
                    Today Orders
                </p>              
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
        </div>
    </div>
</div>


 <div class="card">
  <div class="card-header border-0">
    <h3 class="card-title">Recent Orders</h3>
    <div class="card-tools">
     
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-striped table-valign-middle">
      <thead>
      <tr>
        <th>S.N.</th>
        <th>Order number</th>
        <th>Customer</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Total Order item</th>
        <th>Total Cost</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
        @if(count($lastestOrders) > 0)
            @foreach ($lastestOrders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->invoice_number }}</td>
                <td>{{ $order->first_name. ' '. $order->last_name }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->orderItems->count() }}</td>
                <td>{{ $order->orderItems->sum('price') }}</td>
                <td><a href="{{ route('admin.orders.edit',$order->id) }}"><i class="fa fa-eye text-success"></i></a></td>
            </tr>
            @endforeach
        @else
            <tr class="text-center">
                <td colspan="8">No Records found</td>
            </tr>
        @endif
    </tbody>
    </table>
  </div>

</div>

<div class="col-lg-6">
    <div class="card">
      <div class="card-header border-0">
        <div class="d-flex justify-content-between">
          <h3 class="card-title">Orders</h3>
        </div>
      </div>
      <div class="card-body">
        <div class="position-relative mb-4">
            <div class="col-md-4 pull-right">
                            <select name="frequency" id="frequency" class="form-control">
                                <option value="Month">This Month</option>
                                <option value="Week" selected>This Week</option>
                                <option value="Year">This Year</option>
                            </select>
                        </div>

            <!-- <canvas id="sales-chart-canvas"></canvas> -->
        </div>
      </div>
    </div>
    <!-- /.card -->
</div>



@endsection
@section('ext_js')
<script>

    let mychart;

    $(document).ready(function()
    {
        getFrequencyData();
    });

    $('#frequency').on('change', function() {
        getFrequencyData();
    });

    function getFrequencyData()
    {
        if(typeof myChart !== "undefined"){
          myChart.destroy();
        }

        var frequency = $('#frequency').val();

        $.ajax({
        url:'/admin/dashboard/get-frequency-data/'+frequency,
        dataType:"json",
        type: "GET",
        success:function(res)
        {

            /**
            * Options for Line chart
            */
            if(res['frequency'] == 'Year')
            {
                $('#lineOptions').show();
                $('#barOptions').hide();

                for(var i=1;i<13;i++)
                {
                    if(res['oData'][i] == undefined)
                    {
                        res['oData'][i] = 0;
                    }
                    if(res['sData'][i] == undefined)
                    {
                        res['sData'][i] = 0;
                    }
                }
            var orderData = Object.values(res['oData']);
            var salesData = Object.values(res['sData']);

            var lineData = {
            labels: ["January", "February", "March", "April", "May", "June", "July",'August','September','October','November','December'],
            datasets: [
                {
                    label: "Sales",
                    backgroundColor: 'rgba(98,203,49, 0.5)',
                    pointBorderWidth: 1,
                    pointBackgroundColor: "rgba(98,203,49,1)",
                    pointRadius: 3,
                    pointBorderColor: '#ffffff',
                    borderWidth: 1,
                    data:salesData
                },
                {
                    label: "Orders",
                    backgroundColor: 'rgba(220,220,220,0.5)',
                    borderColor: "rgba(220,220,220,0.7)",
                    pointBorderWidth: 1,
                    pointBackgroundColor: "rgba(220,220,220,1)",
                    pointRadius: 3,
                    pointBorderColor: '#ffffff',
                    borderWidth: 1,
                    data: orderData
                }
                ]
            };

            var lineOptions = {
                responsive: true
            };

            var ctx = document.getElementById("lineOptions").getContext("2d");
            myChart = new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});

            }

            else
            {

                $('#lineOptions').hide();
                $('#barOptions').show();

                /**
                * Options for Bar chart
                */
                var barOptions = {
                    responsive:true
                };

                if(res['frequency']=='Week')
                {
                    for(var i=0;i<7;i++)
                    {
                        if(res['oData'][i] == undefined)
                        {
                            res['oData'][i] = 0;
                        }
                        if(res['sData'][i] == undefined)
                        {
                            res['sData'][i] = 0;
                        }
                    }
                    var orderData = Object.values(res['oData']);
                    var salesData = Object.values(res['sData']);

                    var barData = {
                    labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thrusday", "Friday", "Saturday"],
                    datasets: [
                        {
                            label: "Sales",
                            backgroundColor: "rgba(220,220,220,0.5)",
                            borderColor: "rgba(220,220,220,0.8)",
                            highlightFill: "rgba(220,220,220,0.75)",
                            highlightStroke: "rgba(220,220,220,1)",
                            borderWidth: 1,
                            data: salesData
                        },
                        {
                            label: "Orders",
                            backgroundColor: "rgba(98,203,49,0.5)",
                            borderColor: "rgba(98,203,49,0.8)",
                            highlightFill: "rgba(98,203,49,0.75)",
                            highlightStroke: "rgba(98,203,49,1)",
                            borderWidth: 1,
                            data: orderData
                        }
                    ]
                };
                }

                if(res['frequency']=='Month')
                {
                    var labelsArray = [];

                    for(var i=1;i<=res['totalDaysInMonth'];i++)
                    {
                        if(res['oData'][i] == undefined)
                        {
                            res['oData'][i] = 0;
                        }
                        if(res['sData'][i] == undefined)
                        {
                            res['sData'][i] = 0;
                        }
                        labelsArray.push(i);
                    }

                    var orderData = Object.values(res['oData']);
                    var salesData = Object.values(res['sData']);

                    var barData = {
                        labels: labelsArray,
                        datasets: [
                            {
                                label: "Sales",
                                backgroundColor: "rgba(220,220,220,0.5)",
                                borderColor: "rgba(220,220,220,0.8)",
                                highlightFill: "rgba(220,220,220,0.75)",
                                highlightStroke: "rgba(220,220,220,1)",
                                borderWidth: 1,
                                data: salesData
                            },
                            {
                                label: "Orders",
                                backgroundColor: "rgba(98,203,49,0.5)",
                                borderColor: "rgba(98,203,49,0.8)",
                                highlightFill: "rgba(98,203,49,0.75)",
                                highlightStroke: "rgba(98,203,49,1)",
                                borderWidth: 1,
                                data: orderData
                            }
                        ]
                    };
                }
                var ctx = document.getElementById("barOptions").getContext("2d");
                myChart = new Chart(ctx, {type: 'bar', data: barData, options:barOptions});

            }
        }
        });

    }

</script>

@endsection
