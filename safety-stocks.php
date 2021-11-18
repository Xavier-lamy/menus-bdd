<?php 
    //Create session
    session_start();

    //Connection to db
    require_once "./inc/_connect.php";

    //Read all data from commands
    $sql = "SELECT * FROM `commands`";
    require_once "./inc/_read.php";

    //End connection to db   
    require_once "./inc/_disconnect.php";

    if( isset($_GET['id']) && !empty($_GET['id']) ){

        //Cleaning the id
        $id = strip_tags($_GET['id']);

        //Check if $id is in one of the result of the query results
        $is_selected_product = function($results, $id) {
            foreach ($results as $result) {
                if ($result['commands_id']==$id) {
                    return true;
                } else {
                    return false;
                }
            }
        };
        
        //Define the product ID
        if($is_selected_product) {
            $selected_product_id = $id;
        }else {
            $selected_product_id = "";
            //Redirect if no ID is set
            header('Location: safety-stocks.php');
        }
    }
    else {
        $selected_product_id = "";
    }
?>
<?php include 'header.php' ;?>
    <div class="wrapper">
        <main class="element--center w--60 _mob_w--100">
            <h1 class="text--center">Safety stocks</h1>
            <a href="stocks.php" class="button m--3">Return to stocks</a>

            <?php if(isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
                <div class="alert--error my--2 p--2">
                    <?php 
                        echo $_SESSION['error']; 
                        $_SESSION['error'] = '';
                    ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($selected_product_id) && !empty($selected_product_id)): ?>
                <form method="POST" action="modify.php" id="modify_product_form"></form>
            <?php endif; ?>
            <table class="element--center table--striped w--100">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--25">Ingredient</th>
                    <th class="w--25">Total</th>
                    <th class="w--25">Safety stock</th>
                    <th class="w--25">Modifications</th>
                </thead>
                <tbody>
                    <?php foreach ($results as $product): ?>
                        <?php if($product['commands_id']== $selected_product_id): ?>
                            <tr>
                                <td class="text--center p--1"><? echo $product['ingredient']; ?></td>
                                <td class="text--center p--1"><? echo $product['quantity']. ' ' . $product['quantity_name']; ?></td>
                                <td class="text--center p--1 dsp--flex align--center">
                                    <input type="number" min="0" name="alert_stock" form="modify_product_form" class="text--center w--50" value="<? echo $product['alert_stock']; ?>" required>
                                    <span class="w--50"><?php echo ' ' . $product['quantity_name']; ?></span>
                                </td>
                                <td class="text--center p--1">
                                    <input type="hidden" name="commands_id" form="modify_product_form" value="<?php echo $product['commands_id'] ?>" required>
                                    <button type="submit" form="modify_product_form" class="button--sm">Apply</button>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td class="text--center p--1"><? echo $product['ingredient']; ?></td>
                                <td class="text--center p--1"><? echo $product['quantity']. ' ' . $product['quantity_name']; ?></td>
                                <td class="text--center p--1"><? echo $product['alert_stock']. ' ' . $product['quantity_name']; ?></td>
                                <td class="text--center p--1"><a href="safety-stocks.php?id=<?php echo $product['commands_id'] ?>" class="button--sm">Modify</a></td>
                            </tr>
                        <?php endif; ?>                        
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
<?php include 'footer.php' ;?>