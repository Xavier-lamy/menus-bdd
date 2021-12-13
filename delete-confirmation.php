<?php 
    //Create session
    session_start();

    if (isset($_POST) && !empty($_POST)) {
        //Strip tags from all ids, and concatenate array into a string
        $array = array();
        foreach ($_POST as $value) {
            strip_tags($value);
            $array[] = $value;
        }
        $ids = implode(",", $array);

        //Connection to db
        require_once "./inc/_connect.php";

        $sql = "SELECT * FROM `stocks` WHERE `stocks_id` IN ($ids)";

        $query = $db->prepare($sql);

        $query->execute();

        //store results in array
        $results = $query->fetchAll();

        //End connection to db   
        require_once "./inc/_disconnect.php";

    }
    else {
        //Redirection
        $_SESSION['error'] = "You need to select products to delete";
        header('Location: stocks.php');
        exit();
    }
?>
<?php include 'header.php' ;?>
    <div class="wrapper">
        <main class="element--center w--60 _mob_w--100">
            <h1 class="text--center">Delete confirmation</h1>
            <p class="alert--message my--2 p--2">Do you really want to delete those products, they will be lost forever.<br>
            Note: this is recommanded to adjust quantity to 0 when you don't have a product anymore, this way you can easily change it back when you buy some again.<br>
            Prefer keeping delete ability for products you will never buy again for sure (like Brussels sprouts) </p>
            <div class="dsp--flex justify--between">
                <a href="stocks.php" class="button m--3">Cancel (return to stocks)</a>
                <button type="submit" form="confirm_deletion_form" class="button m--3">Confirm deletion</button>
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

            <form method="POST" action="./inc/_delete.php" id="confirm_deletion_form"></form>

            <table class="element--center table--striped w--100">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--25">Ingredient</th>
                    <th class="w--25">Quantity</th>
                    <th class="w--25">Use-by Date</th>
                </thead>
                <tbody>
                    <?php foreach ($results as $product): ?>
                            <tr>
                                <td class="text--center p--1"><?php echo $product['ingredient']; ?></td>
                                <td class="text--center p--1"><?php echo $product['quantity']. ' ' . $product['quantity_name']; ?></td>
                                <td class="text--center p--1">
                                    <?php echo $product['useby_date']; ?>
                                    <input type="hidden" name="<?php echo $product['stocks_id'] ?>" form="confirm_deletion_form" value="<?php echo $product['stocks_id'] ?>" required>
                                </td>
                            </tr>                      
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
<?php include 'footer.php' ;?>