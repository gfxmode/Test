<?php
    require_once('../../config/IniHandler.php');
    global $objIni;
    $objIni = new ini_File('../../config/config.ini');
    $objIni->read();

    $objIniArtIdxItem = $objIni->getItem("Art", "maxArtId");
    $idxLastArt = $objIniArtIdxItem->getContent();
    // 保存文章正文
    $fileArt = fopen("../articles/art_".$idxLastArt.".html", "w") or die("Unable to open file!");
    fwrite($fileArt, $_POST["ckeditor"]);
    fclose($fileArt);

    // 文章配置索引信息更新
    $objIniArtIdxItem->setContent($idxLastArt + 1);
    // 文章整体配置信息更新
    $format = "%s".INI_ART_ITEM_SPLIT_SYMBOL."%s".INI_ART_ITEM_SPLIT_SYMBOL."%s".INI_ART_ITEM_SPLIT_SYMBOL."%s";
    $artItemValue = sprintf($format, $_POST["column"], $_POST["title"], $_POST["description"], $_POST["keywords"]);
    $objIniSecArt = $objIni->getSection("Art");
    $objIniSecArt->addItem("Item".$idxLastArt, $artItemValue);
    $objIni->write();

    // include "./include/displayArticleList.html";
    echo "文章新增成功，请刷新页面";
?>