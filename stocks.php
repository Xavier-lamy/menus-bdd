<?php 
    //Read data from stocks
    $sql = 'SELECT * FROM `stocks`';
    require_once "./inc/_read.php";
?>
<?php include 'header.php' ;?>
    <div class="wrapper">
        <main class="element--center">
            <h1 class="text--center">Stocks</h1>
            <table class="element--center table w--50">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--40">Ingredient</th>
                    <th class="w--30">Quantity</th>
                    <th>Use-by Date</th>
                </thead>
                <tbody>
                    <?php foreach ($result as $product): ?>
                        <tr>
                            <td class="text--center border--top"><? echo $product['ingredient']; ?></td>
                            <td class="text--center"><? echo $product['quantity']. ' ' . $product['quantity_name']; ?></td>
                            <td class="text--center"><? echo $product['useby_date']; ?></td>
                        </tr>                        
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
<?php include 'footer.php' ;?>