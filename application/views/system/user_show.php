<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">查看账户</h4>
            </div>

            <div class="modal-body overflow-visible">
                <div class="row">
                    <div class="col-xs-12 col-sm-5">
                            <img src="<?php echo config_item('avatar_url').$info['avatar']; ?>" width="100px" height="100px">
                    </div>

                    <div class="col-xs-12 col-sm-7">
                        <div class="form-group">
                            <label for="form-field-username">用户名称</label>

                            <div>
                                <?php echo $info['username']; ?>
                            </div>
                        </div>

                        <div class="space-4"></div>

                        <div class="form-group">
                            <label for="form-field-first">Email</label>

                            <div>
                                <?php echo $info['email']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>