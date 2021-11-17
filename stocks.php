<?php 
    //Read data from stocks
    $sql = 'SELECT * FROM `stocks`';
    require_once "./inc/_read.php";
?>
<?php include 'header.php' ;?>
    <div class="wrapper">
        <main class="element--center">
            <h1 class="text--center">Stocks</h1>
            <table class="element--center table--striped w--50">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--25">Ingredient</th>
                    <th class="w--25">Quantity</th>
                    <th class="w--25">Use-by Date</th>
                    <th class="w--25">Modifications</th>
                </thead>
                <tbody>
                    <?php foreach ($result as $product): ?>
                        <tr>
                            <td class="text--center p--1"><? echo $product['ingredient']; ?></td>
                            <td class="text--center p--1"><? echo $product['quantity']. ' ' . $product['quantity_name']; ?></td>
                            <td class="text--center p--1"><? echo $product['useby_date']; ?></td>
                            <td class="text--center p--1"><a href="modify.php?id=<?php echo $product['id'] ?>" class="button--sm">Modify</a></td>
                        </tr>                        
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
<?php include 'footer.php' ;?>