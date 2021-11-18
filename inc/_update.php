<?php 
    //Create session
    session_start();

    if(isset($_POST) && !empty($_POST)) {
        //Check if we are comming from safety-stocks modification form:
        if(isset($_POST['alert_stock']) && !empty($_POST['alert_stock'])
        && isset($_POST['commands_id']) && !empty($_POST['commands_id'])){
            echo "You are going to modify commands";
            $commands_id = (int) strip_tags($_POST['commands_id']);
            $alert_stock = (int) strip_tags($_POST['alert_stock']);

            //Check if values are the type we want:
            if($alert_stock >= 0 && $alert_stock <= 100000){
                //Connection to db
                require_once dirname(__DIR__)."/inc/_connect.php";

                //Update new value for alert_stock
                $sql = "UPDATE `commands` SET `alert_stock` = :alert_stock WHERE `commands_id` = :commands_id";
                $update_query = $db->prepare($sql);

                $update_query->bindValue(':commands_id', $commands_id, PDO::PARAM_INT);
                $update_query->bindValue(':alert_stock', $alert_stock, PDO::PARAM_INT);
                
                $update_query->execute();

                //Change must_buy to true (1) if quantity <= to alert stocks
                $sql = "SELECT `quantity` FROM `commands` WHERE `commands_id` = :commands_id";
                $select_query = $db->prepare($sql);

                $select_query->bindValue(':commands_id', $commands_id, PDO::PARAM_INT);

                $select_query->execute();

                $select_query_result = $select_query->fetch();
                $quantity = $select_query_result['quantity'];

                if($quantity <= $alert_stock){
                    //Update must_buy to true
                    $sql = "UPDATE `commands` SET `must_buy` = 1 WHERE `commands_id` = :commands_id";
                    $update_query = $db->prepare($sql);
    
                    $update_query->bindValue(':commands_id', $commands_id, PDO::PARAM_INT);
                    
                    $update_query->execute();
                }
                else {
                    //update must_buy to false
                    $sql = "UPDATE `commands` SET `must_buy` = 0 WHERE `commands_id` = :commands_id";
                    $update_query = $db->prepare($sql);
    
                    $update_query->bindValue(':commands_id', $commands_id, PDO::PARAM_INT);
                    
                    $update_query->execute();
                }

                //End connection to db   
                require_once dirname(__DIR__)."/inc/_disconnect.php";
                $_SESSION['success'] = 'Safety stock value successfully updated';
                header('Location: ../safety-stocks.php');
                echo "Entry have been succesfully updated";                
            }
            else {
                //Redirection
                $_SESSION['error'] = 'Value must be a positive integer between 0 and 100 000';
                header('Location: ../safety-stocks.php?id='.$commands_id);
            }



        }
        //Or if we are coming from stocks modification form:
        elseif(isset($_POST['useby_date']) && !empty($_POST['useby_date'])
            && isset($_POST['stocks_id']) && !empty($_POST['stocks_id'])){
                echo "You are going to modify stocks";
        }
        else {
            //Redirection
            header('Location: ../stocks.php');
        }
    }
    else {
        //Redirection
        header('Location: ../stocks.php');
    }