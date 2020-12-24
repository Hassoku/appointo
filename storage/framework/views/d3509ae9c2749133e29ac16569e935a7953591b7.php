<?php ($envatoUpdateCompanySetting = \Froiden\Envato\Functions\EnvatoUpdate::companySetting()); ?>

<?php if(!is_null($envatoUpdateCompanySetting->supported_until)): ?>
    <div class="" id="support-div">
        <?php if(\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->isPast()): ?>
            <div class="col-md-12 alert alert-danger ">
                <div class="col-md-6">
                    Your support has been expired on <b><span
                                id="support-date"><?php echo e(\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->format('d M, Y')); ?></span></b>
                </div>
                <div class="col-md-6 text-right">
                    <a href="<?php echo e(config('froiden_envato.envato_product_url')); ?>" target="_blank"
                       class="btn btn-inverse btn-small">Renew support <i class="fa fa-shopping-cart"></i></a>
                    <a href="javascript:;" onclick="getPurchaseData();" class="btn btn-inverse btn-small">Refresh
                        <i
                                class="fa fa-refresh"></i></a>
                </div>
            </div>

        <?php else: ?>
            <div class="col-md-12 alert alert-info">
                Your support will expire on <b><span
                            id="support-date"><?php echo e(\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->format('d M, Y')); ?></span></b>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php ($updateVersionInfo = \Froiden\Envato\Functions\EnvatoUpdate::updateVersionInfo()); ?>
<?php if(isset($updateVersionInfo['lastVersion'])): ?>
    <div class="alert alert-danger col-md-12">
        <p> <?php echo app('translator')->getFromJson('messages.updateAlert'); ?></p>
        <p><?php echo app('translator')->getFromJson('messages.updateBackupNotice'); ?></p>
    </div>

    <div class="alert alert-info col-md-12">
        <div class="col-md-9"><i class="ti-gift"></i> <?php echo app('translator')->getFromJson('modules.update.newUpdate'); ?> <label
                    class="label label-success"><?php echo e($updateVersionInfo['lastVersion']); ?></label><br><br>
            <h5 class="text-white font-bold"><label class="label label-danger">ALERT</label>You will get logged
                out after update. Login again to use the application.</h5>
        </div>
        <div class="col-md-3 text-center">
            <a id="update-app" href="javascript:;"
               class="btn btn-success btn-small" style="text-decoration: none"><?php echo app('translator')->getFromJson('modules.update.updateNow'); ?> <i
                        class="fa fa-download"></i></a>

        </div>

        <div class="col-md-12">
            <p><?php echo $updateVersionInfo['updateInfo']; ?></p>
        </div>
    </div>

    <div id="update-area" class="m-t-20 m-b-20 col-md-12 white-box hide">
        Loading...
    </div>
<?php else: ?>
    <div class="alert alert-success col-md-12">
        <div class="col-md-12">You have latest version of this app.</div>
    </div>
<?php endif; ?>
<?php /**PATH E:\laragon\www\booking\resources\views/vendor/froiden-envato/update/update_blade.blade.php ENDPATH**/ ?>