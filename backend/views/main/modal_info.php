<?php
use yii\bootstrap5\Modal;
?>
<?php
//eval($Body);
Modal::begin([
    'id' => 'ModalInfo',
    'title' => $Header,
]);
echo $Body;
Modal::end();

?>
<script> 
   $(document).ready(function(){
    //$('#ModalInfo').modal('show');
});
</script>