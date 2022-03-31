<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{ route('admin.settings') }}" class="{{ isset($sub_menu) && $sub_menu == 'general' ? 'text-bold' : ''}}">General Setting</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('admin.settings.cod') }}" class="{{ isset($sub_menu) && $sub_menu == 'cod' ? 'text-bold' : ''}}">Cash On Delivery Setting</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('admin.settings.paypal') }}" class="{{ isset($sub_menu) && $sub_menu == 'paypal' ? 'text-bold' : ''}}">Paypal Setting</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('admin.settings.stripe') }}" class="{{ isset($sub_menu) && $sub_menu == 'stripe' ? 'text-bold' : ''}}">Stripe Setting</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('admin.settings.shipping') }}" class="{{ isset($sub_menu) && $sub_menu == 'shipping' ? 'text-bold' : ''}}">Shipping Setting</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('admin.settings.chat') }}" class="{{ isset($sub_menu) && $sub_menu == 'chat' ? 'text-bold' : ''}}">Chat Setting</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('admin.settings.googleanalytics') }}" class="{{ isset($sub_menu) && $sub_menu == 'googleanalytics' ? 'text-bold' : ''}}">Google Analytics Setting</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('admin.settings.socialmedia') }}" class="{{ isset($sub_menu) && $sub_menu == 'socialmedia' ? 'text-bold' : ''}}">Social Media Setting</a>
                </li>
            </ul>
        </div>
    </div>
</div>
