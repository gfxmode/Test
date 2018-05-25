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
                            <h4><a href="%s">%s</a></h4>
                            </div>
                            <div class="clearfix"> </div>
                        </div>';
        for ($i = 0; $i < $numArt; ++$i) {
            $arrValue = explode(INI_ART_ITEM_SPLIT_SYMBOL, $objIniFile->getItemValue("Art", "Item".($numArt - $i - 1)));
            $valueCol = $arrValue[0];
            $valueTitle = $arrValue[1];
            $valueImg = str_replace('../../', '', $arrValue[5]);
            $tmpStr = sprintf($retTmplate, "/a/".$valueCol."/index.php?idx=".$i, $valueTitle);
            $ret .= $tmpStr;
            $cnt++;
            if ($cnt >= $maxNum) {
                break;
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
</head>
<body>
    <?php include "../../include/head.htm" ?>
    <?php include "../../include/footer.htm" ?>
</body>
</html>