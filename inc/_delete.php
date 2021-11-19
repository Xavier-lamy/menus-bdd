<?php 
    //Create session
    session_start();

    if (isset($_POST) && !empty($_POST)) {
        //Connection to db
        require_once dirname(__DIR__)."/inc/_connect.php";

        //Inititalize $nb_deleted:
        $nb_deleted = 0;
        foreach ($_POST as $id) {
            strip_tags($id);

            $sql = "SELECT `ingredient`, `quantity` FROM `stocks` WHERE `stocks_id` = :stocks_id";

            $query = $db->prepare($sql);

            $query->bindValue(':stocks_id', $id, PDO::PARAM_INT);

            $query->execute();

            $stocks_product = $query->fetch();
            $stocks_ingredient = $stocks_product['ingredient'];
            $stocks_quantity = (int) $stocks_product['quantity'];

            //Check if ingredient name exist in commands and select it
            $sql = "SELECT * FROM `commands` WHERE `ingredient` = :ingredient";

            $query = $db->prepare($sql);

            $query->bindValue(':ingredient', $stocks_ingredient);

            $query->execute();

            $commands_product = $query->fetch();
            $commands_quantity = (int) $commands_product['quantity'];

            // Calculate total quantity
            $total_quantity = $commands_quantity - $stocks_quantity;

            //if total quantity = 0 remove the entry from commands
            if($total_quantity == 0) {
                $sql = "DELETE FROM `commands` WHERE `ingredient` = :ingredient";

                $query = $db->prepare($sql);
    
                $query->bindValue(':ingredient', $stocks_ingredient);
    
                $query->execute();
            }
            else {
                //update 
                $sql = "UPDATE `commands` SET `quantity` = $total_quantity  WHERE `ingredient` = :ingredient";

                $query = $db->prepare($sql);

                $query->bindValue(':ingredient', $stocks_ingredient);

                $query->execute();

                //check for must_buy
                if($total_quantity <= $commands_product['alert_stock']){
                    //Update must_buy to true
                    $sql = "UPDATE `commands` SET `must_buy` = 1 WHERE `ingredient` = :ingredient";

                    $query = $db->prepare($sql);
    
                    $query->bindValue(':ingredient', $stocks_ingredient);
    
                    $query->execute();

                }
                else {
                    //update must_buy to false
                    $sql = "UPDATE `commands` SET `must_buy` = 0 WHERE `ingredient` = :ingredient";

                    $query = $db->prepare($sql);
    
                    $query->bindValue(':ingredient', $stocks_ingredient);
    
                    $query->execute();

                }
            }

            // When commands have been updated delete ingredient from stocks
            $sql = "DELETE FROM `stocks` WHERE `stocks_id` = :stocks_id";

            $query = $db->prepare($sql);

            $query->bindValue(':stocks_id', $id, PDO::PARAM_INT);

            $query->execute();

            $nb_deleted += 1;
        }
        //End connection to db   
        require_once dirname(__DIR__)."/inc/_disconnect.php";

        //Redirection
        if($nb_deleted == 1){
            $_SESSION['success'] = "Deletion completed, {$nb_deleted} entry deleted!";
        }else {
            $_SESSION['success'] = "Deletion completed, {$nb_deleted} entries deleted!";
        }
        header('Location: ../stocks.php');
        exit();

    }
    else {
        //Redirection
        $_SESSION['error'] = "There is an error with the deletion, please try again";
        header('Location: ../stocks.php');
        exit();
    }
