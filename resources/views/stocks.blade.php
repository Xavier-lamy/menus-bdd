@extends("layouts.app")

@section("wrapper")
<div class="wrapper">
    <main class="element--center w--60 _mob_w--100">
        <h1 class="text--center">Stocks</h1>
        <div class="dsp--flex justify--between">
            <a href=" {{ route('safety-stocks') }} " class="button m--3">Safety stocks</a>
            <a href="{{-- stocks.php?param=add_item --}}" class="button m--3">Add ingredient</a>
            <button type="submit" form="delete_product_form" class="button m--3">Delete selection</button>
        </div>            
        <table class="element--center table--striped w--100">
            <thead class="w--100 bg--secondary text--light">
                <th class="w--25">Ingredient</th>
                <th class="w--25">Quantity</th>
                <th class="w--25">Use-by Date</th>
                <th class="w--25">Modifications</th>
            </thead>
            <tbody>                

            </tbody>
        </table>
    </main>
</div>
@endsection