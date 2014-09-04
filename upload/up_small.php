<script>
$(document).ready(function()
{   
    //mini
    var settings = {
        url: '../upload/upload.php',
        dragDrop: true,
        fileName: 'product_foto_mini',
        allowedTypes: 'jpg,png,gif,jpeg',	
        returnType: 'html',//orginal 'json' ale jakis bład zaczeło pokazywac po dodaniu resize 
        uploadFolder: '../data/<?php echo $id; ?>/mini/',
        formData: {folder: '../data/<?php echo $id; ?>/mini/'},//dodalem       
        showPreview: true,
        //showDownload: true,
        showDone: false,
        //showProgress: true,
        //showQueueDiv: "output",
        previewWidth: "10em",
        previewHeight: "auto",
        //showStatusAfterSuccess: false,
        uploadButtonClass:"ajax-file-upload",//do zmiany guzika
        onLoad:function(obj)
        {
            $.ajax({
                cache: false,
                type: "POST",
                url: "../upload/load.php",
                dataType: "json",
                data: { folder: settings.uploadFolder },
                success: function(data) 
                {
                    for(var i=0;i<data.length;i++)
                    {
                        obj.createProgress(data[i]);
                    }
                }
            });
        },
        // afterUploadAll:function(obj)
        // {
             // $.ajax({
                // cache: false,
                // type: "POST",
                // url: "load.php",
                // dataType: "json",
                // data: { folder: settings.uploadFolder },
                // success: function(data) 
                // {
                    // for(var i=0;i<data.length;i++)
                    // {
                        // obj.createProgress(data[i]);
                    // }
                // }
            // });
        // },
        onSuccess:function(files,data,xhr)
        {
           //alert(settings.uploadFolder);
           //$(".ajax-file-upload-fileshow").append("<img class='ajax-file-upload-img' src='uploads/1/mini/"+files+"' />");
        },
        showDelete:true,
        deleteCallback: function(data,pd)
        {
            for(var i=0;i<data.length;i++)
            {
                $.post("../upload/delete.php",{op:"delete",name:data[i],folder:settings.uploadFolder},
                function(resp, textStatus, jqXHR)
                {
                    //Show Message  
                    //$("#status").append("<div>File Deleted</div>");
                    //<div id="status"></div>
                });
            }      
            pd.statusbar.not(); //You choice to hide/not.
        },
        downloadCallback:function(files,pd)
        {
            location.href="../upload/download.php?filename="+files[0]+"&folder="+settings.uploadFolder;
        }
    }
    var uploadObj = $("#mulitplefileuploader_small").uploadFile(settings);
});
</script>
<div id="mulitplefileuploader_small">Upload</div>