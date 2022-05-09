
    function ShowHide() {
    var hide = $('#showhide').data('hide');
    if (hide === 'no') {
    $('#showhide').html('<i class="far fa-eye-slash"></i> Ocultar');
    $('#showhide').data('hide', 'yes');
    $('#exampleInputPassword1').attr('type', 'text');
} else {
    $('#showhide').html('<i class="far fa-eye"></i> Mostrar');
    $('#showhide').data('hide', 'no');
    $('#exampleInputPassword1').attr('type', 'password');
}
}
