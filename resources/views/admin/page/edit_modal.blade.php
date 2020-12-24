<div class="modal-header">
    <h4 class="modal-title">@lang('app.edit') @lang('app.page')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form role="form" id="editForm"  class="ajax-form" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $page->id }}">
        <div class="row">
            <div class="col-md">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('app.page') @lang('app.title')</label>
                    <input type="text" name="title" id="title" class="form-control form-control-lg" value="{{ $page->title }}" autofocus>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label>@lang('app.page') @lang('app.slug')</label>
                    <input type="text" name="slug" id="slug" class="form-control form-control-lg" value="{{ $page->slug }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>@lang('app.page') @lang('app.content')</label>
                    <textarea name="content" id="content" cols="30" class="form-control-lg form-control" rows="4">{{ $page->content }}</textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
                        class="fa fa-check"></i> @lang('app.save')</button>
        </div>
    </form>
</div>

<script>
    $(function() {
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
        const form = $('#editForm');

        $.easyAjax({
            url: '{{route('admin.pages.update', $page->slug)}}',
            container: '#editForm',
            type: "PUT",
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

    $('#title').keyup(function(e) {
        createSlug($(this).val());
    });

    $('#slug').keyup(function(e) {
        createSlug($(this).val());
    });
</script>
