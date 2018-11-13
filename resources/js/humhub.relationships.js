humhub.module('relationships', function(module, require, $) {

    var init = function() {
        console.log('relationships module activated');
    };

    var hello = function() {
        alert(module.text('hello')+' - '+module.config.username);
    };

    module.export({
        //uncomment the following line in order to call the init() function also for each pjax call
        //initOnPjaxLoad: true,
        init: init,
        hello: hello
    });



});

function CreateRelationshipModal(element)
{

}

function GetRelationshipTypes($element){
    "use strict";
    var url = $element.getAttribute('url');
    var cat = $element.value;

    $.ajax({
        url:  $element.getAttribute('url'),
        data: {category: cat},
        success: function (data) {
            $('#relationship-relationship_type').html(data);
        }
    });
}