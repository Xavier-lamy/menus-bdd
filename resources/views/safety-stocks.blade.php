@extends("layouts.app")

@section("wrapper")
<div class="wrapper">
    <main class="element--center w--60 _mob_w--100">
        <h1 class="text--center">Safety stocks</h1>
        <div class="dsp--flex justify--between">
            <a href=" {{ route('stocks') }} " class="button m--3">Return to stocks</a>
            <a href="#" class="button m--3">Add a new type of product</a>
        </div>

        <table class="element--center table--striped w--100">
            <thead class="w--100 bg--secondary text--light">
                <th class="w--25">Ingredient</th>
                <th class="w--25">Total</th>
                <th class="w--25">Safety stock</th>
                <th class="w--25">Modifications</th>
            </thead>
            <tbody>
                @if ($products->count() > 0)
                    @foreach($products as $product)
                        <tr>
                            <td class="text--center p--1">{{ $product->ingredient }}</td>
                            <td class="text--center p--1">{{ $product->quantity }} {{ $product->quantity_name }}</td>
                            <td class="text--center p--1">{{ $product->alert_stock }}</td>
                            <td class="text--center p--1"><a href="#" class="button--sm">Modify</a></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </main>
</div>
@endsection