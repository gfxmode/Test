<?php
    require_once('./config/IniHandler.php');
    $objIni = new IniHandler('./config/config.ini');
    function getGlobalKey($in_key) {
        global $objIni;
        echo ($objIni->getGlobalKey($in_key));
    }

    $objIniFile = new Ini_File('./config/config.ini');
    function getNewestArtNum($colName, $maxNum) {
        global $objIniFile;
        $objIniFile->read();
        $numArt = $objIniFile->getItemValue("Art", "maxArtId");
        $ret = "";
        $cnt = 0;
        $retTmplate = '<div class="col-md-3 bann-works">
                            <a href="%s" target="_blank">
                                <div class="ban-setting">
                                    <img src="%s" alt="%s" class="img-responsive">
                                    <div class="captn">
                                        <h4>%s</h4>
                                    </div>
                                </div>
                                <h6>%s</h6>
                            </a>
                        </div>';
        for ($i = 0; $i < $numArt; ++$i) {
            $arrValue = explode(INI_ART_ITEM_SPLIT_SYMBOL, $objIniFile->getItemValue("Art", "Item".($numArt - $i - 1)));
            $valueCol = $arrValue[0];
            $valueTitle = $arrValue[1];
            $valueImg = str_replace('../../', '', $arrValue[5]);
            if ($valueCol != $colName) {
                continue;
            }
            $tmpStr = sprintf($retTmplate, $valueTitle, $valueImg, $valueTitle, $valueTitle, $valueTitle);
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
    <link href="./theme/default/css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <script src="./theme/default/js/jquery-1.11.0.min.js"></script>
    <link href="./theme/default/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="<?php getGlobalKey("cfg_webname") ?>" />
    <meta name="description" content="<?php getGlobalKey("cfg_description") ?>" />
    <meta name="author" content="order by adminbuy.cn" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <script src="./theme/default/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./theme/default/css/flexslider.css" type="text/css" media="screen" />
    <script src="./theme/default/js/responsiveslides.min.js"></script>
    <script>
        $(function () {
            $("#slider2").responsiveSlides({
                auto: true,
                pager: true,
                speed: 300,
                namespace: "callbacks",
            });
        });
    </script>
</head>

<body>
    <link href="./theme/default/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="./theme/default/js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>

    <?php include "./include/head.htm" ?>
    <div class="banner">
        <div class="banner-main">
            <section class="slider">
                <div class="flexslider">
                    <ul class="slides">
                        <li>
                            <div class="banner-bottom">
                                <div class="container">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="banner-bottom1">
                                <div class="container">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="banner-bottom2">
                                <div class="container">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"> </div>
            </section>
        </div>
    </div>

    <script defer src="./theme/default/js/jquery.flexslider.js"></script>
    <script type="text/javascript">
        $(function () {
        });
        $(window).load(function () {
            $('.flexslider').flexslider({
                animation: "slide",
                start: function (slider) {
                    $('body').removeClass('loading');
                }
            });
        });
    </script>

    <div class="beauty-grid">
        <div class="container">
            <div class="fitness-bottom">
                <div class="col-md-6 fitness-rit zoomIn">
                    <h1>轿车托运服务</h1>
                    <p>恒运达专业承接深圳、东莞、惠州、广州珠三角等地到全国的商品车、私家车、二手车托运业务。选择恒运达，就是选择了安全。 恒运达使用封闭笼车运输，而不是车货混装，笼车运输能保证汽车在运输过程中不被刮花、挤压变形。车辆运输过程中，为确保车辆不受事故影响，恒运达为轿车免费投保10W的保险，保证车辆运输安全...
                    </p>
                    <a href="/jcty/" class="hvr-underline-from-left">更多</a>
                </div>
                <div class="col-md-6 fitness-lft zoomIn">
                    <img src="./theme/default/images/h1.jpg" alt="" class="img-responsive"> </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>

    <div class="bann-grid">
        <div class="container">
            <div class="bann-grid-main"><?php echo getNewestArtNum("jcty", 4)?><div class="clearfix"> </div>
            </div>
        </div>
    </div>

    <div class="beauty-grid">
        <div class="container">
            <div class="fitness-bottom">
                <div class="col-md-6 fitness-rit zoomIn">
                    <h1>物流运输服务</h1>
                    <p>恒运达提供物流运输服务，承接深圳、东莞、广州、惠州及珠三角地区到全国各地货物运输及物流业务，整车零单均可。专业调派各种平板、高栏、厢式车型、4米、5米、6.2米、6.8米、7.2米、9.6米、13米、17.5米半挂车、5吨、10吨、17吨、25吨、38吨50吨……等货车数百辆，同时可根据客户需求，实行门到门服务。恒运达秉承“安全、准时、快捷、经济”的服务理念，用心为客户创造价值...
                    </p>
                    <a href="/about/" class="hvr-underline-from-left">更多</a>
                </div>
                <div class="col-md-6 fitness-lft zoomIn">
                    <img src="./theme/default/images/h2.jpg" alt="" class="img-responsive"> </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>

    <div class="bann-grid">
        <div class="container">
            <div class="bann-grid-main"> {dede:arclist typeid='3' row='4' orderby='pubdate' type='image' titlelen='22' }
                <div class="col-md-3 bann-works">
                    <a href="[field:arcurl/]" target="_blank">
                        <div class="ban-setting">
                            <img src="[field:picname/]" alt="[fullfield:title/]" class="img-responsive">
                            <div class="captn">
                                <h4>[field:title/]</h4>
                            </div>
                        </div>
                        <h6>[field:title/]</h6>
                    </a>
                </div>
                {/dede:arclist}
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <!--bann beloew end here-->

    <?php include "./include/footer.htm" ?>
</body>

</html>