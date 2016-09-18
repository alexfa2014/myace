<div
    <?php if($_SESSION['info']['status'] == 1) { ?>
        class="alert alert-block alert-success"
    <?php }else if($_SESSION['info']['status'] == 0){ ?>
        class="alert alert-danger"
    <?php }else if($_SESSION['info']['status'] == 2){ ?>
        class="alert alert-warning"
    <?php } ?>
>

    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>

    <?php if($_SESSION['info']['status'] == 1) { ?>
    <i class="icon-ok green"></i>
    <?php }else if($_SESSION['info']['status'] == 0){ ?>
    <i class="icon-remove"></i>
    <?php }else if($_SESSION['info']['status'] == 2){ ?>
        <strong>Warning!</strong>
    <?php } ?>

    <?php echo strip_tags($_SESSION['info']['msg']); ?>
</div>