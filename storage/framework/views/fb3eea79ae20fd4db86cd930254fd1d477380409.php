<div class="modal-header">
    <h4 class="modal-title"><?php echo app('translator')->getFromJson('modules.rolePermission.manageMembers'); ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="table-responsive">
        <table id="roleMemberTable" class="table w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo app('translator')->getFromJson('modules.rolePermission.tables.memberName'); ?></th>
                    <th><?php echo app('translator')->getFromJson('modules.rolePermission.tables.memberRole'); ?></th>
                    <th><?php echo app('translator')->getFromJson('app.action'); ?></th>
                </tr>
            </thead>
        </table>
    </div>

    <hr>
    <form id="add-member-form" class="ajax-form">
        <?php echo csrf_field(); ?>
        <div class="form-body">
            <h5><?php echo app('translator')->getFromJson('modules.rolePermission.addMember'); ?></h5>
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('modules.rolePermission.members'); ?></label>
                        <select class="form-control select2 select2-multiple" name="user_ids[]" id="user_ids" multiple="multiple" data-placeholder="<?php echo app('translator')->getFromJson('modules.rolePermission.forms.addMembers'); ?>">
                            <?php $__currentLoopData = $usersToAdd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="save-add-member" class="btn btn-success"> <i class="fa fa-check"></i>
                <?php echo app('translator')->getFromJson('app.add'); ?></button>
        </div>
    </form>
</div>

<script>
    $('#user_ids').select2({
        allowClear: true
    });

    function renderSelect() {
        $.easyAjax({
            url: '<?php echo e(route('admin.role-permission.getMembersToAdd', $id)); ?>',
            type: 'GET',
            success: function (response) {
                let options = '';
                response.usersToAdd.forEach(user => {
                    options += `<option value='${user.id}'>${user.name}</option>`;
                })

                $('#user_id').html(options);
                $('#user_id').select2();
            }
        })
    }

    roleMemberTable = $('#roleMemberTable').dataTable({
        destroy: true,
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 3,
        lengthChange: false,
        ajax: '<?php echo route('admin.role-permission.getMembers', ['role_id' => $id]); ?>',
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
            { data: 'DT_RowIndex', searchable: false, orderable: false },
            { data: 'name', name: 'name' },
            { data: 'roles.display_name', name: 'roles.display_name' },
            { data: 'action', name: 'action', width: '20%' }
        ]
    });

    $('#save-add-member').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('admin.role-permission.addMembers', ['role_id' => $id])); ?>',
            type: 'POST',
            data: $('#add-member-form').serialize(),
            container: '#add-member-form',
            success: function (response) {
                if (response.status == 'success') {
                    roleMemberTable.fnDraw();
                    $('#user_id').val(null).trigger('change');
                    table_modified = true;
                    renderSelect();
                }
            }
        })
    })

    $('body').on('click', '.delete-member', function () {
        const id = $(this).data('user-id');
        swal({
            icon: "warning",
            buttons: true,
            dangerMode: true,
            title: "<?php echo app('translator')->getFromJson('errors.areYouSure'); ?>",
            text: "<?php echo app('translator')->getFromJson('errors.deleteWarning'); ?>",
        })
        .then((willDelete) => {
            if (willDelete) {
                let url = '<?php echo e(route('admin.role-permission.removeMember')); ?>';

                let data = {
                    _token: '<?php echo e(csrf_token()); ?>',
                    _method: 'DELETE',
                    user_id: id
                }

                $.easyAjax({
                    url,
                    data,
                    type: 'POST',
                    container: '#roleMemberTable',
                    success: function (response) {
                        if (response.status == 'success') {
                            roleMemberTable.fnDraw();
                            table_modified = true;
                            $('#user_id').val(null).trigger('change');
                            renderSelect();
                        }
                    }
                })
            }
        });
    })
</script>
<?php /**PATH E:\laragon\www\booking\resources\views/admin/role-permission/show.blade.php ENDPATH**/ ?>