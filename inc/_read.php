<?php
//Connection
require_once dirname(__DIR__)."/inc/_connect.php";

//preparing query
$query = $db->prepare($sql);

//executing query
$query->execute();

//store result in array
$result = $query->fetchAll();

require_once dirname(__DIR__)."/inc/_disconnect.php";