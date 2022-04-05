<div class="content-space"> 
    <div class="bodytable noborde">
       <table class="dataTable table" cellspacing="0" width="100%" id="table_pos_request">
          <thead>
              <tr>
                  <th scope='col'>{{__('Model')}}</th>
                  <th scope='col'>{{__('Amount Boxes')}}</th>
                  <th scope='col'>{{__('Amount POS')}}</th>
              </tr>
          </thead>
          <tbody>
            @foreach($model as $value)      
              <tr>
                <td>{{$value['full_model']}}</td>
                <td>{{$value['amount_boxes']}}</td>
                <td>{{$value['amount_pos']}}</td>
              </tr>
            @endforeach
          </tbody>
      </table>
    </div>
</div>