<div class="box-body">
  <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Month</th>
                  <th>StaffID</th>
                  <th>Fullname</th>
                  <th>Role</th>
                  <th>Phone</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $array = ['Student','Developer','is_admin'];
                @endphp
                @foreach ($staff as $row)
                @if (!in_array($row->role, $array))
                <tr>
                  <td>{{$month}}</td>
                  <td>{{$row->eployid}}</td>
                  <td>{{$row->fullname}}</td>
                  <td>{{$row->role}}</td>
                  <td>{{$row->number}}</td>
                  <td>
                    <?php
                    $payrol =  App\Payroll::where('user_id',$row->user_id)
                    ->where('year',$year)
                    ->where('month',$month)->first();


                    if($payrol){

                      if($payrol->status == ''){
                        ?>
                        <label class="badge badge-info">process..</label>
                        <?php
                      }

                      if($payrol->status == 'Generated'){
                        ?>
                        <label class="badge badge-success">Generated</label>
                        <?php
                      }

                      if($payrol->status == 'Paid'){
                        ?>
                        <label class="badge badge-primary">Paid</label>
                        <?php
                      }
                    }else{
                      ?>
                      <label class="badge badge-success">process..</label>
                      <?php
                    }
                    ?>
                  </td>
                  <td>


                    <?php
                    
                    if($payrol){

                      if($payrol->status == ''){
                        ?>
                        <a href="{{ route('generate_payroll',['id' => $row->user_id, 'month' => $month, 'year' => $year, 'role' => $row->role]) }}" class="btn btn-info">Generate</a>
                        <?php
                      }

                      if($payrol->status == 'Generated'){
                        ?>
                        <a href="#" cid="{{$payrol->id}}" class="revert fa fa-mail-reply-all" title="revert"></a> &nbsp;&nbsp; <a href="#" cid="{{$payrol->id}}" class="paynow btn btn-success">Proceed To Pay</a>
                        <?php
                      }

                      if($payrol->status == 'Paid'){
                        ?>
                        <a href="#" cid="{{$payrol->id}}" class="revert fa fa-mail-reply-all" title="revert">

                        </a> &nbsp;&nbsp; <label class="viewpay badge badge-primary" cid="{{$payrol->id}}">View Paid Slip</label>
                        <?php
                      }
                    }else{
                      ?>
                      &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <a href="{{ route('generate_payroll',['id' => $row->user_id, 'month' => $month, 'year' => $year, 'role' => $row->role]) }}" class="btn btn-info">Generate</a>
                      <?php
                    }
                    ?>

                  </td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
    </div>
