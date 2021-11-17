<?php 
    //Read all data from stocks
    $sql = "SELECT * FROM `stocks`";
    require_once "./inc/_read.php";

    if( isset($_GET) && !empty($_GET) ){

        //Cleaning the id, to protect against sql injections
        $id = strip_tags($_GET['id']);

        //preparing query
        $sql = 'SELECT * FROM `stocks` WHERE `id`= :id';
        $query = $db->prepare($sql);

        $query->bindParam(':id', $id, PDO::PARAM_INT);

        //executing query
        $query->execute();

        //store results in array
        $selected_product = $query->fetch();

        require_once "./inc/_disconnect.php";

        //Define the product ID
        if($selected_product) {
            $selected_product_id = $selected_product['id'];
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
        <main class="element--center">
            <h1 class="text--center">Stocks</h1>
            <?php if(isset($selected_product_id) && !empty($selected_product_id)): ?>
                <form method="POST" action="#" id="modify_product_form"></form>
            <?php endif; ?>
            <table class="element--center table--striped w--50">
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
                                    <input type="text" name="ingredient" form="modify_product_form" class="text--center bg--none" value="<? echo $product['ingredient']; ?>">
                                </td>
                                <td class="text--center p--1 dsp--flex">
                                    <input type="number" name="quantity" form="modify_product_form" class="text--center bg--none w--50" value="<? echo $product['quantity']; ?>">
                                    <span class="w--50"><?php echo ' ' . $product['quantity_name']; ?></span>
                                </td>
                                <td class="text--center p--1">
                                    <input type="date" name="useby_date" form="modify_product_form" class="text--center bg--none" value="<? echo $product['useby_date']; ?>">
                                </td>
                                <td class="text--center p--1">
                                    <input type="hidden" name="id" form="modify_product_form" value="<?php echo $product['id'] ?>">
                                    <button type="submit" form="modify_product_form" class="button--sm">Validate</button>
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