<?php
    require_once('../../config/IniHandler.php');

    $objIni = new IniHandler('../../config/config.ini');
    function getGlobalKey($in_key) {
        global $objIni;
        echo ($objIni->getGlobalKey($in_key));
    }

    $objIniFile = new Ini_File('../../config/config.ini');
    function getNewestFooterArtNum($maxNum) {
        global $objIniFile;
        $objIniFile->read();
        $numArt = $objIniFile->getItemValue("Art", "maxArtId");
        $ret = "";
        $cnt = 0;
        $retTmplate = '<div class="ftr-sub-gd">
                            <div class="col-md-8 ftr-gd1-text">
                            <h4><a href="single.html">%s</a></h4>
                            </div>
                            <div class="clearfix"> </div>
                        </div>';
        for ($i = 0; $i < $numArt; ++$i) {
            $arrValue = explode(INI_ART_ITEM_SPLIT_SYMBOL, $objIniFile->getItemValue("Art", "Item".($numArt - $i - 1)));
            $valueCol = $arrValue[0];
            $valueTitle = $arrValue[1];
            $valueImg = str_replace('../../', '', $arrValue[5]);
            $tmpStr = sprintf($retTmplate, $valueTitle, $valueImg, $valueTitle, $valueTitle, $valueTitle);
            $ret .= $tmpStr;
            $cnt++;
            if ($cnt >= $maxNum) {
                break;
            }
        }
        return $ret;
    }

    function generateArtListItem() {
        $retTpl = '<li>
                        <div class="blog-left">
                        <p><a href="detail.html" class="title">测试文章</a></p>
                        <p style="margin-top: 20px">内容显示内容显示内容显示内容显示内容显示内容显示内容显示内容显示内容显示内容显示内容显示内容显示内容显示内容显示内容显示内容显示内容显示内容显示</p>
                        <p style="margin-top: 80px"><img src="http://img.php.cn/upload/course/000/000/004/58170f99f2430105.png" >测试<img src="http://img.php.cn/upload/course/000/000/004/58170fbda3f34844.png" style="margin-left: 20px">2016/10/31</p>
                        </div>
                        <div class="blog-right"><img src="http://img.php.cn/upload/course/000/000/004/58170bc487acc779.jpg"></div>
                    </li>';
    }
?>

<!DOCTYPE HTML>
<html>

<head>
    <title><?php getGlobalKey("cfg_webname") ?></title>
    <link href="/theme/default/css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <script src="/theme/default/js/jquery-1.11.0.min.js"></script>
    <link href="/theme/default/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="<?php getGlobalKey("cfg_webname") ?>" />
    <meta name="description" content="<?php getGlobalKey("cfg_description") ?>" />
    <meta name="author" content="order by adminbuy.cn" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <script src="/theme/default/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/theme/default/css/flexslider.css" type="text/css" media="screen" />
    <script src="/theme/default/js/responsiveslides.min.js"></script>
</head>
<body>
    <?php include "../../include/head.htm" ?>
    <div id="blog">
        <ul>
            <?php echo generateArtListItem() ?>
        </ul>
    </div>
    <?php include "../../include/footer.htm" ?>
</body>
</html>