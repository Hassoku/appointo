    <div class="row border p-2">
        <div class='col-md-12'><h6><?php echo e(ucwords($customer->name)); ?></h6></div>

        <div class='col-md-6'><i class='fa fa-envelope'></i>: <?php echo e($customer->email ?? "--"); ?></div>
        <div class='col-md-6'><i class='fa fa-phone'></i>: <?php echo e($customer->mobile ? $customer->formatted_mobile : "--"); ?></div>

    </div>
<?php /**PATH E:\laragon\www\booking\resources\views/admin/customer/ajax_show.blade.php ENDPATH**/ ?>