<div class="modal-dialog">
    <form id="myform" action="/system/user/userEditDo" method="post" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">编辑账户</h4>
            </div>

            <div class="modal-body overflow-visible">
                <div class="row">
                    <div class="col-xs-12 col-sm-5">
                        <div class="space"></div>

                        <input name="avatar" type="file" />
                    </div>

                    <img src="<?php echo config_item('avatar_url').$info['avatar']; ?>" width="100px" height="100px">

                    <div class="col-xs-12 col-sm-7">
                        <div class="form-group">
                            <label for="form-field-username">用户名称</label>

                            <div>
                                <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
                                <input class="input-large" name="username" type="text" id="form-field-username" value="<?php echo $info['username']; ?>" />
                            </div>
                        </div>

                        <div class="space-4"></div>

                        <div class="form-group">
                            <label for="form-field-first">Email</label>

                            <div>
                                <input class="input-medium" name="email" type="text" id="form-field-first" value="<?php echo $info['email']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-sm" data-dismiss="modal">
                    <i class="icon-remove"></i>
                    Cancel
                </button>

                <button class="btn btn-sm btn-primary">
                    <i class="icon-ok"></i>
                    Save
                </button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    jQuery(function($) {
        //上传
        var $form = $('#myform');
        var file_input = $form.find('input[type=file]');

        file_input.ace_file_input({
            style:'well',
            btn_choose:'Drop avatar here or click to choose',
            btn_change:null,
            no_icon:'icon-cloud-upload',
            droppable:true,
            thumbnail:'large',

            maxSize: 110000,//bytes
            allowExt: ["jpeg", "jpg", "png", "gif"],
            allowMime: ["image/jpg", "image/jpeg", "image/png", "image/gif"]
        })

        $form.on('submit', function(e) {
            $form.get(0).submit();
        });
    });
</script>