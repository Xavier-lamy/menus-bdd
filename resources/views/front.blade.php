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
                    @if ($products->count() > 0)
                        @foreach($products as $product)
                            <tr>
                                <td class="text--center p--1">{{ $product->ingredient }}</td>
                                <td class="text--center p--1">{{ ($product->alert_stock)*1.5 }} {{ $product->quantity_name }}</td>
                            </tr>
                        @endforeach
                    @endif                   
                </tbody>
            </table>
        </main>
    </div>
@endsection