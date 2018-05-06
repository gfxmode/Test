<?php
    require_once('../../config/IniHandler.php');

    global $objIni;
    $objIni = new ini_File("../../config/config.ini");
    $objIni->read();

    include "./include/displayArticleList.html";
?>