<?php $__env->startPush('head-css'); ?>
    <style>
        .dropify-wrapper, .dropify-preview, .dropify-render img {
            background-color: var(--sidebar-bg) !important;
        }

        #carousel-image-gallery .card .img-holder {
            height: 150px;
            overflow: hidden;
        }

        #carousel-image-gallery .card .img-holder img {
            height: 100%;
            object-fit: cover;
            object-position: top;
        }

        .note-group-select-from-files {
            display: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-12 col-md-2 mb-4 mt-3 mb-md-0 mt-md-0">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                 aria-orientation="vertical">
                <a class="nav-link active" href="#general" data-toggle="tab" id="general-tab"><?php echo app('translator')->getFromJson('menu.general'); ?></a>
                <a class="nav-link" href="#times" data-toggle="tab"><?php echo app('translator')->getFromJson('menu.bookingTimes'); ?></a>
                <a class="nav-link" href="#tax" data-toggle="tab"><?php echo app('translator')->getFromJson('app.tax'); ?> <?php echo app('translator')->getFromJson('menu.settings'); ?></a>
                <a class="nav-link" href="#currency" data-toggle="tab"><?php echo app('translator')->getFromJson('app.currency'); ?> <?php echo app('translator')->getFromJson('menu.settings'); ?></a>
                <a class="nav-link" href="#language" data-toggle="tab"><?php echo app('translator')->getFromJson('app.language'); ?> <?php echo app('translator')->getFromJson('menu.settings'); ?></a>
                <a class="nav-link" href="#email" data-toggle="tab"><?php echo app('translator')->getFromJson('app.email'); ?> <?php echo app('translator')->getFromJson('menu.settings'); ?></a>
                <a class="nav-link" href="#admin-theme" data-toggle="tab"><?php echo app('translator')->getFromJson('menu.adminThemeSettings'); ?></a>
                <a class="nav-link" href="#front-theme" data-toggle="tab"><?php echo app('translator')->getFromJson('menu.frontThemeSettings'); ?></a>
                <a class="nav-link" href="#front-pages" data-toggle="tab"><?php echo app('translator')->getFromJson('menu.pages'); ?></a>
                <a class="nav-link" href="#role-permission" data-toggle="tab"><?php echo app('translator')->getFromJson('menu.rolesPermissions'); ?></a>
                <a class="nav-link" href="#payment"
                   data-toggle="tab"><?php echo app('translator')->getFromJson('app.paymentCredential'); ?> <?php echo app('translator')->getFromJson('menu.settings'); ?></a>
                <a class="nav-link" href="#sms-settings"
                   data-toggle="tab"><?php echo app('translator')->getFromJson('app.smsCredentials'); ?> <?php echo app('translator')->getFromJson('menu.settings'); ?></a>
                <a class="nav-link" href="#update" data-toggle="tab">
                    <?php echo app('translator')->getFromJson('menu.updateApp'); ?>
                    <?php if($newUpdate == 1): ?>
                        <span class="badge badge-success"><?php echo e($lastVersion); ?></span>
                    <?php endif; ?>

                </a>
            </div>
        </div>
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content">
                                <div class="active tab-pane" id="general">

                                    <form class="form-horizontal ajax-form" id="general-form" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label"><?php echo app('translator')->getFromJson('app.company'); ?> <?php echo app('translator')->getFromJson('app.name'); ?></label>

                                                    <input type="text" class="form-control  form-control-lg"
                                                           id="company_name" name="company_name"
                                                           value="<?php echo e($settings->company_name); ?>">
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label"><?php echo app('translator')->getFromJson('app.company'); ?> <?php echo app('translator')->getFromJson('app.email'); ?></label>

                                                    <input type="text" class="form-control  form-control-lg"
                                                           id="company_email" name="company_email"
                                                           value="<?php echo e($settings->company_email); ?>">
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label"><?php echo app('translator')->getFromJson('app.company'); ?> <?php echo app('translator')->getFromJson('app.phone'); ?></label>

                                                    <input type="text" class="form-control  form-control-lg"
                                                           id="company_phone" name="company_phone"
                                                           value="<?php echo e($settings->company_phone); ?>">
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('app.logo'); ?></label>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <input type="file" id="input-file-now" name="logo"
                                                                   accept=".png,.jpg,.jpeg" class="dropify"
                                                                   data-default-file="<?php echo e($settings->logo_url); ?>"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('app.address'); ?></label>
                                                    <textarea class="form-control form-control-lg" name="address" id=""
                                                              cols="30" rows="5"><?php echo $settings->address; ?></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="date_format" class="control-label">
                                                                <?php echo app('translator')->getFromJson('app.date_format'); ?>
                                                            </label>

                                                            <select name="date_format" id="date_format"
                                                                    class="form-control form-control-lg select2">
                                                                <?php $__currentLoopData = $dateFormats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dateFormat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($key); ?>" <?php if($settings->date_format == $key): ?> selected <?php endif; ?>><?php echo e($key.' ('.$dateObject->format($key).')'); ?>

                                                                    </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="time_format" class="control-label">
                                                                <?php echo app('translator')->getFromJson('app.time_format'); ?>
                                                            </label>

                                                            <select name="time_format" id="time_format"
                                                                    class="form-control form-control-lg select2">
                                                                <?php $__currentLoopData = $timeFormats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $timeFormat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($key); ?>" <?php if($settings->time_format == $key): ?> selected <?php endif; ?>><?php echo e($key.' ('.$dateObject->format($key).')'); ?>

                                                                    </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label"><?php echo app('translator')->getFromJson('app.company'); ?> <?php echo app('translator')->getFromJson('app.website'); ?></label>

                                                    <input type="text" class="form-control form-control-lg" id="website"
                                                           name="website" value="<?php echo e($settings->website); ?>">
                                                </div>

                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label"><?php echo app('translator')->getFromJson('app.timezone'); ?></label>

                                                    <select name="timezone" id="timezone"
                                                            class="form-control form-control-lg select2">
                                                        <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option <?php if($settings->timezone == $tz): ?> selected <?php endif; ?>><?php echo e($tz); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label"><?php echo app('translator')->getFromJson('app.currency'); ?></label>

                                                    <select name="currency_id" id="currency_id"
                                                            class="form-control  form-control-lg">
                                                        <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option
                                                                <?php if($currency->id == $settings->currency_id): ?> selected
                                                                <?php endif; ?>
                                                                value="<?php echo e($currency->id); ?>"><?php echo e($currency->currency_symbol.' ('.$currency->currency_code.')'); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label"><?php echo app('translator')->getFromJson('app.language'); ?></label>

                                                    <select name="locale" id="locale"
                                                            class="form-control form-control-lg">
                                                        <?php $__empty_1 = true; $__currentLoopData = $enabledLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                            <option value="<?php echo e($language->language_code); ?>"
                                                                    <?php if($settings->locale == $language->language_code): ?> selected <?php endif; ?> >
                                                                <?php echo e($language->language_name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                            <option <?php if($settings->locale == "en"): ?> selected
                                                                    <?php endif; ?> value="en">English
                                                            </option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button id="save-general" type="button" class="btn btn-success"><i
                                                            class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane table-responsive" id="times">
                                    <table class="table table-condensed">
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th><?php echo app('translator')->getFromJson('app.day'); ?></th>
                                            <th><?php echo app('translator')->getFromJson('modules.settings.openTime'); ?></th>
                                            <th><?php echo app('translator')->getFromJson('modules.settings.closeTime'); ?></th>
                                            <th><?php echo app('translator')->getFromJson('modules.settings.allowBooking'); ?>?</th>
                                            <th><?php echo app('translator')->getFromJson('app.action'); ?></th>
                                        </tr>
                                        <?php $__currentLoopData = $bookingTimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$bookingTime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($key+1); ?></td>
                                                <td><?php echo app('translator')->getFromJson('app.'.$bookingTime->day); ?></td>
                                                <td><?php echo e($bookingTime->start_time); ?></td>
                                                <td><?php echo e($bookingTime->end_time); ?></td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" class="time-status"
                                                               data-row-id="<?php echo e($bookingTime->id); ?>"
                                                               <?php if($bookingTime->status == 'enabled'): ?> checked <?php endif; ?>
                                                        >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <a href="javascript:;" data-row-id="<?php echo e($bookingTime->id); ?>"
                                                       class="btn btn-primary btn-rounded btn-sm edit-row"><i
                                                            class="icon-pencil"></i> <?php echo app('translator')->getFromJson('app.edit'); ?></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="tax">
                                    <form class="form-horizontal ajax-form" id="tax-form" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="tax_name"
                                                           class="control-label"><?php echo app('translator')->getFromJson('app.tax'); ?> <?php echo app('translator')->getFromJson('app.name'); ?></label>

                                                    <input type="text" class="form-control form-control-lg"
                                                           id="tax_name" name="tax_name"
                                                           value="<?php echo e($tax->tax_name); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="percent"
                                                           class="control-label"><?php echo app('translator')->getFromJson('app.percent'); ?></label>

                                                    <input type="number" min="0" step="0.01" value="<?php echo e($tax->percent); ?>"
                                                           class="form-control form-control-lg" id="percent"
                                                           name="percent">
                                                </div>
                                                <div class="form-group">
                                                    <label for="percent"
                                                           class="control-label"><?php echo app('translator')->getFromJson('app.status'); ?></label>

                                                    <select name="status" id="status"
                                                            class="form-control form-control-lg">
                                                        <option
                                                            <?php if($tax->status == 'active'): ?> selected <?php endif; ?>
                                                        value="active"><?php echo app('translator')->getFromJson('app.active'); ?></option>
                                                        <option
                                                            <?php if($tax->status == 'deactive'): ?> selected <?php endif; ?>
                                                        value="deactive"><?php echo app('translator')->getFromJson('app.deactive'); ?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button id="save-tax" type="button" class="btn btn-success"><i
                                                            class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                                </div>

                                            </div>

                                        </div>

                                    </form>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="currency">
                                    <h4><?php echo app('translator')->getFromJson('app.add'); ?> <?php echo app('translator')->getFromJson('app.currency'); ?></h4>
                                    <form class="form-horizontal ajax-form" id="currency-form" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label"><?php echo app('translator')->getFromJson('app.currency'); ?> <?php echo app('translator')->getFromJson('app.name'); ?></label>

                                                    <input type="text" class="form-control form-control-lg"
                                                           id="currency_name" name="currency_name">
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label"><?php echo app('translator')->getFromJson('app.currencySymbol'); ?></label>

                                                    <input type="text" class="form-control form-control-lg"
                                                           id="currency_symbol" name="currency_symbol">
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label"><?php echo app('translator')->getFromJson('app.currencyCode'); ?></label>

                                                    <input type="text" class="form-control form-control-lg"
                                                           id="currency_code" name="currency_code">
                                                </div>

                                                <div class="form-group">
                                                    <button id="save-currency" type="button" class="btn btn-success"><i
                                                            class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                                </div>
                                            </div>

                                        </div>


                                    </form>

                                    <h4 class="mt-4"><?php echo app('translator')->getFromJson('app.currency'); ?></h4>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-condensed">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><?php echo app('translator')->getFromJson('app.currency'); ?> <?php echo app('translator')->getFromJson('app.name'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('app.currencySymbol'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('app.currencyCode'); ?></th>
                                                    <th><i class="fa fa-gear"></i></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr id="currency-<?php echo e($currency->id); ?>">
                                                        <td><?php echo e(($key+1)); ?></td>
                                                        <td><?php echo e(ucwords($currency->currency_name)); ?></td>
                                                        <td><?php echo e($currency->currency_symbol); ?></td>
                                                        <td><?php echo e($currency->currency_code); ?></td>
                                                        <td>
                                                            <button data-row-id="<?php echo e($currency->id); ?>"
                                                                    class="btn btn-sm btn-primary  edit-currency"
                                                                    type="button"><i
                                                                    class="fa fa-edit"></i> <?php echo app('translator')->getFromJson('app.edit'); ?></button>
                                                            <button data-row-id="<?php echo e($currency->id); ?>"
                                                                    class="btn btn-sm btn-danger  delete-currency"
                                                                    type="button"><i
                                                                    class="fa fa-times"></i> <?php echo app('translator')->getFromJson('app.delete'); ?>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="language">
                                    <?php echo $__env->make('admin.language.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="email">
                                    <h4><?php echo app('translator')->getFromJson('app.email'); ?> <?php echo app('translator')->getFromJson('menu.settings'); ?></h4>
                                    <form class="form-horizontal ajax-form" id="email-form" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div id="alert">
                                            <?php if($smtpSetting->mail_driver =='smtp'): ?>
                                                <?php if($smtpSetting->verified): ?>
                                                    <div
                                                        class="alert alert-success"><?php echo e(__('messages.smtpSuccess')); ?></div>
                                                <?php else: ?>
                                                    <div class="alert alert-danger"><?php echo e(__('messages.smtpError')); ?></div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->getFromJson("modules.emailSettings.mailDriver"); ?></label>
                                                    <div class="form-group">
                                                        <label class="radio-inline"><input type="radio"
                                                                                           class="checkbox"
                                                                                           onchange="getDriverValue(this);"
                                                                                           value="mail"
                                                                                           <?php if($smtpSetting->mail_driver == 'mail'): ?> checked
                                                                                           <?php endif; ?> name="mail_driver"> Mail</label>
                                                        <label class="radio-inline pl-lg-2"><input type="radio"
                                                                                                   onchange="getDriverValue(this);"
                                                                                                   value="smtp"
                                                                                                   <?php if($smtpSetting->mail_driver == 'smtp'): ?> checked
                                                                                                   <?php endif; ?> name="mail_driver"> SMTP</label>


                                                    </div>
                                                </div>
                                                <div id="smtp_div">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.emailSettings.mailHost"); ?></label>
                                                        <input type="text" name="mail_host" id="mail_host"
                                                               class="form-control form-control-lg"
                                                               value="<?php echo e($smtpSetting->mail_host); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.emailSettings.mailPort"); ?></label>
                                                        <input type="text" name="mail_port" id="mail_port"
                                                               class="form-control form-control-lg"
                                                               value="<?php echo e($smtpSetting->mail_port); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.emailSettings.mailUsername"); ?></label>
                                                        <input type="text" name="mail_username" id="mail_username"
                                                               class="form-control form-control-lg"
                                                               value="<?php echo e($smtpSetting->mail_username); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            class="control-label"><?php echo app('translator')->getFromJson("modules.emailSettings.mailPassword"); ?></label>
                                                        <input type="password" name="mail_password"
                                                               id="mail_password"
                                                               class="form-control form-control-lg"
                                                               value="<?php echo e($smtpSetting->mail_password); ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label"><?php echo app('translator')->getFromJson("modules.emailSettings.mailEncryption"); ?></label>
                                                        <select class="form-control form-control-lg"
                                                                name="mail_encryption"
                                                                id="mail_encryption">
                                                            <option
                                                                <?php if($smtpSetting->mail_encryption == 'none'): ?> selected <?php endif; ?>>
                                                                none
                                                            </option>
                                                            <option
                                                                <?php if($smtpSetting->mail_encryption == 'tls'): ?> selected <?php endif; ?>>
                                                                tls
                                                            </option>
                                                            <option
                                                                <?php if($smtpSetting->mail_encryption == 'ssl'): ?> selected <?php endif; ?>>
                                                                ssl
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label"><?php echo app('translator')->getFromJson("modules.emailSettings.mailFrom"); ?></label>
                                                    <input type="text" name="mail_from_name" id="mail_from_name"
                                                           class="form-control form-control-lg"
                                                           value="<?php echo e($smtpSetting->mail_from_name); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label
                                                        class="control-label"><?php echo app('translator')->getFromJson("modules.emailSettings.mailFromEmail"); ?></label>
                                                    <input type="text" name="mail_from_email" id="mail_from_email"
                                                           class="form-control form-control-lg"
                                                           value="<?php echo e($smtpSetting->mail_from_email); ?>">
                                                </div>


                                                <div class="form-group">
                                                    <button id="save-email" type="button" class="btn btn-success"><i
                                                            class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                                </div>


                                            </div>

                                            <!--/span-->
                                        </div>

                                    </form>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="admin-theme">
                                    <h4><?php echo app('translator')->getFromJson('menu.adminThemeSettings'); ?></h4>
                                    <section class="mt-3 mb-3">
                                        <form class="form-horizontal ajax-form" id="theme-form" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="row">
                                                <h6 class="col-md-12"><?php echo app('translator')->getFromJson('modules.theme.subheadings.colorPallette'); ?></h6>
                                                <div class="col-md-2 ">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson('modules.theme.primaryColor'); ?></label>
                                                        <input type="text" class="form-control color-picker"
                                                               name="primary_color"
                                                               value="<?php echo e($themeSetting->primary_color); ?>">
                                                        <div
                                                            style="background-color: <?php echo e($themeSetting->primary_color); ?>"
                                                            class=" border border-light">&nbsp;
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-2 ">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson('modules.theme.secondaryColor'); ?></label>
                                                        <input type="text" class="form-control color-picker"
                                                               name="secondary_color"
                                                               value="<?php echo e($themeSetting->secondary_color); ?>">
                                                        <div
                                                            style="background-color: <?php echo e($themeSetting->secondary_color); ?>"
                                                            class=" border border-light">&nbsp;
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson('modules.theme.sidebarBgColor'); ?></label>
                                                        <input type="text" class="form-control color-picker"
                                                               name="sidebar_bg_color"
                                                               value="<?php echo e($themeSetting->sidebar_bg_color); ?>">
                                                        <div
                                                            style="background-color: <?php echo e($themeSetting->sidebar_bg_color); ?>"
                                                            class=" border border-light">&nbsp;
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-2 ">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson('modules.theme.sidebarTextColor'); ?></label>
                                                        <input type="text" class="form-control color-picker"
                                                               name="sidebar_text_color"
                                                               value="<?php echo e($themeSetting->sidebar_text_color); ?>">
                                                        <div
                                                            style="background-color: <?php echo e($themeSetting->sidebar_text_color); ?>"
                                                            class="border border-light">&nbsp;
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-2 ">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson('modules.theme.topbarTextColor'); ?></label>
                                                        <input type="text" class="form-control color-picker"
                                                               name="topbar_text_color"
                                                               value="<?php echo e($themeSetting->topbar_text_color); ?>">
                                                        <div
                                                            style="background-color: <?php echo e($themeSetting->topbar_text_color); ?>"
                                                            class="border border-light">&nbsp;
                                                        </div>
                                                    </div>

                                                </div>


                                                <!--/span-->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button id="save-theme" type="button" class="btn btn-success"><i
                                                            class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </section>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="front-theme">
                                    <h4><?php echo app('translator')->getFromJson('menu.frontThemeSettings'); ?></h4>
                                    <section class="mt-3 mb-3">
                                        <form class="form-horizontal ajax-form" id="front-theme-form" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="row">
                                                <h6 class="col-md-12"><?php echo app('translator')->getFromJson('modules.theme.subheadings.colorPallette'); ?></h6>
                                                <div class="col-md-2 ">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson('modules.theme.primaryColor'); ?></label>
                                                        <input type="text" class="form-control color-picker"
                                                               name="primary_color"
                                                               value="<?php echo e($frontThemeSettings->primary_color); ?>">
                                                        <div
                                                            style="background-color: <?php echo e($frontThemeSettings->primary_color); ?>"
                                                            class=" border border-light">&nbsp;
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-2 ">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson('modules.theme.secondaryColor'); ?></label>
                                                        <input type="text" class="form-control color-picker"
                                                               name="secondary_color"
                                                               value="<?php echo e($frontThemeSettings->secondary_color); ?>">
                                                        <div
                                                            style="background-color: <?php echo e($frontThemeSettings->secondary_color); ?>"
                                                            class=" border border-light">&nbsp;
                                                        </div>
                                                    </div>

                                                </div>
                                                <!--/span-->
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6 class="col-md-12"><?php echo app('translator')->getFromJson('app.logo'); ?></h6>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <input type="file" id="front-input-file-now"
                                                                           name="front_logo"
                                                                           accept=".png,.jpg,.jpeg" class="dropify"
                                                                           data-default-file="<?php echo e($frontThemeSettings->logo_url); ?>"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button id="save-front-theme" type="button" class="btn btn-success">
                                                        <i
                                                            class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </section>
                                    <section class="mt-3 mb-3">
                                        <h6><?php echo app('translator')->getFromJson('modules.theme.subheadings.carouselImages'); ?></h6>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form id="theme-carousel-form">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="form-group">
                                                        
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <input type="file" id="carousel-images" name="images[]"
                                                                       accept=".png,.jpg,.jpeg" class="dropify"
                                                                       
                                                                       data-allowed-formats="landscape"
                                                                       multiple
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <h6 class="text-danger"><?php echo app('translator')->getFromJson('modules.theme.recommendedResolutionNote'); ?></h6>
                                        <div id="carousel-image-gallery" class="row">
                                            <?php echo $__env->make('partials.carousel_images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </section>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="front-pages">
                                    <?php echo $__env->make('admin.page.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="role-permission">
                                    <?php echo $__env->make('admin.role-permission.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="payment">
                                    <h4><?php echo app('translator')->getFromJson('app.paymentCredential'); ?> <?php echo app('translator')->getFromJson('menu.settings'); ?></h4>
                                    <br>
                                    <form class="form-horizontal ajax-form" id="payment-form" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <h5 class="text-primary"><?php echo app('translator')->getFromJson('app.offlinePaymentMethod'); ?></h5>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label"><?php echo app('translator')->getFromJson("modules.paymentCredential.allowOfflinePayment"); ?></label>
                                                    <br>
                                                    <label class="switch">
                                                        <input type="checkbox" name=""
                                                               <?php if($credentialSetting->offline_payment == 1): ?> checked
                                                               <?php endif; ?>  class="offline-payment">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <hr>
                                                <br>
                                                <h5 class="text-info"><?php echo app('translator')->getFromJson('app.paypalCredential'); ?> </h5>
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        <?php echo app('translator')->getFromJson("modules.paymentCredential.paypalCredentialStatus"); ?>
                                                    </label>
                                                    <br>
                                                    <label class="switch">
                                                        <input type="checkbox" name="paypal_status" id="paypal_status"
                                                                <?php if($credentialSetting->paypal_status == 'active'): ?>
                                                                    checked
                                                                <?php endif; ?>  value='active' onchange="toggle('#paypal-credentials');">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div id="paypal-credentials">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.paymentCredential.paypalClientID"); ?></label>
                                                        <input type="text" name="paypal_client_id" id="paypal_client_id"
                                                               class="form-control form-control-lg"
                                                               value="<?php echo e($credentialSetting->paypal_client_id); ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.paymentCredential.paypalSecret"); ?></label>
                                                        <input type="password" name="paypal_secret" id="paypal_secret"
                                                               class="form-control form-control-lg"
                                                               value="<?php echo e($credentialSetting->paypal_secret); ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.paymentCredential.paypalMode"); ?></label>
                                                        <select class="form-control" name="paypal_mode" id="paypal_mode">
                                                            <option <?php if($credentialSetting->paypal_mode === 'sandbox'): ?>
                                                                selected
                                                            <?php endif; ?> value="sandbox">Sandbox</option>
                                                            <option <?php if($credentialSetting->paypal_mode === 'live'): ?>
                                                                selected
                                                            <?php endif; ?> value="live">Live</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <br>
                                                <h5 class="text-warning"><?php echo app('translator')->getFromJson('app.stripeCredential'); ?> </h5>

                                                <div class="form-group">
                                                    <label class="control-label">
                                                        <?php echo app('translator')->getFromJson("modules.paymentCredential.stripeCredentialStatus"); ?>
                                                    </label>
                                                    <br>
                                                    <label class="switch">
                                                        <input type="checkbox" name="stripe_status" id="stripe_status"
                                                                <?php if($credentialSetting->stripe_status == 'active'): ?>
                                                                    checked
                                                                <?php endif; ?> value="active" onchange="toggle('#stripe-credentials');">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    <input type="hidden" name="offline_payment"
                                                            <?php if($credentialSetting->offline_payment == 1): ?> value="1"
                                                            <?php else: ?> value="0" <?php endif; ?> id="offlinePayment">

                                                </div>

                                                <div id="stripe-credentials">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.paymentCredential.stripelClientID"); ?></label>
                                                        <input type="text" name="stripe_client_id" id="stripe_client_id"
                                                                class="form-control form-control-lg"
                                                                value="<?php echo e($credentialSetting->stripe_client_id); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.paymentCredential.stripeSecret"); ?></label>
                                                        <input type="password" name="stripe_secret" id="stripe_secret"
                                                                class="form-control form-control-lg"
                                                                value="<?php echo e($credentialSetting->stripe_secret); ?>">
                                                    </div>
                                                </div>
                                                <br>
                                                <h5 class="text-success"><?php echo app('translator')->getFromJson('app.razorpayCredential'); ?> </h5>
                                                <div class="form-group d-flex flex-column">
                                                    <label class="control-label">
                                                        <?php echo app('translator')->getFromJson("modules.paymentCredential.razorpayCredentialStatus"); ?>
                                                    </label>
                                                    <div class="d-flex">
                                                        <label class="switch mr-2">
                                                            <input type="checkbox" name="razorpay_status" id="razorpay_status"
                                                                    <?php if($credentialSetting->razorpay_status == 'active'): ?>
                                                                        checked
                                                                    <?php endif; ?> value="active" onchange="toggleRazorPay('#razorpay-credentials');">
                                                            <span class="slider round"></span>
                                                        </label>
                                                        <span class="text-danger wrong-currency-message">
                                                            <?php echo app('translator')->getFromJson('modules.paymentCredential.changeCurrencyToINR'); ?> ( <a href="#general" onclick="$('#general-tab').trigger('click');"><?php echo app('translator')->getFromJson('menu.general'); ?></a> )
                                                        </span>
                                                    </div>
                                                </div>

                                                <div id="razorpay-credentials">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.paymentCredential.razorpayKey"); ?></label>
                                                        <input type="text" name="razorpay_key" id="razorpay_key"
                                                                class="form-control form-control-lg"
                                                                value="<?php echo e($credentialSetting->razorpay_key); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.paymentCredential.razorpaySecret"); ?></label>
                                                        <input type="password" name="razorpay_secret" id="razorpay_secret"
                                                                class="form-control form-control-lg"
                                                                value="<?php echo e($credentialSetting->razorpay_secret); ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <button id="save-payment" type="button" class="btn btn-success"><i
                                                            class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                                </div>
                                            </div>

                                            <!--/span-->
                                        </div>

                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="sms-settings">
                                    <h4><?php echo app('translator')->getFromJson('app.smsCredentials'); ?> <?php echo app('translator')->getFromJson('menu.settings'); ?></h4>
                                    <br>
                                    <form class="form-horizontal ajax-form" id="sms-setting-form" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <h5 class="text-info"><?php echo app('translator')->getFromJson('app.nexmoCredential'); ?> </h5>
                                                <div class="form-group">
                                                    <label class="control-label">
                                                            <?php echo app('translator')->getFromJson("modules.nexmoCredential.status"); ?>
                                                    </label>
                                                    <br>
                                                    <label class="switch">
                                                        <input type="checkbox" name="nexmo_status" id="nexmo_status"
                                                                <?php if($smsSetting->nexmo_status == 'active'): ?>
                                                                    checked
                                                                <?php endif; ?> value="active" onchange="toggle('#nexmo-credentials');">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div id="nexmo-credentials">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.nexmoCredential.key"); ?></label>
                                                        <input type="text" name="nexmo_key" id="nexmo_key"
                                                               class="form-control form-control-lg"
                                                               value="<?php echo e($smsSetting->nexmo_key); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.nexmoCredential.secret"); ?></label>
                                                        <input type="password" name="nexmo_secret" id="nexmo_secret"
                                                               class="form-control form-control-lg"
                                                               value="<?php echo e($smsSetting->nexmo_secret); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->getFromJson("modules.nexmoCredential.from"); ?></label>
                                                        <input type="text" name="nexmo_from" id="nexmo_from"
                                                               class="form-control form-control-lg"
                                                               value="<?php echo e($smsSetting->nexmo_from); ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <button id="save-sms-settings" type="button" class="btn btn-success"><i
                                                            class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="update">
                                    <h4><?php echo app('translator')->getFromJson('menu.updateApp'); ?></h4>
                                    <?php echo $__env->make('vendor.froiden-envato.update.update_blade', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                                    <hr>
                                <?php echo $__env->make('vendor.froiden-envato.update.changelog', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <!--/row-->
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-js'); ?>
    <script src="<?php echo e(asset('/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')); ?>"></script>
    <script>
        $(function () {
            $('.wrong-currency-message').hide();
            $('#paypal_status').is(':checked') ? $('#paypal-credentials').show() : $('#paypal-credentials').hide();
            $('#stripe_status').is(':checked') ? $('#stripe-credentials').show() : $('#stripe-credentials').hide();
            $('#razorpay_status').is(':checked') ? $('#razorpay-credentials').show() : $('#razorpay-credentials').hide();
            $('#nexmo_status').is(':checked') ? $('#nexmo-credentials').show() : $('#nexmo-credentials').hide();

            $('#v-pills-tab a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
                $("html, body").scrollTop(0);
            });

            // store the currently selected tab in the hash value
            $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
                var id = $(e.target).attr("href").substr(1);
                window.location.hash = id;
            });

            // on load of the page: switch to the currently selected tab
            var hash = window.location.hash;
            $('#v-pills-tab a[href="' + hash + '"]').tab('show');

            $('#redirect-general').click(function () {

            })
        });

        function checkCurrencyCode(currency_code) {
            if ( currency_code === 'INR') {
                return true;
            }
            else {
                return false;
            }
        }

        $('.edit-row').click(function () {
            var id = $(this).data('row-id');
            var url = '<?php echo e(route('admin.booking-times.edit', ':id')); ?>';
            url = url.replace(':id', id);

            $('#modelHeading').html('<?php echo app('translator')->getFromJson('app.edit'); ?> <?php echo app('translator')->getFromJson('menu.bookingTimes'); ?>');
            $.ajaxModal('#application-modal', url);
        });

        $('.dropify').dropify({
            messages: {
                default: '<?php echo app('translator')->getFromJson("app.dragDrop"); ?>',
                replace: '<?php echo app('translator')->getFromJson("app.dragDropReplace"); ?>',
                remove: '<?php echo app('translator')->getFromJson("app.remove"); ?>',
                error: '<?php echo app('translator')->getFromJson('app.largeFile'); ?>'
            }
        });

        $('.color-picker').colorpicker({
            format: 'hex'
        });

        $('.time-status').change(function () {
            var id = $(this).data('row-id');
            var url = "<?php echo e(route('admin.booking-times.update', ':id')); ?>";
            url = url.replace(':id', id);

            if ($(this).is(':checked')) {
                var status = 'enabled';
            } else {
                var status = 'disabled';
            }

            $.easyAjax({
                url: url,
                type: "POST",
                data: {'_method': 'PUT', '_token': "<?php echo e(csrf_token()); ?>", 'status': status}
            })
        });

        $('.offline-payment').change(function () {

            if ($(this).is(':checked')) {
                $('#offlinePayment').val(1);
            } else {
                $('#offlinePayment').val(0);
            }
        });

        function toggle(elementBox) {
            var elBox = $(elementBox);
            elBox.slideToggle();
        }

        function toggleRazorPay(elementBox) {
            var elBox = $(elementBox);
            if (checkCurrencyCode('<?php echo e($settings->currency->currency_code); ?>')) {
                elBox.slideToggle();
                $('.wrong-currency-message').fadeOut();
            }
            else {
                $('.wrong-currency-message').fadeIn();
                $('#razorpay_status').prop('checked', false);
            }
        }

        $('#save-general').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('admin.settings.update', $settings->id)); ?>',
                container: '#general-form',
                type: "POST",
                file: true,
                data: $('#general-form').serialize()
            })
        });

        $('#save-tax').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('admin.tax-settings.update', $tax->id)); ?>',
                container: '#tax-form',
                type: "POST",
                data: $('#tax-form').serialize()
            })
        });

        $('#save-currency').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('admin.currency-settings.store')); ?>',
                container: '#currency-form',
                type: "POST",
                data: $('#currency-form').serialize()
            })
        });


        $('#save-payment').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('admin.credential.update', $credentialSetting->id)); ?>',
                container: '#payment-form',
                type: "POST",
                data: $('#payment-form').serialize()
            })
        });

        $('#save-sms-settings').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('admin.sms-settings.update', $smsSetting->id)); ?>',
                container: '#sms-setting-form',
                type: "POST",
                data: $('#sms-setting-form').serialize()
            })
        });

        $('#save-theme').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('admin.theme-settings.update', $themeSetting->id)); ?>',
                container: '#theme-form',
                type: "POST",
                data: $('#theme-form').serialize()
            })
        });

        $('#save-front-theme').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('admin.front-theme-settings.update', $frontThemeSetting->id)); ?>',
                container: '#front-theme-form',
                type: "POST",
                file: true,
                data: $('#front-theme-form').serialize()
            })
        });

        $('#carousel-images').change(function (e) {
            $.easyAjax({
                url: '<?php echo e(route('admin.front-theme-settings.store')); ?>',
                container: '#theme-carousel-form',
                type: "POST",
                file: true,
                success: function (response) {
                    $('#carousel-image-gallery').html(response.view);
                }
            });
        });

        $('body').on('click', '.delete-carousel-row', function () {
            var id = $(this).attr('id');
            swal({
                icon: "warning",
                buttons: true,
                dangerMode: true,
                title: "<?php echo app('translator')->getFromJson('errors.areYouSure'); ?>",
                text: "<?php echo app('translator')->getFromJson('errors.deleteWarning'); ?>",
            })
                .then((willDelete) => {
                    if (willDelete) {
                        var url = "<?php echo e(route('admin.front-theme-settings.destroy',':id')); ?>";
                        url = url.replace(':id', id);

                        var token = "<?php echo e(csrf_token()); ?>";

                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                    $.unblockUI();
                                    $('#carousel-image-gallery').html(response.view);
                                }
                            }
                        });
                    }
                });
        });

        $('body').on('click', '.delete-currency', function () {
            var id = $(this).data('row-id');
            swal({
                icon: "warning",
                buttons: true,
                dangerMode: true,
                title: "<?php echo app('translator')->getFromJson('errors.areYouSure'); ?>",
                text: "<?php echo app('translator')->getFromJson('errors.deleteWarning'); ?>",
            })
                .then((willDelete) => {
                    if (willDelete) {
                        var url = "<?php echo e(route('admin.currency-settings.destroy',':id')); ?>";
                        url = url.replace(':id', id);

                        var token = "<?php echo e(csrf_token()); ?>";

                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                    $.unblockUI();
                                    $('#currency-' + id).remove();
                                }
                            }
                        });
                    }
                });
        });


        $('.edit-currency').click(function () {
            var id = $(this).data('row-id');
            var url = '<?php echo e(route('admin.currency-settings.edit', ':id')); ?>';
            url = url.replace(':id', id);

            $('#modelHeading').html('<?php echo app('translator')->getFromJson('app.edit'); ?> <?php echo app('translator')->getFromJson('menu.currency'); ?>');
            $.ajaxModal('#application-modal', url);
        });

        $('#save-email').click(function () {

            $.easyAjax({
                url: '<?php echo e(route('admin.email-settings.update', $smtpSetting->id)); ?>',
                container: '#email-form',
                type: "POST",
                data: $('#email-form').serialize(),
                messagePosition: "inline",
                success: function (response) {
                    if (response.status == 'error') {
                        $('#alert').prepend('<div class="alert alert-danger"><?php echo e(__('messages.smtpError')); ?></div>')
                    } else {
                        $('#alert').show();
                    }
                }
            })
        });

        $('#send-test-email').click(function () {
            $('#testMailModal').modal('show')
        });
        $('#send-test-email-submit').click(function () {
            $.easyAjax({
                url: '<?php echo e(route('admin.email-settings.sendTestEmail')); ?>',
                type: "GET",
                messagePosition: "inline",
                container: "#testEmail",
                data: $('#testEmail').serialize()

            })
        });


        function getDriverValue(sel) {
            if (sel.value == 'mail') {
                $('#smtp_div').hide();
                $('#alert').hide();
            } else {
                $('#smtp_div').show();
                $('#alert').show();
            }
        }

        <?php if($smtpSetting->mail_driver == 'mail'): ?>
        $('#smtp_div').hide();
        $('#alert').hide();
        <?php endif; ?>
    </script>
    <script>
        var table = langTable = '';
        $(document).ready(function() {
            // pages table
            table = $('#myTable').dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '<?php echo route('admin.pages.index'); ?>',
                language: {
                    "url": "<?php echo __("app.datatable") ?>"
                },
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                order: [[0, 'DESC']],
                columns: [
                    { data: 'DT_RowIndex'},
                    { data: 'title', name: 'title' },
                    { data: 'slug', name: 'slug' },
                    { data: 'action', name: 'action', width: '20%' }
                ]
            });
            new $.fn.dataTable.FixedHeader( table );

            $('body').on('click', '.edit-page', function () {
                var slug = $(this).data('slug');
                var url = '<?php echo e(route('admin.pages.edit', ':slug')); ?>';
                url = url.replace(':slug', slug);

                $('#modelLgHeading').html('<?php echo app('translator')->getFromJson('app.edit'); ?> <?php echo app('translator')->getFromJson('menu.page'); ?>');
                $.ajaxModal('#application-lg-modal', url);
            });

            $('body').on('click', '#create-page', function () {
                var url = '<?php echo e(route('admin.pages.create')); ?>';

                $('#modelLgHeading').html('<?php echo app('translator')->getFromJson('app.createNew'); ?> <?php echo app('translator')->getFromJson('menu.page'); ?>');
                $.ajaxModal('#application-lg-modal', url);
            });

            $('body').on('click', '.delete-row', function(){
                var id = $(this).data('row-id');
                swal({
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    title: "<?php echo app('translator')->getFromJson('errors.areYouSure'); ?>",
                    text: "<?php echo app('translator')->getFromJson('errors.deleteWarning'); ?>",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            var url = "<?php echo e(route('admin.pages.destroy',':id')); ?>";
                            url = url.replace(':id', id);

                            var token = "<?php echo e(csrf_token()); ?>";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {'_token': token, '_method': 'DELETE'},
                                success: function (response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
                                        // swal("Deleted!", response.message, "success");
                                        table._fnDraw();
                                    }
                                }
                            });
                        }
                    });
            });

            // language table
            langTable = $('#langTable').dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '<?php echo route('admin.language-settings.index'); ?>',
                language: {
                    "url": "<?php echo __("app.datatable") ?>"
                },
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                order: [[1, 'ASC']],
                columns: [
                    { data: 'DT_RowIndex'},
                    { data: 'name', name: 'name' },
                    { data: 'code', name: 'code' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', width: '20%' }
                ]
            });
            new $.fn.dataTable.FixedHeader( langTable );

            $('body').on('click', '.edit-language', function () {
                var id = $(this).data('row-id');
                var url = '<?php echo e(route('admin.language-settings.edit', ':id')); ?>';
                url = url.replace(':id', id);

                $('#modelHeading').html('<?php echo app('translator')->getFromJson('app.edit'); ?> <?php echo app('translator')->getFromJson('menu.language'); ?>');
                $.ajaxModal('#application-modal', url);
            });

            $('body').on('click', '#create-language', function () {
                var url = '<?php echo e(route('admin.language-settings.create')); ?>';

                $('#modelHeading').html('<?php echo app('translator')->getFromJson('app.createNew'); ?> <?php echo app('translator')->getFromJson('menu.language'); ?>');
                $.ajaxModal('#application-modal', url);
            });

            $('body').on('click', '.delete-language-row', function(){
                var id = $(this).data('row-id');
                const lang = <?php echo $languages; ?>.filter(language => language.id == id);

                swal({
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    title: "<?php echo app('translator')->getFromJson('errors.areYouSure'); ?>",
                    text: "<?php echo app('translator')->getFromJson('errors.deleteWarning'); ?>",
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var url = "<?php echo e(route('admin.language-settings.destroy',':id')); ?>";
                        url = url.replace(':id', id);

                        var token = "<?php echo e(csrf_token()); ?>";

                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                    $.unblockUI();
                                    // swal("Deleted!", response.message, "success");
                                    langTable._fnDraw();

                                    if (lang[0].status == 'enabled') {
                                        location.reload();
                                    }
                                }
                            }
                        });
                    }
                });
            });

            $('body').on('change', '.lang_status', function () {
                const id = $(this).data('lang-id');

                let url = '<?php echo e(route('admin.language-settings.changeStatus', ':id')); ?>'
                url = url.replace(':id', id);

                let status = '';
                if ($(this).is(':checked')) {
                    status = 'enabled';
                }
                else {
                    status = 'disabled';
                }

                $.easyAjax({
                    url: url,
                    type: 'POST',
                    container: '#langTable',
                    data: {
                        id: id,
                        status: status,
                        _method: 'PUT',
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            location.reload();
                        }
                    }
                });
            });
        } );
    </script>
    <?php echo $__env->make('vendor.froiden-envato.update.update_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>