require([
    'jquery',
    'mage/adminhtml/wysiwyg/tiny_mce/setup'
], function(jQuery){

    var config = {},
        editor;

    jQuery.extend(config, {
        settings: {
            theme_advanced_buttons1 : 'bold,italic,|,justifyleft,justifycenter,justifyright,|,' +
                'fontselect,fontsizeselect,|,forecolor,backcolor,|,link,unlink,image,|,bullist,numlist,|,code',
            theme_advanced_buttons2: null,
            theme_advanced_buttons3: null,
            theme_advanced_buttons4: null
        }
    });
    editor = new tinyMceWysiwygSetup(
        'description',
        config
    );
    editor.turnOn();
    jQuery('#description')
        .addClass('wysiwyg-editor')
        .data(
            'wysiwygEditor',
            editor
        );
});