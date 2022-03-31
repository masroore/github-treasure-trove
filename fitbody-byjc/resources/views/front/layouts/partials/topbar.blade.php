<div id="top-bar">
    <div class="container clearfix">
        <div class="col_half d-none d-md-block nobottommargin">
            <div class="top-links">
                <ul>
                    <li><a href="tel:{{ $appinfo->phone }}"><i class="icon-phone3"></i> {{ $appinfo->phone }}</a></li>
                </ul>
            </div>
        </div>
        <div class="col_half col_last fright nobottommargin">
            <div id="top-social">
                <ul>
                    @if( ! empty($appinfo->facebook))
                        <li><a href="{{ $appinfo->facebook }}" class="si-facebook" target="_blank"><span class="ts-icon"><i class="icon-facebook"></i></span><span class="ts-text">Facebook</span></a></li>
                    @endif
                    <li><a href="{{ url('kontakt') }}" class="si-email3"><span class="ts-icon"><i class="icon-envelope-alt"></i></span><span class="ts-text"><span class="__cf_email__" >Kontaktirajte nas!</span></span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
