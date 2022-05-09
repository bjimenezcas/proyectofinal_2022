
<?php if($msg!=null): ?>
<div class="toast-container position-fixed p-3 top-0 end-0" style="z-index: 11">
    <div id="toast" class="toast hide" role="alert" aria-live="assertive" data-bs-delay="<?=$msg->timer?>" aria-atomic="true">
        <div class="toast-header">
            <svg class="bd-placeholder-img me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="<?=$msg->type?>"></rect></svg>

            <strong class="me-auto">  <?=$msg->title?></strong>
            <small>Ahora</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?=$msg->body?>
        </div>
    </div>
</div>
<script>

    var myAlert =document.getElementById('toast');
    var bsAlert = new bootstrap.Toast(myAlert);
    bsAlert.show();

</script>
<?php endif; ?>