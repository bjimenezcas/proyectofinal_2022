var _ori = "SL";

function callService(params, onComplete, onError) {
    $.ajax({
        type: 'POST'
        , url: "ws/popular.api.php"
        , data: params
        , success: function (data) {
        }
        , complete: onComplete
        , error: onError
        , dataType: 'json'
    });
}

function g(id) {
    return document.getElementById(id);
}

function showSector(e) {
    $("#panel_sector").css("display", "none");

    // console.log(e.value);

    switch (e.value) {
        case "00002":
        case "00003":
            $("#panel_sector").css("display", "block");
            $("#sector").data("selectBox-selectBoxIt").selectOption("");
            break;
    }
}

function formatMoney() {

}

function setName1() {

}

function getCodeByText(act) {
    var res = "";
    switch (act) {
        case "Ama de casa":
            res = "0992";
            break;
        case "Desempleado":
            res = "0993";
            break;
        case "Estudiante":
            res = "0991";
            break;
        case "Jubilado":
        case "Prejubilado":
        case "Pensionista":
            res = "0701";
            break;
        case "Rentista":
            res = "0702";
            break;

        case "Alto cargo directivo":
            res = "0309";
            break;
        case "Cargo medio / Gerente":
            res = "0308";
            break;
        case "Técnico":
            res = "0307";
            break;
        case "Militar, Policía":
            res = "0501";
            break;
        case "Funcionario":
            res = "0613";
            break;
        case "Administrativo":
            res = "0304";
            break;
        case "Profesor":
            res = "0231";
            break;
        case "Vendedor / Encargado":
            res = "0399";
            break;
        case "Obreros y operarios":
            res = "0302";
            break;
        case "Médico":
            res = "0222";
            break;
        case "Personal hostelería y restauración":
            res = "0300";
            break;
        case "Otros":
            res = "0999";
            break;

        case "Empresario / Comerciante":
            res = "0199";
            break;
        case "Profesión liberal":
            res = "0310";
            break;
        case "Técnico":
            res = "0307";
            break;
    }

    return res;
}

function showTipoActividad(e) {
    var options = '<option value="" selected>Elige actividad</option>';
    options += '<option value="">Elige actividad</option>';
    switch (e.value) {
        case "00001":
            options += '<option value="0992">Ama de casa</option>';
            options += '<option value="0993">Desempleado</option>';
            options += '<option value="0991">Estudiante</option>';
            options += '<option value="0701">Prejubilado</option>';
            options += '<option value="0701">Jubilado</option>';
            options += '<option value="0701">Pensionista</option>';
            options += '<option value="0702">Rentista</option>';
            break;

        case "00002":
            options += '<option value="0309">Alto cargo directivo</option>';
            options += '<option value="0308">Cargo medio / Gerente</option>';
            options += '<option value="0307">Técnico</option>';
            options += '<option value="0501">Militar, Policía</option>';
            options += '<option value="0613">Funcionario</option>';
            options += '<option value="0304">Administrativo</option>';
            options += '<option value="0231">Profesor</option>';
            options += '<option value="0399">Vendedor / Encargado</option>';
            options += '<option value="0302">Obreros y operarios</option>';
            options += '<option value="0222">Médico</option>';
            options += '<option value="0300">Personal hostelería y restauración</option>';
            options += '<option value="0999">Otros</option>';
            break;

        case "00003":
            options += '<option value="0199">Empresario / Comerciante</option>';
            options += '<option value="0310">Profesión liberal</option>';
            options += '<option value="0307">Técnico</option>';
            break;
    }

    if (options != "") {
        $("#actividad").html(options);
        $('#actividad').data('selectBox-selectBoxIt').refresh();

        $("#panel_act").css("display", "block");
    } else {
        $("#panel_act").css("display", "none");
    }
}

function inputLimiter(e, allow) {
    if (allow == "Letters") {
        if (e.keyCode == 123 || e.keyCode == 125 || e.keyCode == 93 || e.keyCode == 91) {
            return false;
        }
    }

    var AllowableCharacters = '';

    if (allow == 'Letters') {
        AllowableCharacters = ' ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚáéíóúÜüàèòùìÀÈÌÒÙÄËÏÖäëïöâêîôûÂÊÎÔÛçÇ';
    }
    if (allow == 'Numbers') {
        AllowableCharacters = '1234567890';
    }
    if (allow == 'NameCharacters') {
        AllowableCharacters = ' ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-.\'';
    }
    if (allow == 'NameCharactersAndNumbers') {
        AllowableCharacters = '1234567890 ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-\'';
    }

    var k = document.all ? parseInt(e.keyCode) : parseInt(e.which);
    if (k != 13 && k != 8 && k != 0) {
        if ((e.ctrlKey == false) && (e.altKey == false)) {
            return (AllowableCharacters.indexOf(String.fromCharCode(k)) != -1);
        } else {
            return true;
        }
    } else {
        return true;
    }
}


function validate_number(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

function checkParams1(element) {
    g("e_nombre").innerHTML = "";
    g("e_email").innerHTML = "";
    g("e_email2").innerHTML = "";
    g("e_telefono").innerHTML = "";
    g("e_condiciones").innerHTML = "";

    /*var cid_1 = getParameterByName("cid");
    var a_1 = getParameterByName("a");
    var ua_1 = getParameterByName("ua");
    var p5_1 = getParameterByName("p5");
    var p6_1 = getParameterByName("p6");
    var p7_1 = getParameterByName("p7");
    var p8_1 = getParameterByName("p8");
    var p_1 = getParameterByName("p");
    var f_1 = getParameterByName("f");
    var b_1 = getParameterByName("b");
    var l_1 = getParameterByName("l");
    */

    if (g("telefono").value.length != 9 && (g("telefono").value[0] != "6" || g("telefono").value[0] != "7")) {
        g("e_telefono").innerHTML = "Por favor, introduzca un número de móvil válido.";
        return 0;
    }

    callService({
        a1: "check_deposito_corto"
        , nombre: g("nombre").value
        , email: g("email").value
        , email2: g("email2").value
        , telefono: g("telefono").value
        , condiciones: g("condiciones").checked ? "ok" : ""
        , cid: _cid
        , a: _a
        , ua: _ua
        , p5: _p5
        , p6: _p6
        , p7: _p7
        , p8: _p8
        , p: _p
        , f: _f
        , b: _b
        , l: _l
    }, onCheckParams, onCheckParamsError);
}

function onCheckParams(data) {

    /*g("e_nombre").innerHTML = "";
    g("e_email").innerHTML = "";
    g("e_email2").innerHTML = "";
    g("e_telefono").innerHTML = "";
    g("e_condiciones").innerHTML = "";
    */

    // console.log(data.responseJSON);

    if (data.responseJSON) {
        for (var i = 0; i < data.responseJSON.length; i++) {
            //data.responseJSON[i]
            if (data.responseJSON[i].type != "ok") {
                g("e_" + data.responseJSON[i].type).innerHTML = data.responseJSON[i].desc;
            }
        }
        ;
    }

    //activateBtns();
}

function onCheckParamsError(error) {
}

function activateBtns() {
    var ok = g("e_nombre").innerHTML == "" && g("e_email").innerHTML == "" && g("e_email2").innerHTML == "" && g("e_telefono").innerHTML == "" && g("e_condiciones").innerHTML == "" && g("condiciones").checked;

    if (ok) {
        g("te_llamamos").className = g("te_llamamos").className.replace(" disabled-fake", "");
        g("continuar_form").className = g("continuar_form").className.replace(" disabled-fake", "");
    } else {
        if (g("te_llamamos").className.indexOf("disabled-fake") < 0) g("te_llamamos").className += " disabled-fake";
        if (g("continuar_form").className.indexOf("disabled-fake") < 0) g("continuar_form").className += " disabled-fake";
    }
}

function callme() {
    // console.log(data.responseJSON["link"], _ori);

    callService({
        a1: "call"
        , cid: _cid
        , a: _a
        , ua: _ua
        , p5: _p5
        , p6: _p6
        , p7: _p7
        , p8: _p8
        , p: _p
        , f: _f
        , b: _b
        , l: _l
        , ori: _ori
    }, onCallMe, onCallMeError);
}

function onCallMe(data) {
    //console.log(data.responseJSON["link"], _ori);
    window.location.href = data.responseJSON["link"];
}

function validateCondiciones() {
    if (!g("condiciones").checked) {
        g("e_condiciones").innerHTML = "Debe aceptar las condiciones";
        g("e_condiciones").style.display = "block";
        return false;
    }

    if (g("telefono").value.length != 9 && (g("telefono").value[0] != "6" || g("telefono").value[0] != "7")) {
        g("e_telefono").innerHTML = "Por favor, introduzca un número de móvil válido.";
        return false;
    }

    g("e_condiciones").style.display = "none";
    return true;
}

function onCallMeError() {

}

function validaFechaDDMMAAAA_2(fecha) {
    var dtCh = "/";
    var minYear = 1900;
    var maxYear = 2100;

    function isInteger(s) {
        var i;
        for (i = 0; i < s.length; i++) {
            var c = s.charAt(i);
            if (((c < "0") || (c > "9"))) return false;
        }
        return true;
    }

    function stripCharsInBag(s, bag) {
        var i;
        var returnString = "";
        for (i = 0; i < s.length; i++) {
            var c = s.charAt(i);
            if (bag.indexOf(c) == -1) returnString += c;
        }
        return returnString;
    }

    function daysInFebruary(year) {
        return (((year % 4 == 0) && ((!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28);
    }

    function DaysArray(n) {
        for (var i = 1; i <= n; i++) {
            this[i] = 31
            if (i == 4 || i == 6 || i == 9 || i == 11) {
                this[i] = 30
            }
            if (i == 2) {
                this[i] = 29
            }
        }
        return this
    }

    function isDate(dtStr) {
        var daysInMonth = DaysArray(12)
        var pos1 = dtStr.indexOf(dtCh)
        var pos2 = dtStr.indexOf(dtCh, pos1 + 1)
        var strDay = dtStr.substring(0, pos1)
        var strMonth = dtStr.substring(pos1 + 1, pos2)
        var strYear = dtStr.substring(pos2 + 1)
        strYr = strYear
        if (strDay.charAt(0) == "0" && strDay.length > 1) strDay = strDay.substring(1)
        if (strMonth.charAt(0) == "0" && strMonth.length > 1) strMonth = strMonth.substring(1)
        for (var i = 1; i <= 3; i++) {
            if (strYr.charAt(0) == "0" && strYr.length > 1) strYr = strYr.substring(1)
        }
        month = parseInt(strMonth)
        day = parseInt(strDay)
        year = parseInt(strYr)
        if (pos1 == -1 || pos2 == -1) {
            return false
        }
        if (strMonth.length < 1 || month < 1 || month > 12) {
            return false
        }
        if (strDay.length < 1 || day < 1 || day > 31 || (month == 2 && day > daysInFebruary(year)) || day > daysInMonth[month]) {
            return false
        }
        if (strYear.length != 4 || year == 0 || year < minYear || year > maxYear) {
            return false
        }
        if (dtStr.indexOf(dtCh, pos2 + 1) != -1 || isInteger(stripCharsInBag(dtStr, dtCh)) == false) {
            return false
        }
        return true
    }

    if (isDate(fecha)) {
        return true;
    } else {
        return false;
    }
}

function checkParams2(e) {
    if (g("nacimiento").value != "") {
        //var fe_nac = g("nacimiento").value.replace("/", "").replace("/", "");
        // var	valor_fec = new Date(fe_nac[2], fe_nac[1], fe_nac[0]);
        if (!validaFechaDDMMAAAA_2(g("nacimiento").value)) {
            $("#e_nacimiento").html("Por favor, escribe una fecha correcta");
            return false;
        } else {
            $("#e_nacimiento").html("");
        }
    }


    // checkPD();

    if (e.id == "gen1" || e.id == "gen2") {
        g("e_genero").innerHTML = "";
    } else {
        g("e_" + e.id).innerHTML = "";
    }

    if (g("laboral").value == "") {
        // g("laboral").value = "00001";
        g("panel_act").style.display = "none"
        //$("#actividad").val("");
        //$("#actividad").data("selectBox-selectBoxIt").selectOption("");
    } else {
        g("panel_act").style.display = "block"
        //$("#actividad").val("");
        //$("#actividad").data("selectBox-selectBoxIt").selectOption("");
    }

    /*var act = "0992";
    switch (g("laboral").value) {
        case '00002':
            act = "0309";
        break;

        case '00003':
            act = "0199";
        break;
    }*/

    act = $("#actividadSelectBoxItText").text(); //getCodeByText($("#actividadSelectBoxItText").text());
    if (act == "Elige actividad" && g("laboral").value != "") {
        act = "";
    }

    g("laboral_f").value = g("laboral").value;
    if (act != "") g("actividad_f").value = act;

    if (act == "") {
        // g("laboral").value = "00001";
        $("#sector").data("selectBox-selectBoxIt").selectOption("");
    }

    var sect = g("sector").value;
    if (sect == "" || sect == null) {
        sect = "001911";
    }

    var nac = g("nacionalidad").value;
    if (nac == "") {
        nac = "España";
    }

    var tt = g("iban").value;
    while (tt.indexOf("-") >= 0) {
        tt = tt.replace("-", "");
    }
    while (tt.indexOf(" ") >= 0) {
        tt = tt.replace(" ", "");
    }
    var cc = g("cantidad").value.replace(",00", "").replace(".", "").replace(".", "").replace(",", ".");
    var i_min = g("i_min").value.replace(",00", "").replace(".", "").replace(".", "");
    var i_max = g("i_max").value.replace(",00", "").replace(".", "").replace(".", "");

    if (Number(cc) > 250000) {
        g("e_cantidad").innerHTML = "Como máximo puedes destinar 250.000,00€ al depósito";
        return false;
    }

    /*
    if (g("dni").value != "" && isNaN(g("dni").value[0]) && g("nacionalidad").value == "España") {
        $("#e_nacionalidad").text("Por favor, elige una nacionalidad correcta");
    }
    else if (!isNaN(g("dni").value[0]) && g("nacionalidad").value == "España") {
        $("#e_nacionalidad").text("");
    }
    */

    if (g("dni").value != "" && isNaN(g("dni").value[0]) && g("nacionalidad").value == "España") {
        $("#e_nacionalidad").text("Por favor, elige una nacionalidad correcta");
    } else if (!isNaN(g("dni").value[0]) || (isNaN(g("dni").value[0]) && g("nacionalidad").value != "España")) {
        $("#e_nacionalidad").text("");
    }

    // console.log(g("laboral").value);
    // if (act == "Elige actividad" && g("laboral").value != "") { $("#e_actividad").text("Por favor, elige el tipo de actividad"); return 0; }

    var params = {
        a1: "check_deposito_avanzado"
        , dni: g("dni").value
        , nombre: g("nombre").value
        , apellido1: g("apellido1").value
        , apellido2: g("apellido2").value
        , email: _e
        , tel: _tt
        , prod: _prod
        , nacimiento: g("nacimiento").value
        , dondenaciste: g("dondenaciste").value
        , nacionalidad: g("nacionalidad").value
        , genero: g("gen1").checked ? "MUJER" : g("gen2").checked ? "HOMBRE" : ""
        , tipovia: g("tipovia").value
        , direccion: g("direccion").value
        , cp: g("cp").value
        , provincia: g("provincia").value
        , localidad: g("localidad").value
        , residencia: g("residencia").value
        , laboral: g("laboral").value
        , actividad: act
        , sector: sect
        , cantidad: cc
        , origen: g("origen").value
        , iban: tt
        , cid: _cid
        , a: _a
        , ua: _ua
        , p5: _p5
        , p6: _p6
        , p7: _p7
        , p8: _p8
        , p: _p
        , f: _f
        , b: _b
        , l: _l
        , i_min: i_min
        , i_max: i_max
    };

    // console.log("LLAMANDO A check_deposito_avanzado", params);
    callService(params, onCheckParams2, onCheckParamsError2);
}

function onCheckParams2(data) {
    // console.log(data);
    /*if (data.responseJSON.type != "ok") {
        g("e_" + data.responseJSON.type).innerHTML = data.responseJSON.desc;
    }

    activateBtn();
    */
    if (data.responseJSON) {
        for (var i = 0; i < data.responseJSON.length; i++) {
            //data.responseJSON[i]
            if (data.responseJSON[i].type != "ok") {
                g("e_" + data.responseJSON[i].type).innerHTML = data.responseJSON[i].desc;
            }
        }
        ;
    }
}

function activateBtn() {
    var ok = g("e_dni").innerHTML == "" && g("e_nacimiento").innerHTML == "" && g("e_dondenaciste").innerHTML == "" && g("e_nacionalidad").innerHTML == "";
    ok = ok && g("e_genero").innerHTML == "" && g("e_tipovia").innerHTML == "" && g("e_cp").innerHTML == "" && g("e_provincia").innerHTML == "" && g("e_localidad").innerHTML == "";
    ok = ok && g("e_residencia").innerHTML == "" && g("e_laboral").innerHTML == "" && g("e_sector").innerHTML == "" && g("e_cantidad").innerHTML == "" && g("e_origen").innerHTML == "";
    ok = ok && g("e_iban").innerHTML == "" && g("e_genero").value != "";

    if (ok) {
        g("finalizar").className = g("finalizar").className.replace(" disabled-fake", "");
    } else {
        if (g("finalizar").className.indexOf("disabled-fake") < 0) g("finalizar").className += " disabled-fake";
    }
}

function onCheckParamsError2(error) {
}


//Recoge url parametro
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

//Separa nombre y apellidos
/*
var Nombre = "";
var Apellido1 = "";
var Apellido2 = "";

var person = parseNombreyAppellido($("#nombreyapellidos").val());

Nombre = person.Nombre;
Apellido1 = person.Apellido1;
Apellido2 = person.Apellido2;

*/
function parseNombreyAppellido(NombreyAppellidos) {
    Nombre = "";
    Apellido1 = "";
    Apellido2 = "";
    if (NombreyAppellidos == "") {
        return {
            Nombre: Nombre
            , Apellido1: Apellido1
            , Apellido2: Apellido2
        }
    } else {
        str = NombreyAppellidos.replace(/\s+/g, ' '); //Space 
        var res = str.split(" ");
        var count = res.length;

        if (count == 1) {
            Nombre = res[0];
            Apellido1 = ".";
            Apellido2 = ".";
        } else if (count == 2) {
            Nombre = res[0];
            Apellido1 = res[1];
            //Apellido2 = res[1];
            Apellido2 = ".";
        } else if (count == 3) {
            Nombre = res[0];
            Apellido1 = res[1];
            Apellido2 = res[2];
        } else if (count == 4) {
            Nombre = res[0] + " " + res[1];
            Apellido1 = res[2];
            Apellido2 = res[3];
        } else {

            Nombre = res[0] + " " + res[1];
            Apellido1 = res[2];

            for (i = 3; i < res.length; i++) {
                Apellido2 += res[i] + " ";
            }
            Nombre.trim();
            Apellido1.trim();
            Apellido2.trim();
        }

        if (Nombre === undefined) {
            Nombre = "";
        }
        if (Apellido1 === undefined) {
            Apellido1 = "";
        }
        if (Apellido2 === undefined) {
            Apellido2 = "";
        }

        return {
            Nombre: Nombre
            , Apellido1: Apellido1
            , Apellido2: Apellido2
        }
    }
}

function replaceAll(find, replace, str) {
    return str.replace(new RegExp(find, 'g'), replace);
}


/*
	fecha = $("#nacimiento").val();//JQuery ID
	var fechaNacimiento = fechaSQL(fecha);
	if (fechaNacimiento.indexOf('_') > -1) {
		fechaNacimiento = '1900-01-01 00:00:00.000';
	}
*/
function fechaSQL(fecha) {
    //var str = $("#nacimiento").val();
    var day = fecha.substring(0, 2);
    var month = fecha.substring(3, 5);
    var year = fecha.substring(6, 10);
    var nacimiento = year + "-" + month + "-" + day + " 00:00:00";
    return nacimiento;

}


function isDNI() {
    if (!validateDNI2(g("dni").value)) {
        // g("nacionalidad").removeAttribute("disabled");
        $("select#nacionalidad").selectBoxIt().data("selectBoxIt").enable();
    } else {
        g("nacionalidad").value = "España";
        // g("nacionalidad").setAttribute("disabled", "");
        $("select#nacionalidad").selectBoxIt().data("selectBoxIt").disable();
    }
}

/*
 * Tiene que recibir el dni sin espacios ni guiones
 * Esta funcion es llamada
 */
function validateDNI2(dni) {
    var lockup = 'TRWAGMYFPDXBNJZSQVHLCKE';
    var valueDni = dni.substr(0, dni.length - 1);
    var letra = dni.substr(dni.length - 1, 1).toUpperCase();

    if (lockup.charAt(valueDni % 23) == letra)
        return true;
    return false;
}

function checkPD() {
    var provincias = {
        "Álava": "01"
        , "Albacete": "02"
        , "Alicante": "03"
        , "Almería": "04"
        , "Asturias": "33"
        , "Ávila": "05"
        , "Badajoz": "06"
        , "Barcelona": "08"
        , "Burgos": "09"
        , "Cáceres": "10"
        , "Cádiz": "11"
        , "Cantabria": "39"
        , "Castellón": "12"
        , "Ceuta": "51"
        , "Ciudad Real": "13"
        , "Córdoba": "14"
        , "Cuenca": "16"
        , "Girona": "17"
        , "Las Palmas": "35"
        , "Granada": "18"
        , "Guadalajara": "19"
        , "Guipúzcoa": "20"
        , "Huelva": "21"
        , "Huesca": "22"
        , "Illes Balears": "07"
        , "Jaén": "23"
        , "A Coruña": "15"
        , "La Rioja": "26"
        , "León": "24"
        , "Lleida": "25"
        , "Lugo": "27"
        , "Madrid": "28"
        , "Málaga": "29"
        , "Melilla": "52"
        , "Murcia": "30"
        , "Navarra": "31"
        , "Ourense": "32"
        , "Palencia": "34"
        , "Pontevedra": "36"
        , "Salamanca": "37"
        , "Segovia": "40"
        , "Sevilla": "41"
        , "Soria": "42"
        , "Tarragona": "43"
        , "Santa Cruz de Tenerife": "38"
        , "Teruel": "44"
        , "Toledo": "45"
        , "Valencia": "46"
        , "Valladolid": "47"
        , "Vizcaya": "48"
        , "Zamora": "49"
        , "Zaragoza": "50"
    };

    var cp_n = g("cp").value.substring(0, 2);

    // Georgi (2016-06-13)
    /*
    var provSelected = "";
    for (var tt in provincias) {
        if (provincias[tt] == cp_n) {
            provSelected = tt;
        }
    };

    if (provSelected != "") {
        // g("provincia").value = provSelected;
        $("#provinciaSelectBoxItText").text(provSelected);
    }

    // console.log($("#provinciaSelectBoxItText").text(), cp_n);
    */

    // if (provincias[g("provincia").value] == cp_n) {
    if ($("#provinciaSelectBoxItText").text() == cp_n) {
        g("e_provincia").innerHTML = "";
    }

    // console.log(cp_n, g("provincia").value, provincias[g("provincia").value]);
}

function checkPD_2() {
    var provincias = {
        "Álava": "01"
        , "Albacete": "02"
        , "Alicante": "03"
        , "Almería": "04"
        , "Asturias": "33"
        , "Ávila": "05"
        , "Badajoz": "06"
        , "Barcelona": "08"
        , "Burgos": "09"
        , "Cáceres": "10"
        , "Cádiz": "11"
        , "Cantabria": "39"
        , "Castellón": "12"
        , "Ceuta": "51"
        , "Ciudad Real": "13"
        , "Córdoba": "14"
        , "Cuenca": "16"
        , "Girona": "17"
        , "Las Palmas": "35"
        , "Granada": "18"
        , "Guadalajara": "19"
        , "Guipúzcoa": "20"
        , "Huelva": "21"
        , "Huesca": "22"
        , "Illes Balears": "07"
        , "Jaén": "23"
        , "A Coruña": "15"
        , "La Rioja": "26"
        , "León": "24"
        , "Lleida": "25"
        , "Lugo": "27"
        , "Madrid": "28"
        , "Málaga": "29"
        , "Melilla": "52"
        , "Murcia": "30"
        , "Navarra": "31"
        , "Ourense": "32"
        , "Palencia": "34"
        , "Pontevedra": "36"
        , "Salamanca": "37"
        , "Segovia": "40"
        , "Sevilla": "41"
        , "Soria": "42"
        , "Tarragona": "43"
        , "Santa Cruz de Tenerife": "38"
        , "Teruel": "44"
        , "Toledo": "45"
        , "Valencia": "46"
        , "Valladolid": "47"
        , "Vizcaya": "48"
        , "Zamora": "49"
        , "Zaragoza": "50"
    };


    var cp_n = g("cp").value.substring(0, 2);

    // if (provincias[g("provincia").value] == cp_n) {
    if ($("#provinciaSelectBoxItText").text() == cp_n) {
        g("e_provincia").innerHTML = "";
    }

    // console.log(cp_n, g("provincia").value, provincias[g("provincia").value]);
}

function checkIBAN_ES(iban) {
    if (!validaIBAN(iban)) {
        g("e_iban").innerHTML = "Por favor, introduzca un IBAN correcto.";
    }
}

// Función que devuelve los números correspondientes a cada letra
function getNumIBAN(letra) {
    var letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return letras.search(letra) + 10;
}

// Función que calcula el módulo sin hacer ninguna división
function mod(dividendo, divisor) {
    var cDividendo = '';
    var cResto = '';

    for (var i in dividendo) {
        var cChar = dividendo[i];
        var cOperador = cResto + '' + cDividendo + '' + cChar;

        if (cOperador < parseInt(divisor)) {
            cDividendo += '' + cChar;
        } else {
            cResto = cOperador % divisor;
            if (cResto == 0) {
                cResto = '';
            }
            cDividendo = '';
        }
    }
    cResto += '' + cDividendo;
    if (cResto == '') {
        cResto = 0;
    }
    return cResto;
}

// El típico trim que inexplicamente JavaScript no trae implementado
function trim(texto) {
    return texto.replace(/^\s+/g, '').replace(/\s+$/g, '');
}

// Función que comprueba el IBAN
function validaIBAN(IBAN) {
    IBAN = IBAN.toUpperCase();
    IBAN = trim(IBAN); // Quita espacios al principio y al final
    IBAN = IBAN.replace(/\s/g, ""); // Quita espacios del medio
    var num1, num2;
    var isbanaux;
    if (IBAN.length != 24) { // En España el IBAN son 24 caracteres
        return false;
    } else {
        num1 = getNumIBAN(IBAN.substring(0, 1));
        num2 = getNumIBAN(IBAN.substring(1, 2));
        isbanaux = IBAN.substr(4) + String(num1) + String(num2) + IBAN.substr(2, 2);
        resto = mod(isbanaux, 97);
        return (resto == 1);
    }
}

