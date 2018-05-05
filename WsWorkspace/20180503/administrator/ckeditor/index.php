<?php
    require_once('../../config/IniHandler.php');
    $objIni = new IniHandler('../../config/config.ini');

    function getArtCol() {
        global $objIni;
        $arrCol = ($objIni->getArtCol());
        $format = '<option value="%s">%s</option>';

        $strResult = '';
        foreach ($arrCol as $key => $val) {
            $strResult .= sprintf($format, $key, $val);
        }

        echo $strResult;
    }
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="ckeditor.js"></script>
    <style>
        body, td, select{
            font-family: "Microsoft YaHei", Arial, Tahoma, SimSun;
            font-size: 12px;
            color: #1d1007;
            line-height: 24px
        }
    </style>
</head>

<body>
    <form id="detail" action="../script/saveArticle.php" method="post">
        <table cellspacing="10">
            <tr>
                <td colspan="3">
                    <label>标题:</label>
                    <input id="title" name="title" style="width: 500px" maxlength="40" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>栏目:</label>
                    <select name="column">
                        <?php echo getArtCol() ?>
                    </select>
                </td>
                <td>
                    <label>描述:</label>
                    <input id="description" name="description" style="width: 200px" maxlength="20" />
                </td>
                <td>
                    <label>关键词:</label>
                    <input id="keywords" name="keywords" style="width: 200px" maxlength="10" />
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <textarea name="ckeditor"></textarea>
                </td>
            </tr>
        </table>
        <input type="submit" value="保存">
    </form>
    <script>
        CKEDITOR.replace('ckeditor', {
            filebrowserUploadUrl: "../script/uploadImg.php?action=address&do=upload'", //设置图片上传请求地址
            height: 400,
            width: 900,
        });
    </script>
</body>
</html>