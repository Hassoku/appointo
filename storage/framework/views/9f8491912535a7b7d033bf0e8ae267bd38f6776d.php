<div class="modal-header">
    <h4 class="modal-title"><?php echo app('translator')->getFromJson('app.createNew'); ?> <?php echo app('translator')->getFromJson('app.page'); ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form role="form" id="createForm" class="ajax-form" method="POST">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md">
                <!-- text input -->
                <div class="form-group">
                    <label><?php echo app('translator')->getFromJson('app.page'); ?> <?php echo app('translator')->getFromJson('app.title'); ?></label>
                    <input type="text" name="title" id="title" class="form-control form-control-lg" value=""
                        autofocus>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label><?php echo app('translator')->getFromJson('app.page'); ?> <?php echo app('translator')->getFromJson('app.slug'); ?></label>
                    <input type="text" name="slug" id="slug" class="form-control form-control-lg" value="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label><?php echo app('translator')->getFromJson('app.page'); ?> <?php echo app('translator')->getFromJson('app.content'); ?></label>
                    <textarea name="content" id="content" cols="30" class="form-control-lg form-control"
                        rows="4"></textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
                    class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
        </div>
    </form>
</div>

<script>
    $(function () {
        $('#content').summernote({
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
    $('#save-form').click(function () {
        // CKEDITOR.instances.content.updateElement()
        const form = $('#createForm');

        $.easyAjax({
            url: '<?php echo e(route('admin.pages.store')); ?>',
            container: '#createForm',
            type: "POST",
            redirect: true,
            data: form.serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $('#application-lg-modal').modal('hide');
                    table._fnDraw();
                }
            }
        })
    });

    function createSlug(value) {
        value = value.replace(/\s\s+/g, ' ');
        let slug = value.split(' ').join('-').toLowerCase();
        slug = slug.replace(/--+/g, '-');
        $('#slug').val(slug);
    }

    $('#title').keyup(function (e) {
        createSlug($(this).val());
    });

    $('#slug').keyup(function (e) {
        createSlug($(this).val());
    });
</script>
<?php /**PATH E:\laragon\www\booking\resources\views/admin/page/create.blade.php ENDPATH**/ ?>