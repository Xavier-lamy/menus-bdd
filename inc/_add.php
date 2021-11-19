<?php
    //Create session
    session_start();

if(isset($_POST['ingredient']) && !empty($_POST['ingredient'])
&& isset($_POST['quantity']) && (!empty($_POST['quantity'])||$_POST['quantity']==0)
&& isset($_POST['quantity_name']) && !empty($_POST['quantity_name'])
&& isset($_POST['useby_date']) && !empty($_POST['useby_date'])){
    
    $ingredient = strip_tags($_POST['ingredient']);
    $quantity = (int) strip_tags($_POST['quantity']);
    $quantity_name = strip_tags($_POST['quantity_name']);
    $useby_date = strip_tags($_POST['useby_date']);

    require_once dirname(__DIR__)."/inc/_connect.php";
    //add to stocks
    $sql = "INSERT INTO `stocks` (`ingredient`, `quantity`, `quantity_name`, `useby_date`)
    VALUES (:ingredient, :quantity, :quantity_name, :useby_date)";
    
    $insert_query = $db->prepare($sql);

    $insert_query->bindValue(':ingredient', $ingredient);
    $insert_query->bindValue(':quantity', $quantity, PDO::PARAM_INT);
    $insert_query->bindValue(':quantity_name', $quantity_name);
    $insert_query->bindValue(':useby_date', $useby_date);
    
    $insert_query->execute();


    // check if ingredient exists in commands
    $sql = "SELECT * FROM `commands` WHERE `ingredient` = :ingredient";
    $query = $db->prepare($sql);

    $query->bindValue(':ingredient', $ingredient);

    $query->execute();

    $ingredient_exist_in_commands = $query->fetch();

    //if yes add quantity to total quantity and check if must_buy
    if ($ingredient_exist_in_commands) {
        //Set total quantity for this ingredient
        $total_quantity = $quantity + $ingredient_exist_in_commands['quantity'];

        //Update quantity
        $sql = "UPDATE `commands` SET `quantity` = :quantity WHERE `ingredient` = :ingredient";
        $update_query = $db->prepare($sql);

        $update_query->bindValue(':ingredient', $ingredient);
        $update_query->bindValue(':quantity', $total_quantity, PDO::PARAM_INT);

        $update_query->execute();

        //check if must_buy should be true or false, read new quantity:
        $sql = "SELECT * FROM `commands` WHERE `ingredient` = :ingredient";
        $query = $db->prepare($sql);

        $query->bindValue(':ingredient', $ingredient);

        $query->execute();

        $commands_product = $query->fetch();
        $commands_id = $commands_product['commands_id'];
        if ($commands_product['quantity'] <= $commands_product['alert_stock']) {
            //Update must_buy to true
            $sql = "UPDATE `commands` SET `must_buy` = 1 WHERE `commands_id` = :commands_id";
            $update_query = $db->prepare($sql);

            $update_query->bindValue(':commands_id', $commands_id, PDO::PARAM_INT);
            
            $update_query->execute();
        } else {
            //update must_buy to false
            $sql = "UPDATE `commands` SET `must_buy` = 0 WHERE `commands_id` = :commands_id";
            $update_query = $db->prepare($sql);

            $update_query->bindValue(':commands_id', $commands_id, PDO::PARAM_INT);
            
            $update_query->execute();
        }
        //End connection to db and redirect   
        require_once dirname(__DIR__)."/inc/_disconnect.php";
        $_SESSION['success'] = 'New ingredient added to stock';
        header('Location: ../stocks.php');
    }
    else {
        //if doesn't exist in commands add it (for stock_alert add quantity for now, and so must buy should be true (1), customer can change it later)
        $sql = "INSERT INTO `commands` (`ingredient`, `quantity`, `quantity_name`, `alert_stock`, `must_buy`)
        VALUES (:ingredient, :quantity, :quantity_name, :alert_stock, :must_buy)";
        
        $insert_query = $db->prepare($sql);

        $insert_query->bindValue(':ingredient', $ingredient);
        $insert_query->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $insert_query->bindValue(':quantity_name', $quantity_name);
        $insert_query->bindValue(':alert_stock', $quantity, PDO::PARAM_INT);
        $insert_query->bindValue(':must_buy', 1, PDO::PARAM_INT);
        
        $insert_query->execute();

        //End connection to db and redirect   
        require_once dirname(__DIR__)."/inc/_disconnect.php";
        $_SESSION['success'] = 'New ingredient added to stock, you can go to safety stocks to change safety amount';
        header('Location: ../stocks.php');
    }
    $_GET['param'] ='';
}
else {
    //Redirection
    header('Location: ../stocks.php');
}
