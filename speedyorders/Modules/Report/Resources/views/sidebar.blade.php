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
                    <a href="{{ route('admin.reports.index') }}" class="{{ isset($sub_menu) && $sub_menu == 'sales' ? 'text-bold' : ''}}">
                        <i class="fa fa-pie-chart" aria-hidden="true"></i> Sales Report
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('admin.reports.statements') }}" class="{{ isset($sub_menu) && $sub_menu == 'statement' ? 'text-bold' : ''}}">
                        <i class="fa fa-google-wallet" aria-hidden="true"></i> Agent Statements
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
