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

    function getFileDigest($idx) {
        $file_contents = file_get_contents("../../administrator/articles/art_".$idx.".html");
        $file_text = strip_tags($file_contents);
        $ret = mb_substr($file_text, 0, 300, "utf-8")."...";

        return $ret;
    }

    function generateArtListItem() {
        $ret = "";
        $retTpl = '<li>
                        <div class="blog-left">
                            <p><a href="%s" class="title">%s</a></p>
                            <p style="margin-top: 20px">%s</p>
                        </div>
                        <div class="blog-right"><img src="%s"></div>
                    </li>';
        global $objIniFile;
        $objIniFile->read();
        $numArt = $objIniFile->getItemValue("Art", "maxArtId");
        for ($i = 0; $i < $numArt; ++$i) {
            $strArt = $objIniFile->getItemValue("Art", "Item".$i);
            if (strpos($strArt, "jcty") === 0) {
                $arrArt = explode(INI_ART_ITEM_SPLIT_SYMBOL, $strArt);
                $tmpStr = sprintf($retTpl, "jcty_".$i.".html", $arrArt[1], getFileDigest($i), $arrArt[5]);
                $ret .= $tmpStr;
            }
        }

        return $ret;
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
    <style>
        body{
            background-color: #F0F0F0;
        }
        #blog ul{
            list-style-type: none;
        }
        #blog ul li{
            background-color: white;
            padding: 20px;
            width: 100%;
            overflow: hidden;
            margin-top: 15px;
        }
        .blog-left{
            float: left;
            width: 800px;
            overflow: hidden;
        }
        .blog-right{
            float: left;
            margin-left: 10px;
            width: 280px;
            overflow: hidden;
        }
        .blog-right img{
            width: 280px;
            height: 200px;
        }
        .title{
            text-decoration:none;
            font-size: 26px;
        }
        .blog-left p{
            color: gray;
        }
        .blog-left img{
            width: 20px;
            margin-right: 10px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <?php include "../../include/head.htm" ?>
    <div id="blog">
        <ul>
            <?php echo generateArtListItem() ?>
        </ul>
    </div>
    <div style="margin-top: 20px"></div>
    <?php include "../../include/footer.htm" ?>
</body>
</html>