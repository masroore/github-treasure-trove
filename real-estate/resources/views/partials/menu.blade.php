<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('property_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/categories*") ? "c-show" : "" }} {{ request()->is("admin/amenities*") ? "c-show" : "" }} {{ request()->is("admin/properties*") ? "c-show" : "" }} {{ request()->is("admin/property-tags*") ? "c-show" : "" }} {{ request()->is("admin/propoerty-inquiries*") ? "c-show" : "" }} {{ request()->is("admin/property-reviews*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fab fa-houzz c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.propertyManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/categories") || request()->is("admin/categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-pencil-ruler c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.category.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('amenity_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.amenities.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/amenities") || request()->is("admin/amenities/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-american-sign-language-interpreting c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.amenity.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('property_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.properties.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/properties") || request()->is("admin/properties/*") ? "c-active" : "" }}">
                                <i class="fa-fw fab fa-affiliatetheme c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.property.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('property_tag_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.property-tags.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/property-tags") || request()->is("admin/property-tags/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-tags c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.propertyTag.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('propoerty_inquiry_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.propoerty-inquiries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/propoerty-inquiries") || request()->is("admin/propoerty-inquiries/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-pen-fancy c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.propoertyInquiry.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('property_review_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.property-reviews.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/property-reviews") || request()->is("admin/property-reviews/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-star c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.propertyReview.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('page_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/aboutuses*") ? "c-show" : "" }} {{ request()->is("admin/faqs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-book-open c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.page.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('about_us_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.aboutuses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/aboutuses") || request()->is("admin/aboutuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-ban c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.aboutUs.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('faq_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.faqs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/faqs") || request()->is("admin/faqs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-align-left c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.faq.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('basic_c_r_m_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/crm-statuses*") ? "c-show" : "" }} {{ request()->is("admin/crm-customers*") ? "c-show" : "" }} {{ request()->is("admin/crm-notes*") ? "c-show" : "" }} {{ request()->is("admin/crm-documents*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.basicCRM.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('crm_status_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.crm-statuses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/crm-statuses") || request()->is("admin/crm-statuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-folder c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.crmStatus.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('crm_customer_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.crm-customers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/crm-customers") || request()->is("admin/crm-customers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-plus c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.crmCustomer.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('crm_note_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.crm-notes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/crm-notes") || request()->is("admin/crm-notes/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-sticky-note c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.crmNote.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('crm_document_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.crm-documents.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/crm-documents") || request()->is("admin/crm-documents/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-folder c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.crmDocument.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('system_setting_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/contact-us-messages*") ? "c-show" : "" }} {{ request()->is("admin/blogs*") ? "c-show" : "" }} {{ request()->is("admin/seaches*") ? "c-show" : "" }} {{ request()->is("admin/our-partners*") ? "c-show" : "" }} {{ request()->is("admin/subscribers*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.systemSetting.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('contact_us_message_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.contact-us-messages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/contact-us-messages") || request()->is("admin/contact-us-messages/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-phone c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.contactUsMessage.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('blog_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.blogs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/blogs") || request()->is("admin/blogs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-pen c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.blog.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('seach_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.seaches.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/seaches") || request()->is("admin/seaches/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-assistive-listening-systems c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.seach.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('our_partner_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.our-partners.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/our-partners") || request()->is("admin/our-partners/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-friends c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.ourPartner.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('subscriber_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.subscribers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/subscribers") || request()->is("admin/subscribers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-check c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.subscriber.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.systemCalendar") }}" class="c-sidebar-nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "c-active" : "" }}">
                <i class="c-sidebar-nav-icon fa-fw fas fa-calendar">

                </i>
                {{ trans('global.systemCalendar') }}
            </a>
        </li>
        @php($unread = \App\Models\QaTopic::unreadCount())
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.messenger.index") }}" class="{{ request()->is("admin/messenger") || request()->is("admin/messenger/*") ? "c-active" : "" }} c-sidebar-nav-link">
                    <i class="c-sidebar-nav-icon fa-fw fa fa-envelope">

                    </i>
                    <span>{{ trans('global.messages') }}</span>
                    @if($unread > 0)
                        <strong>( {{ $unread }} )</strong>
                    @endif

                </a>
            </li>
            @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                @can('profile_password_edit')
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                            <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                            </i>
                            {{ trans('global.change_password') }}
                        </a>
                    </li>
                @endcan
            @endif
            <li class="c-sidebar-nav-item">
                <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
    </ul>

</div>