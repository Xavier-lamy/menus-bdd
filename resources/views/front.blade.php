@extends("layouts.app")

@section("wrapper")
    <div class="wrapper">
        <main class="element--center w--60 _mob_w--100">
            <h1 class="text--center">My shopping list</h1>
            <table class="element--center table--striped w--100">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--25">Ingredient</th>
                    <th class="w--25">Quantity needed</th>
                </thead>
                <tbody>
                    <?php /* foreach ($results as $product): */ ?>
                        <tr>
                            <td class="text--center p--1"><?php /* echo $product['ingredient']; */ ?></td>
                            <td class="text--center p--1">
                                <?php 
                                    /* $must_buy_quantity = $product['alert_stock'] * 2;
                                    echo $must_buy_quantity . ' ' . $product['quantity_name'];  */
                                ?>
                            </td>
                        </tr>                        
                    <?php /* endforeach; */ ?>
                </tbody>
            </table>
        </main>
    </div>
@endsection