<!-- Sidebar Menu -->
<nav class="mt-4">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" id="sidebarnav">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->is('account/dashboard*') ? 'active' : ''); ?>">
                <i class="nav-icon icon-dashboard"></i>
                <p>
                    <?php echo app('translator')->getFromJson('menu.dashboard'); ?>
                </p>
            </a>
        </li>
        <?php if($user->roles()->withoutGlobalScopes()->first()->hasPermission('read_location')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.locations.index')); ?>" class="nav-link <?php echo e(request()->is('account/locations*') ? 'active' : ''); ?>">
                <i class="nav-icon icon-map-alt"></i>
                <p>
                    <?php echo app('translator')->getFromJson('menu.locations'); ?>
                </p>
            </a>
        </li>
        <?php endif; ?>
        <?php if($user->roles()->withoutGlobalScopes()->first()->hasPermission('read_category')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="nav-link <?php echo e(request()->is('account/categories*') ? 'active' : ''); ?>">
                <i class="nav-icon icon-list"></i>
                <p>
                    <?php echo app('translator')->getFromJson('menu.categories'); ?>
                </p>
            </a>
        </li>
        <?php endif; ?>
        <?php if($user->roles()->withoutGlobalScopes()->first()->hasPermission('read_business_service')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.business-services.index')); ?>" class="nav-link <?php echo e(request()->is('account/business-services*') ? 'active' : ''); ?>">
                <i class="nav-icon icon-list"></i>
                <p>
                    <?php echo app('translator')->getFromJson('menu.services'); ?>
                </p>
            </a>
        </li>
        <?php endif; ?>
        <?php if($user->roles()->withoutGlobalScopes()->first()->hasPermission('read_customer')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.customers.index')); ?>" class="nav-link <?php echo e(request()->is('account/customers*') ? 'active' : ''); ?>">
                <i class="nav-icon icon-user"></i>
                <p>
                    <?php echo app('translator')->getFromJson('menu.customers'); ?>
                </p>
            </a>
        </li>
        <?php endif; ?>
        <?php if($user->roles()->withoutGlobalScopes()->first()->hasPermission('read_employee')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.employee.index')); ?>" class="nav-link <?php echo e(request()->is('account/employee*') ? 'active' : ''); ?>">
                <i class="nav-icon icon-user"></i>
                <p>
                    <?php echo app('translator')->getFromJson('menu.employee'); ?>
                </p>
            </a>
        </li>
        <?php endif; ?>
        <?php if($user->roles()->withoutGlobalScopes()->first()->hasPermission('create_point_of_sale')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.pos.create')); ?>" class="nav-link <?php echo e(request()->is('account/pos*') ? 'active' : ''); ?>">
                <i class="nav-icon icon-shopping-cart"></i>
                <p>
                    <?php echo app('translator')->getFromJson('menu.pos'); ?>
                </p>
            </a>
        </li>
        <?php endif; ?>
        <?php if($user->roles()->withoutGlobalScopes()->first()->hasPermission('read_booking')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="nav-link <?php echo e(request()->is('account/bookings*') ? 'active' : ''); ?>">
                <i class="nav-icon icon-calendar"></i>
                <p>
                    <?php echo app('translator')->getFromJson('menu.bookings'); ?>
                </p>
            </a>
        </li>
        <?php endif; ?>
        <?php if($user->roles()->withoutGlobalScopes()->first()->hasPermission('read_report')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.reports.index')); ?>" class="nav-link <?php echo e(request()->is('account/reports*') ? 'active' : ''); ?>">
                <i class="nav-icon icon-pie-chart"></i>
                <p>
                    <?php echo app('translator')->getFromJson('menu.reports'); ?>
                </p>
            </a>
        </li>
        <?php endif; ?>
        <?php if($user->roles()->withoutGlobalScopes()->first()->hasPermission('manage_settings')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.settings.index')); ?>" class="nav-link <?php echo e(request()->is('account/settings*') ? 'active' : ''); ?>">
                <i class="nav-icon icon-settings"></i>
                <p>
                    <?php echo app('translator')->getFromJson('menu.settings'); ?>
                </p>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>
<!-- /.sidebar-menu -->
<?php /**PATH E:\laragon\www\booking\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>