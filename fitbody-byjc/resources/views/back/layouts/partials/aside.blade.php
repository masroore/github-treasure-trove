<!-- Side Overlay-->
<aside id="side-overlay">
    <!-- Side Header -->
    <div class="content-header content-header-fullrow">
        <div class="content-header-section align-parent">
            <!-- Close Side Overlay -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-circle btn-dual-secondary align-v-r" data-toggle="layout" data-action="side_overlay_close">
                <i class="fa fa-times text-danger"></i>
            </button>
            <!-- END Close Side Overlay -->

            <!-- User Info -->
            <div class="content-header-item">
                <a class="img-link mr-5" href="javascript:void(0)">
                    <img class="img-avatar img-avatar32" src="{{ asset('media/images/avatar.jpg') }}" alt="">
                </a>
                <a class="align-middle link-effect text-primary-dark font-w600" href="javascript:void(0)">{{ $user->name }}</a>
            </div>
            <!-- END User Info -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Side Content -->
    <div class="content-side">
        <div class="block pull-t pull-r-l">
            <div class="block-content block-content-full block-content-sm bg-body-light">
                <form action="be_pages_generic_search.php" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" id="side-overlay-search" name="side-overlay-search" placeholder="Search..">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary px-10">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="block">
            <div class="block-header bg-body-light">
                <h3 class="block-title"><i class="fa fa-fw fa-users font-size-default mr-5"></i>Caching & Database</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                </div>
            </div>
            <div class="block-content p-0">
                <div class="list-group push">
                    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{{ route('cache.config') }}">
                        <i class="si si-anchor mr-5"></i> Cache Config
                    </a>
                    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{{ route('cache.view') }}">
                        <i class="si si-bubbles mr-5"></i> Cache View
                    </a>
                    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{{ route('cache.routes') }}">
                        <i class="si si-bubbles mr-5"></i> Cache Routes
                    </a>
                    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{{ route('cache') }}">
                        <i class="si si-bubbles mr-5"></i> Cache All
                    </a>
                    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{{ route('composer.dump') }}">
                        <i class="si si-bubbles mr-5"></i> Composer Dump
                    </a>
                    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{{ route('db.refresh') }}">
                        <i class="si si-loop mr-5"></i> Refresh Database
                    </a>
                </div>
            </div>
        </div>

    </div>
    <!-- END Side Content -->
</aside>
<!-- END Side Overlay -->
