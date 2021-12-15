@extends("layouts.app")

@section("wrapper")
<div class="wrapper">
    <main class="element--center w--60 _mob_w--100">
        <h1 class="text--center">Total stocks</h1>
        <div class="dsp--flex justify--between">
            <a href=" {{ route('stocks') }} " class="button m--3">Return to stocks</a>
            <a href=" {{ route('command.create') }} " class="button m--3">Add a new type of product</a>
            <button type="submit" form="delete_product_type_form" class="button m--3">Delete selection</button>
        </div>

        <!--Alerts-->
        @if(session('error') !== null)
            <div class="alert--warning my--2 p--2">
                {{ session('error') }}
            </div>
        @elseif(session('success') !== null)
            <div class="alert--success my--2 p--2">
                {{ session('success') }}
            </div>
        @elseif(session('message') !== null)
            <div class="alert--message my--2 p--2">
                {{ session('message') }}
            </div>
        @endif
        <!--End alerts-->

        <!--Forms-->
        <form method="POST" action=" {{ route('command.add') }} " id="add_product_type_form">
            @csrf
        </form>
        <!--End forms-->

        <table class="element--center table--striped w--100">
            <thead class="w--100 bg--secondary text--light">
                <th class="w--25">Ingredient</th>
                <th class="w--25">Total</th>
                <th class="w--25">Safety stock</th>
                <th class="w--25">Modifications</th>
            </thead>
            <tbody>
                @isset ($is_creating)
                    <tr>
                        <td class="text--center p--1">
                            <input type="text" aria-label="Ingredient" maxlength="60" minlength="1" name="ingredient" form="add_product_type_form" class="text--center" placeholder="Ingredient" required>
                        </td>
                        <td class="text--center p--1">
                            <input type="text" aria-label="Unit" maxlength="40" minlength="1" name="quantity_name" form="add_product_type_form" class="text--center" placeholder="Unit" required>
                        </td>
                        <td class="text--center p--1">
                            <input type="number" min="0" name="alert_stock" form="add_product_type_form" class="text--center" placeholder="Alert Stock" required>
                        </td>
                        <td class="text--center p--1">
                            <button type="submit" form="add_product_type_form" class="button--sm">Add new</button>
                        </td>
                    </tr>  
                @endisset
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