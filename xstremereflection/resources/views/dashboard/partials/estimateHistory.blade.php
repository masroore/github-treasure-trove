<div class="col-md-6">
    <div class="card full-height">
        <div class="card-header">
            <div class="card-title">Lead / Estimate History</div>
        </div>
        <div class="card-body">
            <ol class="activity-feed">
                @foreach($estimateHistory as $row)
                    <li class="feed-item {{$row->statusInfo->color ?? 'feed-item-info'}} ">
                        <time class="date" datetime="{{\Carbon\Carbon::parse($row->created_at)->format('m-d')}}">{{\Carbon\Carbon::parse($row->created_at)->format('M d')}}</time>
                        <span class="text">{{$row->note ?? 'No Note Attached'}} <a href="/estimate/{{$row->estimate->id ?? ''}}/show">{{$row->estimate->eid ?? 'Unk'}} {{$row->estimate->customer->firstName ?? ''}} {{$row->estimate->customer->lastName ?? ''}}</a></span>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</div>
