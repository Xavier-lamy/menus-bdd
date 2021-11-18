<?php 
    //Read all data from stocks
    $sql = "SELECT * FROM `stocks`";
    require_once "./inc/_read.php";

    if( isset($_GET) && !empty($_GET) ){

        //Cleaning the id
        $id = strip_tags($_GET['id']);

        //Check if $id is in one of the result of the query results
        $is_selected_product = function($results, $id) {
            foreach ($results as $result) {
                if ($result['id']==$id) {
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
                <a href="#" class="button m--3">Add ingredient</a>
                <a href="#" class="button m--3">Delete selection</a>
            </div>
            <?php if(isset($selected_product_id) && !empty($selected_product_id)): ?>
                <form method="POST" action="modify.php" id="modify_product_form"></form>
            <?php endif; ?>
            <table class="element--center table--striped w--100">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--25">Ingredient</th>
                    <th class="w--25">Quantity</th>
                    <th class="w--25">Use-by Date</th>
                    <th class="w--25">Modifications</th>
                </thead>
                <tbody>
                    <?php foreach ($results as $product): ?>
                        <?php if($product['id']== $selected_product_id): ?>
                            <tr>
                                <td class="text--center p--1">
                                    <input type="text" minlength="1" maxlength="40" name="ingredient" form="modify_product_form" class="text--center" value="<? echo $product['ingredient']; ?>" required>
                                </td>
                                <td class="text--center p--1 dsp--flex align--center">
                                    <input type="number" min="0" name="quantity" form="modify_product_form" class="text--center w--50" value="<? echo $product['quantity']; ?>" required>
                                    <span class="w--50"><?php echo ' ' . $product['quantity_name']; ?></span>
                                </td>
                                <td class="text--center p--1">
                                    <input type="date" name="useby_date" form="modify_product_form" class="text--center" value="<? echo $product['useby_date']; ?>" required>
                                </td>
                                <td class="text--center p--1">
                                    <input type="hidden" name="id" form="modify_product_form" value="<?php echo $product['id'] ?>" required>
                                    <button type="submit" form="modify_product_form" class="button--sm">Apply</button>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td class="text--center p--1"><? echo $product['ingredient']; ?></td>
                                <td class="text--center p--1"><? echo $product['quantity']. ' ' . $product['quantity_name']; ?></td>
                                <td class="text--center p--1"><? echo $product['useby_date']; ?></td>
                                <td class="text--center p--1"><a href="stocks.php?id=<?php echo $product['id'] ?>" class="button--sm">Modify</a></td>
                            </tr>
                        <?php endif; ?>                        
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
<?php include 'footer.php' ;?>