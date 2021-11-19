<?php 
    //Create session
    session_start();

    //Connection to db
    require_once "./inc/_connect.php";

    //Read all data from stocks
    $sql = "SELECT * FROM `stocks`";
    require_once "./inc/_read.php";

    //End connection to db   
    require_once "./inc/_disconnect.php";

    if( isset($_GET['id']) && !empty($_GET['id']) ){

        //Cleaning the id
        $id = strip_tags($_GET['id']);

        //Check if $id is in one of the result of the query results
        $is_selected_product = function($results, $id) {
            foreach ($results as $result) {
                if ($result['stocks_id']==$id) {
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
            header('Location: stocks.php');
        }
    }
    else {
        $selected_product_id = "";
    }
?>
<?php include 'header.php' ;?>
    <div class="wrapper">
        <main class="element--center w--60 _mob_w--100">
            <h1 class="text--center">Stocks</h1>
            <div class="dsp--flex justify--between">
                <a href="safety-stocks.php" class="button m--3">Safety stocks</a>
                <a href="stocks.php?param=add_item" class="button m--3">Add ingredient</a>
                <button type="submit" form="delete_product_form" class="button m--3">Delete selection</button>
            </div>

            <?php if(isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
                <div class="alert--message my--2 p--2">
                    <?php 
                        echo $_SESSION['error']; 
                        $_SESSION['error'] = '';
                    ?>
                </div>
            <?php elseif(isset($_SESSION['success']) && !empty($_SESSION['success'])): ?>
                <div class="alert--success my--2 p--2">
                    <?php 
                        echo $_SESSION['success']; 
                        $_SESSION['success'] = '';
                    ?>
                </div>
            <?php endif; ?>

            <!--Modifications forms-->
            <?php if(isset($selected_product_id) && !empty($selected_product_id)): ?>
                <form method="POST" action="./inc/_update.php" id="modify_product_form"></form>
            <?php endif; ?>
            <?php if( isset($_GET['param']) && $_GET['param'] == 'add_item' ): ?>
                <form method="POST" action="./inc/_add.php" id="add_product_form"></form>
            <?php endif; ?>
            <form method="POST" action="delete-confirmation.php" id="delete_product_form"></form>

            <table class="element--center table--striped w--100">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--25">Ingredient</th>
                    <th class="w--25">Quantity</th>
                    <th class="w--25">Use-by Date</th>
                    <th class="w--25">Modifications</th>
                </thead>
                <tbody>
                    <?php if( isset($_GET['param']) && $_GET['param'] == 'add_item' ): ?>
                        <tr>
                            <td class="text--center p--1">
                                <input type="text" aria-label="Ingredient" maxlength="40" minlength="1" name="ingredient" form="add_product_form" class="text--center" placeholder="Ingredient" required>
                            </td>
                            <td class="text--center p--1 dsp--flex align--center">
                                <input type="number" aria-label="Quantity" min="0" name="quantity" form="add_product_form" class="text--center w--50 h--100 my--2" placeholder="Quantity" required>
                                <input type="text" aria-label="Unit" maxlength="30" minlength="1" name="quantity_name" form="add_product_form" class="text--center w--50 h--100 my--2" placeholder="Unit" required>
                            </td>
                            <td class="text--center p--1">
                                <input type="date" min="2000-01-01" max="3000-01-01" aria-label="Useby date" name="useby_date" form="add_product_form" class="text--center" required>
                            </td>
                            <td class="text--center p--1">
                                <button type="submit" form="add_product_form" class="button--sm">Add new</button>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($results as $product): ?>
                        <?php if($product['stocks_id']== $selected_product_id): ?>
                            <tr>
                                <td class="text--center p--1"><? echo $product['ingredient']; ?></td>
                                <td class="text--center p--1 dsp--flex align--center">
                                    <input type="number" aria-label="Quantity" min="0" name="quantity" form="modify_product_form" class="text--center w--50" value="<? echo $product['quantity']; ?>" required>
                                    <span class="w--50"><?php echo ' ' . $product['quantity_name']; ?></span>
                                </td>
                                <td class="text--center p--1">
                                    <input type="date" min="2000-01-01" max="3000-01-01" aria-label="Useby date" name="useby_date" form="modify_product_form" class="text--center" value="<? echo $product['useby_date']; ?>" required>
                                </td>
                                <td class="text--center p--1">
                                    <input type="hidden" name="stocks_id" form="modify_product_form" value="<?php echo $product['stocks_id'] ?>" required>
                                    <input type="hidden" name="ingredient" form="modify_product_form" value="<?php echo $product['ingredient'] ?>" required>
                                    <input type="hidden" name="quantity_name" form="modify_product_form" value="<?php echo $product['quantity_name'] ?>" required>
                                    <button type="submit" form="modify_product_form" class="button--sm">Apply</button>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td class="text--center p--1"><? echo $product['ingredient']; ?></td>
                                <td class="text--center p--1"><? echo $product['quantity']. ' ' . $product['quantity_name']; ?></td>
                                <td class="text--center p--1"><? echo $product['useby_date']; ?></td>
                                <td class="text--center p--1">
                                    <a href="stocks.php?id=<?php echo $product['stocks_id'] ?>" class="button--sm">Modify</a>
                                    <input type="checkbox" id="<? echo $product['stocks_id']; ?>" name="<? echo $product['stocks_id']; ?>" form="delete_product_form" value="<? echo $product['stocks_id']; ?>">
                                </td>
                            </tr>
                        <?php endif; ?>                        
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
<?php include 'footer.php' ;?>