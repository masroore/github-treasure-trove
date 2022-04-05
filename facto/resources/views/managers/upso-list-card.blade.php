<div>
    <div class="list-board ">
        <ul class="list-body page_1 ">
            @forelse ($upsos as $upso)
                <li class="list-item " 
                    style=" {{ isset( $upso_id )  && $upso_id == $upso->id ? '	border-style: solid; border-color: #f56565; padding: 5px; background-color:#cbd5e0;' : 'padding-bottom: 0px;' }}">
                    <div class="wr-subject  ">
                        <a href="{{ route('upsos.show', [ 
                                'upso'=> $upso , 
                                'main_region_id'=> $main_region_id ,
                                'sub_region_id'=> $sub_region_id ,
                                'search'=> $search,
                            ] )}}"
                            class="item-subject"
                        >
                            <div class="item-details text-muted font-12  ellipsis">
                                <div class="label-group">
                                    <span class="label label-upso">{{ $upso->region->title }}</span>
                                    <span class="label label-upso">{{ $upso->site_name }}</span>
                                </div>
                            </div>
                            <span class="item-subject-text">
                                {{ $upso->title }}
                            </span>
                        </a>
                    </div>
                    <div class="wr-hit ">
                        <div class="flex flex-col items-center justify-center">
                        <span class="orangered wr-comment">
                            <i class="fa fa-comment lightgray"></i>
                            <strong>{{ $upso->comments_count }}</strong>
                        </span>
                        <span class="p-1"><i class="fa fa-eye"></i> {{ $upso->visits }}</span>
                        </div>
                    </div>
                </li>
            @empty
                <li>
                    no data
                </li>
            @endforelse
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="list-btn-box">
        <div class="form-group pull-right list-btn mx-1">
            <div class="btn-group dropup">
                <a href="{{ route('upsos.index', ['upso_type_id'=> optional($upso_type)->id ]) }}" class="btn btn-black btn-sm">
                    <i class="fa fa-bars"></i>
                    <span>목록</span>
                </a>
                @auth
                <a href="{{ route('upsos.create', ['upso_type_id'=> optional($upso_type)->id ]) }}" 
                    class="btn btn-color btn-sm">
                    <i class="fa fa-pencil"></i>
                    <span>글쓰기</span>
                </a>
                @endauth
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>