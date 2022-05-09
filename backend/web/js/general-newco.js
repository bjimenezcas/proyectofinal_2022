/* -------------------------------------------------------------------------------------
 * DOCUMENT.READY...
 * -------------------------------------------------------------------------------------
 */
var window_w = $(window).width();
var window_h = $(window).height();
var is_mobile = false;

// isMobile
!function (a) {
    var b = /iPhone/i, c = /iPod/i, d = /iPad/i, e = /(?=.*\bAndroid\b)(?=.*\bMobile\b)/i, f = /Android/i,
        g = /IEMobile/i, h = /(?=.*\bWindows\b)(?=.*\bARM\b)/i, i = /BlackBerry/i, j = /BB10/i, k = /Opera Mini/i,
        l = /(?=.*\bFirefox\b)(?=.*\bMobile\b)/i, m = new RegExp("(?:Nexus 7|BNTV250|Kindle Fire|Silk|GT-P1000)", "i"),
        n = function (a, b) {
            return a.test(b)
        }, o = function (a) {
            var o = a || navigator.userAgent, p = o.split("[FBAN");
            return "undefined" != typeof p[1] && (o = p[0]), this.apple = {
                phone: n(b, o),
                ipod: n(c, o),
                tablet: !n(b, o) && n(d, o),
                device: n(b, o) || n(c, o) || n(d, o)
            }, this.android = {
                phone: n(e, o),
                tablet: !n(e, o) && n(f, o),
                device: n(e, o) || n(f, o)
            }, this.windows = {
                phone: n(g, o),
                tablet: n(h, o),
                device: n(g, o) || n(h, o)
            }, this.other = {
                blackberry: n(i, o),
                blackberry10: n(j, o),
                opera: n(k, o),
                firefox: n(l, o),
                device: n(i, o) || n(j, o) || n(k, o) || n(l, o)
            }, this.seven_inch = n(m, o), this.any = this.apple.device || this.android.device || this.windows.device || this.other.device || this.seven_inch, this.phone = this.apple.phone || this.android.phone || this.windows.phone, this.tablet = this.apple.tablet || this.android.tablet || this.windows.tablet, "undefined" == typeof window ? this : void 0
        }, p = function () {
            var a = new o;
            return a.Class = o, a
        };
    "undefined" != typeof module && module.exports && "undefined" == typeof window ? module.exports = o : "undefined" != typeof module && module.exports && "undefined" != typeof window ? module.exports = p() : "function" == typeof define && define.amd ? define("isMobile", [], a.isMobile = p()) : a.isMobile = p()
}(this);

// debouncing function from John Hann
// http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
(function ($, sr) {
    var debounce = function (func, threshold, execAsap) {
        var timeout;

        return function debounced() {
            var obj = this, args = arguments;

            function delayed() {
                if (!execAsap)
                    func.apply(obj, args);
                timeout = null;
            };

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 50);
        };
    }
    // smartscroll
    jQuery.fn[sr] = function (fn) {
        return fn ? this.bind('scroll', debounce(fn)) : this.trigger(sr);
    };
})(jQuery, 'smartscroll');

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
    ;
};

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
}


// Document Ready...
$(document).ready(function () {

    mobile_init();

    // Reseteamos los formularios
    $('.watch').trigger("reset");

    $('body').addClass('page-loaded');

    // Tooltips
    $('*[data-toggle="tooltip"]').tooltip();

    $('select').selectBoxIt({
        showFirstOption: false
    });

    $('#provincia').selectBoxIt({
        showFirstOption: true
    });

    $('#origencantidad').selectBoxIt({
        showFirstOption: false
    });


    // Abrir elementos inline
    $('.show-inline').on('click', function (e) {
        e.preventDefault();
        var item_show = $(this).attr('data-show');
        var item_hide = $(this).attr('data-hide');

        var reset1 = $(item_hide).find('.selectable');
        var reset2 = $(item_hide).find('input[type=hidden]');

        reset1.removeClass('active');
        reset2.val('0');

        $(item_show).slideDown(300);
        $(item_hide).slideUp(300);
    });

    selectable();

    turyocio();


    var estadocivil = getUrlParameter('estadocivil');

    if (estadocivil == 'casado') {
        $('.show-casado').show();
    }


    // Slider ingresos anuales
    $("#value-ingresos").val(15000);
    $("#slider-ingresos").slider({
        range: "max",
        min: 0,
        max: 100000,
        step: 1000,
        value: 15000,
        slide: function (event, ui) {
            $("#slider-ingresos").find(".ui-slider-handle").html('<span>' + addCommas(ui.value) + '€</span>');
            $("#value-ingresos").val(ui.value);
        }
    });
    $("#slider-ingresos").find(".ui-slider-handle").html('<span>' + addCommas(15000) + '€</span>');

    // Slider ingresos de la pareja
    $("#value-ingresos-pareja").val(38000);
    $("#slider-pareja").slider({
        range: "max",
        min: 0,
        max: 100000,
        step: 1000,
        value: 38000,
        slide: function (event, ui) {
            $("#slider-pareja").find(".ui-slider-handle").html('<span>' + addCommas(ui.value) + '€</span>');
            $("#value-ingresos-pareja").val(ui.value);
        }
    });
    $("#slider-pareja").find(".ui-slider-handle").html('<span>' + addCommas(38000) + '€</span>');

    // Slider kilómetros
    $("#value-kms").val(15000);
    $("#slider-kms").slider({
        range: "max",
        min: 0,
        max: 50000,
        step: 100,
        value: 15000,
        slide: function (event, ui) {
            $("#slider-kms").find(".ui-slider-handle").html('<span>' + addCommas(ui.value) + '€</span>');
            $("#value-kms").val(ui.value);
        }
    });
    $("#slider-kms").find(".ui-slider-handle").html('<span>' + addCommas(15000) + 'km</span>');


    $('#nacimiento, #fecharesidencia').inputmask({
        mask: 'd/m/y',
        showMaskOnHover: false,
    });

    $('#desde').inputmask({
        mask: 'm/y',
        showMaskOnHover: false,
    });

    $('#iban').inputmask({
        mask: 'aa99[-9999][-9999][-9999][-9999][-9999]',
        showMaskOnHover: false,
    });

    $('#new-iban').inputmask({
        mask: 'ES99[-9999][-9999][-9999][-9999][-9999]',
        showMaskOnHover: false,
    });

    $('#tarjeta-vuelves, #tarjeta-turyocio').inputmask({
        mask: '[9999][-9999][-9999][-9999]',
        //mask: 'd/m/y',
        showMaskOnHover: false,
    });

    $('#numero-tarjeta').inputmask({
        mask: '[9999][-9999][-99][-9999999999]',
        //mask: 'd/m/y',
        showMaskOnHover: false,
    });

    // $('#dninif').inputmask({ 
    //     mask: '[**********]',
    //     showMaskOnHover: false,
    // });

    //$('#telefono, #movil, #particular, #tel-empresa, #tel-empresa-otro').inputmask({ 
    $('#movil, #particular, #tel-empresa, #tel-empresa-otro').inputmask({
        mask: '[999999999]',
        showMaskOnHover: false,
    });


    /*
    $('.newco #nombreyapellidos').keyup(function() {
        var keyed =  $(this).val();
        keyed = keyed.replace(/</g, "").replace(/>/g, "");
        $(this).val(keyed);
        $("#nombretarjeta").html(keyed.substr(0, 22));
    });

    $('.popular #nombreyapellidos').keyup(function() {
        var keyed =  $(this).val();
        keyed = keyed.replace(/</g, "").replace(/>/g, "");
        $(this).val(keyed);
        $("#nombretarjeta").html(keyed.substr(0, 22));
    });
    */

    $('.newco #nombreyapellidos').keyup(function () {
        var keyed = $(this).val();
        $("#nombretarjeta").html(keyed.substr(0, 19));
    });

    $('.popular #nombreyapellidos').keyup(function () {
        var keyed = $(this).val();
        $("#nombretarjeta").html(keyed.substr(0, 19));
    });


    if ($('.floating-labels').length > 0) floatLabels(), inputCantidad();


    function floatLabels() {
        var inputFields = $('.floating-labels .cd-label').next();
        inputFields.each(function () {
            var singleInput = $(this);
            //check if user is filling one of the form fields
            checkVal(singleInput);
            singleInput.on('change keyup', function () {
                checkVal(singleInput);
            });
        });
    }

    function checkVal(inputField) {

        inputField.focus(function () {
            inputField.prev('.cd-label').addClass('float');
        });

        inputField.focusout(function () {
            if (inputField.val() == '') {
                inputField.prev('.cd-label').removeClass('float');
            }
        });
    }


    function inputCantidad() {
        var inputCantidad = $('.form .cantidad input');
        inputCantidad.focus(function () {
            $(this).addClass('focus');
        });

        inputCantidad.focusout(function () {
            if (inputCantidad.val() == '') {
                inputCantidad.removeClass('focus');
            }
        })
    }


    // Mejoras usabilidad
    // $('#tipodoc').change(function(){
    //     tipodoc = $(this).val();
    //     if (tipodoc == 'Pasaporte' || tipodoc == 'Otros') {
    //         $('#dninif').parsley().destroy();
    //         $('#dninif').closest('.form-group').removeClass('empty');

    //         check_submit_button();
    //     }
    //     else {
    //         check_submit_button();
    //     }
    // });

    $("input:radio").focusin(function () {
        $(this).addClass('focus');
    });

    $("input:radio").focusout(function () {
        $(this).removeClass('focus');
    });

    $("#email").focusin(function () {
        $('#email2').val('');
    });

    $("input:radio").focusin(function () {
        $(this).addClass('focus');
    });

    $('.selectboxit').click(function () {
        $(this).toggleClass('focus');
    });

    $("input:radio").focusout(function () {
        $(this).removeClass('focus');
    });

    $('.selectboxit-container').focusin(function () {
        $(this).children().addClass('selectboxit-open');
    });

    $('.selectboxit-container').focusout(function () {
        $(this).children().removeClass('selectboxit-open');
    });

    $('.checkboxwrap').focusin(function () {
        $(this).addClass('focus');
    });

    $('.checkboxwrap').focusout(function () {
        $(this).removeClass('focus');
    });


    $('#situacionlaboral-select').change(function () {
        $(this).closest('.form-group').removeClass('empty');
        $(this).closest('.form-group').find('.selectboxit-enabled').removeClass('selectboxit-error');
        $(this).closest('.form-group').find('.error').hide();

        $('#sector-select').val('');
        var selectBox = $("select#sector-select").data("selectBox-selectBoxIt");
        selectBox.refresh();

        $('.select-sector').find('.error').hide();

        opt = $(this).val();

        if (opt == 0 || opt == 3 || opt == 4) {
            $('.select-sector').removeClass('ok').removeClass('empty').slideUp(300);
        } else {
            $('.select-sector').removeClass('ok').addClass('empty').slideDown(300);
        }
    });


    $('#sector-select').change(function () {
        $(this).closest('.form-group').removeClass('empty');
        $(this).closest('.form-group').find('.selectboxit-enabled').removeClass('selectboxit-error');
        $(this).closest('.form-group').find('.error').hide();

        check_submit_button();
    });


    $('#imagen1').on('change', function () {
        var fileName = $(this).val().split('/').pop().split('\\').pop();
        $('#custom-input-file1 .cd-label').addClass('float');
        $('#custom-input-file-name1 .name').html(fileName);
        $('#custom-input-file-name1').show();

        $('.other-image').slideDown(300);
        $('#custom-input-file-name1').show();
    });

    $('#custom-input-file-name1 .delete').on('click', function () {
        $('#imagen1').val('');
        $('#custom-input-file1 .cd-label').removeClass('float');
        $('#custom-input-file-name1 .name').html('');
        $('#custom-input-file-name1').hide();
    });

    $('#imagen2').on('change', function () {
        var fileName = $(this).val().split('/').pop().split('\\').pop();
        $('#custom-input-file2 .cd-label').addClass('float');
        $('#custom-input-file-name2 .name').html(fileName);
        $('#custom-input-file-name2').show();
    });

    $('#custom-input-file-name2 .delete').on('click', function () {
        $('#imagen2').val('');
        $('#custom-input-file2 .cd-label').removeClass('float');
        $('#custom-input-file-name2 .name').html('');
        $('#custom-input-file-name2').hide();
    });


    /* Evitar inyección de código en formularios */
    /*$('input').keyup(function() {
        var keyed =  $(this).val();
        keyed = keyed.replace(/</g, "").replace(/>/g, "");
        $(this).val(keyed);
    });*/

    $('.sol-form #nombreyapellidos').keyup(function () {
        var keyed = $(this).val();
        keyed = keyed.replace(/</g, "").replace(/>/g, "");
        $(this).val(keyed);
        $("#nombretarjeta").html(keyed.substr(0, 18));
    });

    $('.land-form #nombreyapellidos').keyup(function () {
        var keyed = $(this).val();
        keyed = keyed.replace(/</g, "").replace(/>/g, "");
        $(this).val(keyed);
        $("#nombretarjeta").html(keyed.substr(0, 18));
    });

    $('#tipodoc').change(function () {
        $("#dninif").val('');
    });


    $(window).on('scroll', function () {
        mobile_init();
    });

});

$(window).resize(function () {

    mobile_init();

});

function selectable() {
    $('.selectable').click(function () {
        var target1 = $(this).closest('.row').find('.selectable');
        var target2 = $(this).closest('.row').find('input[type=hidden]');
        target1.removeClass('active');
        target2.val('0');
        $(this).toggleClass('active');
        $(this).find('input[type=hidden]').val('1')
    });

    $('.selectable-unique').click(function () {
        var target1 = $(this).closest('.selectable-unique-wrap').find('.selectable-unique');
        var target2 = $(this).closest('.selectable-unique-wrap').find('input[type=hidden]');
        target1.removeClass('active');
        target2.val('0');
        $(this).toggleClass('active');
        $(this).find('input[type=hidden]').val('1')
    });

    $('.selectable-multiple').click(function () {
        $(this).toggleClass('active');
        $(this).find('input[type=hidden]').val('1')
    });
}


function turyocio() {
    $('#otras-tarjetas').change(function () {

        opt = $(this).val();

        if (opt != "turyocio") {
            $('#label-turyocio').html('');
            $('#tarjeta-turyocio').addClass('color-grey').prop('disabled', true);
            ;
        } else {
            $('#label-turyocio').html('Número de la tarjeta Turyocio');
            $('#tarjeta-turyocio').removeClass('color-grey').prop('disabled', false);
            ;
        }
    });
}

function showBloque1() {

    $("html, body").animate({scrollTop: 0}, 400);

    $('#bloque2').slideUp(100);
    $('#bloque1').fadeIn(200);

    return false;
}

function showBloque2() {

    $("html, body").animate({scrollTop: 0}, 400);

    $('#bloque1').slideUp(100);
    $('#bloque2').fadeIn(200);
    $('#bloque3').hide();

    return false;
}

function showBloque3() {

    $("html, body").animate({scrollTop: 0}, 400);

    $('#bloque2').slideUp(100);
    $('#bloque3').show();

    var estado = $('#estadocivil').val();

    if (estado == 'casado') {
        $('.show-casado').show();
    }
    ;

    // Slider ingresos anuales
    $("#value-ingresos").val(15000);
    $("#slider-ingresos").slider({
        range: "max",
        min: 0,
        max: 100000,
        step: 1000,
        value: 15000,
        slide: function (event, ui) {
            $("#slider-ingresos").find(".ui-slider-handle").html('<span>' + addCommas(ui.value) + '€</span>');
            $("#value-ingresos").val(ui.value);
        }
    });
    $("#slider-ingresos").find(".ui-slider-handle").html('<span>' + addCommas(15000) + '€</span>');

    // Slider ingresos de la pareja
    $("#value-ingresos-pareja").val(38000);
    $("#slider-pareja").slider({
        range: "max",
        min: 0,
        max: 100000,
        step: 1000,
        value: 38000,
        slide: function (event, ui) {
            $("#slider-pareja").find(".ui-slider-handle").html('<span>' + addCommas(ui.value) + '€</span>');
            $("#value-ingresos-pareja").val(ui.value);
        }
    });
    $("#slider-pareja").find(".ui-slider-handle").html('<span>' + addCommas(38000) + '€</span>');

    // Slider kilómetros
    $("#value-kms").val(15000);
    $("#slider-kms").slider({
        range: "max",
        min: 0,
        max: 50000,
        step: 100,
        value: 15000,
        slide: function (event, ui) {
            $("#slider-kms").find(".ui-slider-handle").html('<span>' + addCommas(ui.value) + '€</span>');
            $("#value-kms").val(ui.value);
        }
    });
    $("#slider-kms").find(".ui-slider-handle").html('<span>' + addCommas(15000) + 'km</span>');

    return false;
}

function showBloque4() {

    $("html, body").animate({scrollTop: 0}, 400);

    $('#bloque3').slideUp(100);
    $('#bloque4').fadeIn(200);

    return false;
}


// Funciones especiales para maqueta Visa Cepsa
function showVisaBloque1() {

    $("html, body").animate({scrollTop: 0}, 400);

    $('#bloque2').slideUp(100);
    $('#bloque1').fadeIn(200);

    return false;
}

function showVisaBloque2() {

    $("html, body").animate({scrollTop: 0}, 400);

    $('#bloque1').slideUp(100);
    $('#bloque2').fadeIn(200);
    $('#bloque3').hide();

    var estado = $('#estadocivil').val();

    if (estado == 'casado') {
        $('.show-casado').show();
    }
    ;

    return false;
}

function showVisaBloque3() {

    $("html, body").animate({scrollTop: 0}, 400);

    $('#bloque2').slideUp(100);
    $('#bloque3').show();

    var estado = $('#estadocivil').val();

    if (estado == 'casado') {
        $('.show-casado').show();
    }
    ;

    // Slider ingresos anuales
    $("#value-ingresos").val(15000);
    $("#slider-ingresos").slider({
        range: "max",
        min: 0,
        max: 100000,
        step: 1000,
        value: 15000,
        slide: function (event, ui) {
            $("#slider-ingresos").find(".ui-slider-handle").html('<span>' + addCommas(ui.value) + '€</span>');
            $("#value-ingresos").val(ui.value);
        }
    });
    $("#slider-ingresos").find(".ui-slider-handle").html('<span>' + addCommas(15000) + '€</span>');

    // Slider ingresos de la pareja
    $("#value-ingresos-pareja").val(38000);
    $("#slider-pareja").slider({
        range: "max",
        min: 0,
        max: 100000,
        step: 1000,
        value: 38000,
        slide: function (event, ui) {
            $("#slider-pareja").find(".ui-slider-handle").html('<span>' + addCommas(ui.value) + '€</span>');
            $("#value-ingresos-pareja").val(ui.value);
        }
    });
    $("#slider-pareja").find(".ui-slider-handle").html('<span>' + addCommas(38000) + '€</span>');

    // Slider kilómetros
    $("#value-kms").val(15000);
    $("#slider-kms").slider({
        range: "max",
        min: 0,
        max: 50000,
        step: 100,
        value: 15000,
        slide: function (event, ui) {
            $("#slider-kms").find(".ui-slider-handle").html('<span>' + addCommas(ui.value) + '€</span>');
            $("#value-kms").val(ui.value);
        }
    });
    $("#slider-kms").find(".ui-slider-handle").html('<span>' + addCommas(15000) + 'km</span>');

    return false;
}

function showVisaBloque4() {

    $("html, body").animate({scrollTop: 0}, 400);

    $('#bloque3').slideUp(100);
    $('#bloque4').fadeIn(200);

    return false;
}


function mobile_init() {

    // Detectamos pantalla
    window_w = $(window).width();
    window_h = $(window).height();

    if (window_w <= 767) {
        is_mobile = true;
    } else {
        is_mobile = false;
    }

}
