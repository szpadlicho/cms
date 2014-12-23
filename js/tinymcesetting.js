$(function(){
     //tinymce.PluginManager.load('improvedcode', '../js/tinymce/plugins/improvedcode/plugin.min.js');
     //tinymce.PluginManager.load('moxiemanager', '/js/moxiemanager/plugin.min.js');
     tinymce.init({
        selector: "textarea#pr-des-large",
        theme: "modern",
        language : 'pl',
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern improvedcode"
        ],
        toolbar1: "newdocument print fullscreen improvedcode code | undo redo | cut copy paste | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote | subscript superscript | table | searchreplace",
        toolbar2: "link unlink anchor image media  | insertdatetime preview | hr removeformat | charmap emoticons | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft | styleselect | formatselect | fontselect | fontsizeselect",
        //menubar: false,
        toolbar_items_size: 'small',
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: '<b>Test 1</b>'},
            {title: 'Test template 2', content: '<em>Test 2</em>'}
        ],
        autosave_ask_before_unload: true,
        improvedcode_options : {
            height: 580
            ,indentUnit: 4
            ,tabSize: 4
            ,lineNumbers: true
            ,autoIndent: true
            ,theme: 'monokai'
        },
        save_enablewhendirty: true,
        save_onsavecallback: function() {
            console.log("TinyMCE Save");
            $('form input[name=update]').click();
            //$('form input[name=save]').click();
            //$('#saveupdate').submit();
        }
    });
});