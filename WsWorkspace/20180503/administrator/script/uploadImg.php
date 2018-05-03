<?php
    $extensions = array("jpg","bmp","gif","png");
    $uploadFilename = $_FILES['upload']['name'];
    $uploadFilesize = $_FILES['upload']['size'];
    if($uploadFilesize  > 1024*2*1000){
         echo "<font color=\"red\"size=\"2\">*图片大小不能超过2M</font>";
         exit;
    }

    $extension = pathInfo($uploadFilename, PATHINFO_EXTENSION);
    if(in_array($extension,$extensions)){
        $uploadPath ="../../uploadfile/";
        $uuid = str_replace('.','',uniqid("",TRUE)).".".$extension;
        $desname = $uploadPath.$uuid;
        $previewname = '../../uploadfile/'.$uuid;
        $tag = move_uploaded_file($_FILES['upload']['tmp_name'],$desname);
        $callback = $_REQUEST["CKEditorFuncNum"];
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callback,'".$previewname."','');</script>";
    }else{
        echo "<font color=\"red\"size=\"2\">*文件格式不正确（必须为.jpg/.gif/.bmp/.png文件）</font>";
    }
?>