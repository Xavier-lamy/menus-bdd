<?php
//Connection
require_once dirname(__DIR__)."/inc/_connect.php";

//preparing query
$query = $db->prepare($sql);

//executing query
$query->execute();

//store results in array
$results = $query->fetchAll();

require_once "./inc/_disconnect.php";