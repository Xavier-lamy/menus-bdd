<?php

//preparing query
$query = $db->prepare($sql);

//executing query
$query->execute();

//store results in array
$results = $query->fetchAll();
