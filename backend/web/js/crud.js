$('#generator-modelclass').on('blur', function () {
        var modelClass = $(this).val() + 'Search';
        $('#generator-searchmodelclass').val(modelClass).blur();
    }
);
$('#generator-controllerclass').on('blur', function () {
        var controllerClass = $(this).val().replace(/\\/g, '/')
            .replace('backend/controllers', '').replace('Controller', '').toLowerCase();
        $('#generator-viewpath').val('@backend/views' + controllerClass).blur();
    }
);