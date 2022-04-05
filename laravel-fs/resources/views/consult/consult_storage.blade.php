<div class="content-space"> 
      <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="" id="higchart_modal">
              
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="" id="higchart_modal2">
              
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var modal_dpto =  $('#storage option:selected').text();
  $(document).ready(function() {
    $('#tittle').html( "{{__('Check Availability in stock: ')}}" + modal_dpto);
   $('#higchart_modal').highcharts({
        title: {
            text:"{{ __('Available boxes') }}",
        },
        legend: {
            enabled: false
        },
        xAxis: {
            categories:  @json($name_model) 
        },
        yAxis: {
            min: 0,
            title: {
                text: "{{ __('Amount of boxes') }}"
            }
        },
        tooltip: {
            headerFormat: '<table style="font-size: 12px;"><tr><td style="color: white">Fecha:</td><td style="text-align: right;"><b>{point.key}</b></td></tr>',
            pointFormatter: function(){
                return '<tr><td style="color:'+this.series.color+';padding:0; width: 100px;">'+this.series.name+':&nbsp;</td>' +
                '<td style="padding:0"><b> '+this.y+'</b></td></tr>'},
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: "{{ __('Amount of boxes for this model') }}",
            type: 'column',
            data:  @json($amount_model) ,
            color: '#063056'
        }]
    });

      $('#higchart_modal2').highcharts({
        title: {
            text:"{{ __('Available POS') }}",
        },
        legend: {
            enabled: false
        },
        xAxis: {
            categories:  @json($name_model) 
        },
        yAxis: {
            min: 0,
            title: {
                text: "{{ __('Amount of POS') }}"
            }
        },
        tooltip: {
            headerFormat: '<table style="font-size: 12px;"><tr><td style="color: white">Fecha:</td><td style="text-align: right;"><b>{point.key}</b></td></tr>',
            pointFormatter: function(){
                return '<tr><td style="color:'+this.series.color+';padding:0; width: 100px;">'+this.series.name+':&nbsp;</td>' +
                '<td style="padding:0"><b> '+this.y+'</b></td></tr>'},
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name:  "{{ __('Amount of pos for this model') }}",
            type: 'column',
            data:  @json($amount_pos),
            color: '#063056'
        }]
    });
});

</script>