<script>
$(document).ready(function()
{
    //large
    var settings = {
        url: '../upload/upload.php',
        dragDrop: true,
        fileName: 'product_foto_large',
        allowedTypes: 'jpg,png,gif,jpeg',	
        returnType: 'html',//orginal 'json' ale jakis bład zaczeło pokazywac po dodaniu resize 
        uploadFolder: '../data/<?php echo $id; ?>/',
        formData: {folder: '../data/<?php echo $id; ?>/'},//dodalem       
        showPreview: true,
        //showDownload: true,
        showDone: false,
        showProgress: false,
        //showQueueDiv: "output",
        previewWidth: "10em",
        previewHeight: "auto",
        showError: false,
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
        afterUploadAll:function(obj)
        {
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
            
        },
        onSuccess:function(files,data,xhr)
        {
           //alert((data));
           //$(".ajax-file-upload-fileshow").html("<img class='ajax-file-upload-img' src='uploads/1/"+files+"' />");
           //showProgress: false;
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
                    //$("#status2").append("<div>File Deleted</div>");
                    //<div id="status2"></div>
                });
            }      
            pd.statusbar.hide(); //You choice to hide/not.
        },
        downloadCallback:function(files,pd)
        {
            location.href="../upload/download.php?filename="+files[0]+"&folder="+settings.uploadFolder;
        }
    }
    var uploadObj = $("#mulitplefileuploader_large").uploadFile(settings);
    
    
});
</script>
<div id="mulitplefileuploader_large">Upload</div>