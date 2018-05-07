<?php
    require_once('../../config/IniHandler.php');
    global $objIni;
    $objIni = new ini_File('../../config/config.ini');
    $objIni->read();

    $idxArt = $_GET["item"];
    if (is_numeric($idxArt)) {
        $idxLastArt = $idxArt;
    }
    else {
        $objIniArtIdxItem = $objIni->getItem("Art", "maxArtId");
        $idxLastArt = $objIniArtIdxItem->getContent();
        // 文章配置索引信息更新
        $objIniArtIdxItem->setContent($idxLastArt + 1);
    }
    // 保存文章正文
    file_put_contents("../articles/art_".$idxLastArt.".html", $_POST["ckeditor"]);

    // 文章整体配置信息更新
    $format = "%s".INI_ART_ITEM_SPLIT_SYMBOL."%s".INI_ART_ITEM_SPLIT_SYMBOL."%s".INI_ART_ITEM_SPLIT_SYMBOL."%s";
    $artItemValue = sprintf($format, $_POST["column"], $_POST["title"], $_POST["description"], $_POST["keywords"]);
    $objIniSecArt = $objIni->getSection("Art");
    $objIniSecArt->addItem("Item".$idxLastArt, $artItemValue);
    $objIni->write();

    // include "./include/displayArticleList.html";
    echo "文章新增成功，请刷新页面";
?>