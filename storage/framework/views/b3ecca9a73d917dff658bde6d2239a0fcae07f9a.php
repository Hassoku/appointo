<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title"><?php echo app('translator')->getFromJson('app.add'); ?> <?php echo app('translator')->getFromJson('app.service'); ?></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md">
                                <!-- text input -->
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.service'); ?> <?php echo app('translator')->getFromJson('app.name'); ?></label>
                                    <input type="text" name="name" id="name" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.service'); ?> <?php echo app('translator')->getFromJson('app.slug'); ?></label>
                                    <input type="text" name="slug" id="slug" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.service'); ?> <?php echo app('translator')->getFromJson('app.description'); ?></label>
                                    <textarea name="description" id="description" cols="30" class="form-control-lg form-control" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.price'); ?></label>
                                    <input type="number" step="0.01" min="0" name="price" id="price" class="form-control form-control-lg"  />

                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('modules.services.discount'); ?></label>
                                    <div class="input-group">
                                        <input type="number" max="100" class="form-control form-control-lg" name="discount" id="discount" min="0" value="0">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary dropdown-toggle" id="discount-type-select" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo app('translator')->getFromJson('modules.services.percent'); ?></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item discount_type" data-type="percent" href="javascript:;"><?php echo app('translator')->getFromJson('modules.services.percent'); ?></a>
                                                <a class="dropdown-item discount_type" data-type="fixed" href="javascript:;"><?php echo app('translator')->getFromJson('modules.services.fixed'); ?></a>
                                            </div>
                                        </div>

                                        <input type="hidden" id="discount-type" name="discount_type" value="percent">

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3 offset-md-1">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('modules.services.discountedPrice'); ?></label>
                                    <p class="form-control-static" id="discounted-price" style="font-size: 1.5rem">--</p>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.location'); ?></label>
                                    <div class="input-group">
                                        <select name="location_id" id="location_id" class="form-control form-control-lg">
                                            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($location->id); ?>"><?php echo e($location->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" onclick="javascript: location = '<?php echo e(route('admin.locations.create')); ?>';" type="button"><i class="fa fa-plus"></i> <?php echo app('translator')->getFromJson('app.add'); ?></button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.category'); ?></label>
                                    <div class="input-group">
                                        <select name="category_id" id="category_id" class="form-control form-control-lg">
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" id="add-category" type="button"><i class="fa fa-plus"></i> <?php echo app('translator')->getFromJson('app.add'); ?></button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('modules.services.time'); ?></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-lg" name="time">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary dropdown-toggle" id="time-type-select" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo app('translator')->getFromJson('app.minutes'); ?></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item time_type" data-type="minutes" href="javascript:;"><?php echo app('translator')->getFromJson('app.minutes'); ?></a>
                                                <a class="dropdown-item time_type" data-type="hours" href="javascript:;"><?php echo app('translator')->getFromJson('app.hours'); ?></a>
                                                <a class="dropdown-item time_type" data-type="days" href="javascript:;"><?php echo app('translator')->getFromJson('app.days'); ?></a>
                                            </div>
                                        </div>

                                        <input type="hidden" id="time-type" name="time_type" value="minutes">

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12">


                                <div class="form-group">
                                    <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('app.image'); ?></label>
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
                                                class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-js'); ?>

    <script>
        $(function () {
            $('#description').summernote({
                dialogsInBody: true,
                height: 300,
                toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ["view", ["fullscreen"]]
            ]
            })
        })
        $('.dropify').dropify({
            messages: {
                default: '<?php echo app('translator')->getFromJson("app.dragDrop"); ?>',
                replace: '<?php echo app('translator')->getFromJson("app.dragDropReplace"); ?>',
                remove: '<?php echo app('translator')->getFromJson("app.remove"); ?>',
                error: '<?php echo app('translator')->getFromJson('app.largeFile'); ?>'
            }
        });

        function createSlug(value) {
            value = value.replace(/\s\s+/g, ' ');
            let slug = value.split(' ').join('-').toLowerCase();
            slug = slug.replace(/--+/g, '-');
            $('#slug').val(slug);
        }

        $('#name').keyup(function(e) {
            createSlug($(this).val());
        });

        $('#slug').keyup(function(e) {
            createSlug($(this).val());
        });

        $('.time_type').click(function () {
            var type = $(this).data('type');

            $('#time-type-select').html(type);
            $('#time-type').val(type);
        });


        $('.discount_type').click(function () {
            var type = $(this).data('type');

            $('#discount-type-select').html(type);
            $('#discount-type').val(type);
            calculateDiscountedPrice();
        });

        $('#save-form').click(function () {

            $.easyAjax({
                url: '<?php echo e(route('admin.business-services.store')); ?>',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#createForm').serialize()
            })
        });

        $('#add-category').click(function () {
            window.location = '<?php echo e(route("admin.categories.create")); ?>';
        });

        $('#discount, #price').keyup(function () {
            if ($(this).val() == '') {
                $(this).val(0);
            }
            calculateDiscountedPrice();
        });

        function calculateDiscountedPrice() {
            var price = $('#price').val();
            var discount = $('#discount').val();
            var discountType = $('#discount-type').val();

            if (discountType == 'percent') {
                if(discount > 100){
                    $('#discount').val(100);
                    discount = 100;
                }
            }
            else {
                if (parseInt(discount) > parseInt(price)) {
                    $('#discount').val(price);
                    discount = price;
                }
            }

            var discountedPrice = price;

            if(discount >= 0 && discount >= '' && price != '' && price > 0){
                if(discountType == 'percent'){
                    discountedPrice = parseFloat(price)-(parseFloat(price)*(parseFloat(discount)/100));
                }
                else{
                    discountedPrice = parseFloat(price)-parseFloat(discount);
                }
            }
            if(discount != '' && price != '' && price > 0){
                $('#discounted-price').html(discountedPrice.toFixed(2));
            }

        }
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/admin/business_service/create.blade.php ENDPATH**/ ?>