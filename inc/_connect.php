<?php

// Database connection

    //Include db connection infos from _config.php
    require_once dirname(__DIR__)."/inc/_config.php";
    //Try connection:
    try{
        $db = new PDO(DSN, DBUSER , DBPASS);

        //Define PDO error mode
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Define default fetch() mode on fetch_assoc
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    }

    //If it fail: return error message and stop php
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
