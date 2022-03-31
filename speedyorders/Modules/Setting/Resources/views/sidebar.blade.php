<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="list-group">
                <li class="list-group-item" style="background: #2588ca;">
                    <a class="text-bold" style="color: #ffffff;">
                        CATEGORY
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('settings.general') }}"
                        class="{{ isset($sub_menu) && $sub_menu == 'general' ? 'text-bold' : ''}}">General Setting</a>
                </li>
            </ul>
        </div>
    </div>
</div>
