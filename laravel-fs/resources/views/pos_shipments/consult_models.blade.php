<div class="content-space"> 
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
          @foreach($models as $key => $value)
        <button class="nav-link {{ ($key == 0 ? 'active':'') }}" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#model_{{ $value->id }}" type="button" role="tab" aria-controls="nav-home" aria-selected="true">{{ $value->mark.' '.$value->serial }}</button>
          @endforeach
      </div>
    </nav>
    <div class="bodytable">
        <div class="tab-content" id="nav-tabContent">
          @foreach($models as $key => $value)          
            <div class="tab-pane fade show {{ ($key == 0 ? 'active':'') }} " id="model_{{ $value->id }}" role="tabpanel" aria-labelledby="nav-home-tab">
                <table class="dataTable table" cellspacing="0" width="100%" id="table1">
                    <thead>
                        <tr>
                          <th scope='col'>{{__('Box Number')}}</th>
                          <th scope='col'>{{__('Serial')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($value->getBoxes as $key2 => $value2)      
                          @if($value2->processing == 0) 
                              <tr>
                                <td>{{ $value2->number_box }}</td>
                                <td>{{ $value2->serial_end }}</td>
                              </tr>
                          @endif
                      @endforeach
                    </tbody>
                </table>
            </div>
          @endforeach            
        </div>
    </div>
</div>