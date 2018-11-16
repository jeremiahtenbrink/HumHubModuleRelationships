humhub.module('relationships', function(module, require, $) {

    var init = function() {
        console.log('relationships module activated');
    };

    var hello = function() {
        alert(module.text('hello')+' - '+module.config.username);
    };

    var getRelationshipTypes = function($element){
        console.log("Getting Relationship Types");
        var url = $element.getAttribute('url');
        var cat = $element.value;

        $.ajax({
            url:  $element.getAttribute('url'),
            data: {category: cat},
            success: function (data) {
                console.log("Successfully Collected Relationship Types");
                $('#relationship-relationship_type').html(data);
            }
        });
    }

    var settingsChanged = function ($formField){
        var url = $formField.getAttribute('data-url');
        var dataTarget = $formField.name;
        var value = 0;
        if ($formField.checked){
            value = 1;
        }

        $.ajax({
            url: url,
            data: {dataTarget: dataTarget, value: value},
            success: function (data){
                console.log("Settings Saved");
                $('#data.dataTarget').val(data.value);
            }
            });
    }

    module.export({
        //uncomment the following line in order to call the init() function also for each pjax call
        //initOnPjaxLoad: true,
        init: init,
        hello: hello,
        getRelationshipTypes: getRelationshipTypes,
        settingsChanged: settingsChanged,
    });

});