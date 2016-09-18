<link rel="stylesheet" href="/static/assets/css/jquery-ui-1.10.3.full.min.css" />
<div class="main-content">
    <?php $this->load->view('common/breadcrumbs'); ?>
    <div class="page-content">
        <div class="page-header">
            <a class="btn btn-white" href="/system/user/userAdd" data-target="#modal-form" data-toggle="modal">新增</a>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->

                <?php if(isset($_SESSION['info'])) $this->load->view('common/alert_block'); ?>

                <div class="row">
                    <div class="col-xs-12">

                        <div class="table-responsive">
                            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="center">
                                        <label>
                                            <input type="checkbox" class="ace" />
                                            <span class="lbl"></span>
                                        </label>
                                    </th>
                                    <th>ID</th>
                                    <th>用户名称</th>
                                    <th class="hidden-480">邮箱</th>

                                    <th>
                                        <i class="icon-time bigger-110 hidden-480"></i>
                                        创建时间
                                    </th>
                                    <th class="hidden-480">修改时间</th>

                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($info as $item):?>
                                    <tr>
                                    <td class="center">
                                        <label>
                                            <input type="checkbox" name="ids" value="<?php echo $item['id']; ?>" class="ace" />
                                            <span class="lbl"></span>
                                        </label>
                                    </td>

                                    <td>
                                        <?php echo $item['id']; ?>
                                    </td>
                                    <td><?php echo $item['username']; ?></td>
                                    <td class="hidden-480"><?php echo $item['email']; ?></td>
                                    <td><?php echo $item['ctime'] == 0 ? '' : date('Y-m-d H:i:s', $item['ctime']); ?></td>

                                    <td class="hidden-480">
                                        <?php echo $item['mtime'] == 0 ? '' : date('Y-m-d H:i:s', $item['mtime']); ?>
                                    </td>

                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">

                                            <a class="blue" href="/system/user/userShow?id=<?php echo $item['id']; ?>" data-target="#modal-form" data-toggle="modal">
                                                <i class="icon-zoom-in bigger-130"></i>
                                            </a>

                                            <a class="green" href="/system/user/userEdit?id=<?php echo $item['id']; ?>" data-target="#modal-form" data-toggle="modal">
                                                <i class="icon-pencil bigger-130"></i>
                                            </a>

                                            <?php if($item['id'] != 1){ ?>
                                            <a class="red" href="javascript:void(0)" onclick="delete_confirm(<?php echo $item['id']; ?>, <?php echo "'".$item['username']."'"; ?>);">
                                                <i class="icon-trash bigger-130"></i>
                                            </a>
                                            <?php } ?>

                                        </div>

                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                            <div class="inline position-relative">
                                                <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-caret-down icon-only bigger-120"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                    <li>
                                                        <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
																				<span class="blue">
																					<i class="icon-zoom-in bigger-120"></i>
																				</span>
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
																				<span class="green">
																					<i class="icon-edit bigger-120"></i>
																				</span>
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
																				<span class="red">
																					<i class="icon-trash bigger-120"></i>
																				</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <button class="btn btn-minier btn-danger" onclick="mutil_delete_confirm()">批量删除</button>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="dialog-confirm" class="hide">
                    <div class="space-6"></div>

                    <p class="bigger-110 bolder center grey">
                        <i class="icon-hand-right blue bigger-120"></i>
                        确认删除吗?
                    </p>
                </div><!-- #dialog-confirm -->

                <div id="modal-form" class="modal" tabindex="-1" role="dialog">
                </div>

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div><!-- /.main-content -->

<?php $this->load->view('common/settings_container'); ?>
</div><!-- /.main-container-inner -->

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->

<?php $this->load->view('common/basic_script'); ?>

<!-- page specific plugin scripts -->

<script src="/static/assets/js/jquery.dataTables.min.js"></script>
<script src="/static/assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="/static/assets/js/jquery-ui-1.10.3.full.min.js"></script>

<!-- ace scripts -->
<script src="/static/assets/js/ace.min.js"></script>
<script src="/static/assets/js/ace-elements.min.js"></script>

<!-- inline scripts related to this page -->

<script type="text/javascript">

    jQuery(function($) {
        var oTable1 = $('#sample-table-2').dataTable( {
            "aoColumns": [
                { "bSortable": false },
                null, null,null, null, null,
                {
                    "bSortable": false
                }
            ]
        } );

        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });

        });


        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            var w2 = $source.width();

            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            return 'left';
        }

        $("#modal-form").on("hide.bs.modal",function(){
            $(this).removeData("bs.modal");
        });
    })

    function delete_confirm(id, uername)
    {
        $( "#dialog-confirm" ).removeClass('hide').dialog({
            resizable: false,
            modal: true,
            title: "确认框-"+uername,
            buttons: [
                {
                    html: "<i class='icon-trash bigger-110'></i>删除",
                    "class" : "btn btn-danger btn-xs",
                    click: function() {
                        $.ajax({
                            type: "POST",
                            dataType:"json",
                            url: "/system/user/userDeleteDo",
                            data: {
                                userid:id
                            },
                            success: function(data){
                                window.location.reload();
                            }
                        });
                    }
                }
                ,
                {
                    html: "<i class='icon-remove bigger-110'></i>取消",
                    "class" : "btn btn-xs",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });
    }

    function mutil_delete_confirm()
    {
        var ids = "";
        $('input[name="ids"]:checked').each(function(){
            ids += $(this).val()+",";
        });

        if(ids == "")
        {
            alert("请勾选要删除的选项");
            return false;
        }
        ids = ids.substring(0,ids.length-1);

        $( "#dialog-confirm" ).removeClass('hide').dialog({
            resizable: false,
            modal: true,
            title: "确认框-批量删除",
            buttons: [
                {
                    html: "<i class='icon-trash bigger-110'></i>批量删除",
                    "class" : "btn btn-danger btn-xs",
                    click: function() {
                        $.ajax({
                            type: "POST",
                            dataType:"json",
                            url: "/system/user/userDeleteDo",
                            data: {
                                userid:ids
                            },
                            success: function(data){
                                window.location.reload();
                            }
                        });
                    }
                }
                ,
                {
                    html: "<i class='icon-remove bigger-110'></i>取消",
                    "class" : "btn btn-xs",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });
    }
</script>