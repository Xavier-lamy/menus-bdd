<?php 
    //Create session
    session_start();

    if(isset($_POST) && !empty($_POST)) {
        //Check if we are comming from safety-stocks modification form:
        if(isset($_POST['alert_stock']) && !empty($_POST['alert_stock'])
        && isset($_POST['commands_id']) && !empty($_POST['commands_id'])){
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
            }
            else {
                //Redirection
                $_SESSION['error'] = 'Value must be a positive integer between 0 and 100 000';
                header('Location: ../safety-stocks.php?id='.$commands_id);
            }
        }
        //Or if we are coming from stocks modification form:
        elseif(isset($_POST['useby_date']) && !empty($_POST['useby_date'])
            && isset($_POST['stocks_id']) && !empty($_POST['stocks_id'])
            && isset($_POST['ingredient']) && !empty($_POST['ingredient'])
            && isset($_POST['quantity']) && (!empty($_POST['quantity'])||$_POST['quantity']==0)
            && isset($_POST['quantity_name']) && !empty($_POST['quantity_name'])){
            
            $useby_date = strip_tags($_POST['useby_date']);
            $stocks_id = (int) strip_tags($_POST['stocks_id']);
            $ingredient = strip_tags($_POST['ingredient']);
            $quantity = (int) strip_tags($_POST['quantity']);
            $quantity_name = strip_tags($_POST['quantity_name']);

            //Check if quantity is the type we want:
            if($quantity >= 0 && $quantity <= 100000){
                //Connection to db
                require_once dirname(__DIR__)."/inc/_connect.php";

                //Update new value for useby_date and quantity in stocks:
                $sql = "UPDATE `stocks` SET `quantity` = :quantity, `useby_date` = :useby_date WHERE `stocks_id` = :stocks_id";
                $update_query = $db->prepare($sql);

                $update_query->bindValue(':stocks_id', $stocks_id, PDO::PARAM_INT);
                $update_query->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                $update_query->bindValue(':useby_date', $useby_date);
                
                $update_query->execute();

                //Calculate total quantity of all products with $ingredient as name, in stocks (in stocks this is indeed not a unique value)
                $sql = "SELECT SUM(`quantity`) FROM `stocks` WHERE `ingredient` = :ingredient";
                $query = $db->prepare($sql);

                $query->bindValue(':ingredient', $ingredient);

                $query->execute();

                $quantity_sum = $query->fetch();

                $total_quantity = $quantity_sum["SUM(`quantity`)"];

                /*Check if ingredient already exist in commands (in case it has been deleted by mistake), 
                if yes add quantity to commands ingredient quantity and update must buy if necessary, 
                if not add new ingredient (ingredient name, quantity, stock-alert (= half of quantity) must buy: false(0)*/
                $sql = "SELECT * FROM `commands` WHERE `ingredient` = :ingredient";
                $query = $db->prepare($sql);

                $query->bindValue(':ingredient', $ingredient);

                $query->execute();

                $ingredient_exist_in_commands = $query->fetch();

                if($ingredient_exist_in_commands){
                    //Update quantity
                    $sql = "UPDATE `commands` SET `quantity` = :quantity WHERE `ingredient` = :ingredient";
                    $update_query = $db->prepare($sql);
    
                    $update_query->bindValue(':ingredient', $ingredient);
                    $update_query->bindValue(':quantity', $total_quantity, PDO::PARAM_INT);
    
                    $update_query->execute();

                    //check if must_buy is true or false:
                    $sql = "SELECT * FROM `commands` WHERE `ingredient` = :ingredient";
                    $query = $db->prepare($sql);
    
                    $query->bindValue(':ingredient', $ingredient);
    
                    $query->execute();
    
                    $commands_product = $query->fetch();
                    $commands_id = $commands_product['commands_id'];
                    if($commands_product['quantity'] <= $commands_product['alert_stock']){
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
                    //End connection to db and redirect   
                    require_once dirname(__DIR__)."/inc/_disconnect.php";
                    $_SESSION['success'] = 'Quantity and date successfully updated';
                    header('Location: ../stocks.php');    

                }else {
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
            }
            else {
                //Redirection
                $_SESSION['error'] = 'Quantity must be a positive integer between 0 and 100 000';
                header('Location: ../stocks.php?id='.$stocks_id);
            }
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