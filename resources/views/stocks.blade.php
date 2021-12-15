@extends("layouts.app")

@section("wrapper")
<div class="wrapper">
    <main class="element--center w--60 _mob_w--100">
        <h1 class="text--center">Stocks</h1>
        <div class="dsp--flex justify--between">
            <a href=" {{ route('total-stocks') }} " class="button m--3">Total stocks</a>
            <a href=" {{ route('stock.create') }} " class="button m--3">Add ingredient</a>
            <button type="submit" form="delete_product_form" class="button m--3">Delete selection</button>
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
        @elseif(isset($is_creating) && $commands_products->count() < 1)
            <div class="alert--message my--2 p--2">
                <span>No products are available in total stocks, please create one first, in order to be able to add products in stocks</span>
            </div>
        @elseif(session('message') !== null)
            <div class="alert--message my--2 p--2">
                {{ session('message') }}
            </div>
        @endif
        <!--End alerts-->

        <!--Forms-->
        <form method="POST" action=" {{ route('stock.add') }} " id="add_product_form">
            @csrf
        </form>
        <!--End forms-->

        <table class="element--center table--striped w--100">
            <thead class="w--100 bg--secondary text--light">
                <th class="w--25">Ingredient</th>
                <th class="w--25">Quantity</th>
                <th class="w--25">Use-by Date</th>
                <th class="w--25">Modifications</th>
            </thead>
            <tbody>
                @isset ($is_creating)
                    <tr>
                        <td class="text--center p--1">
                            <select name="command_id"  aria-label="Ingredient (unit)" form="add_product_form" class="text--center" placeholder="Ingredient (unit)" required>
                                @if($commands_products->count() > 0)
                                    <option value="" selected>Choose an ingredient and a unit</option>
                                    @foreach($commands_products as $commands_product)
                                        <option value="{{ $commands_product->id }}">{{ $commands_product->ingredient }} ({{ $commands_product->quantity_name }})</option>
                                    @endforeach
                                @else
                                    <option value="" selected>No products available</option>
                                @endif
                            </select>
                        </td>
                        <td class="text--center p--1">
                            <input type="number" aria-label="Quantity" min="0" name="quantity" form="add_product_form" class="text--center" placeholder="Quantity" required>
                        </td>
                        <td class="text--center p--1">
                            <input type="date" min="2000-01-01" max="3000-01-01" aria-label="Useby date" name="useby_date" form="add_product_form" class="text--center" required>
                        </td>
                        <td class="text--center p--1">
                            <button type="submit" form="add_product_form" class="button--sm">Add new</button>
                        </td>
                    </tr>  
                @endisset                
                @if ($products->count() > 0)
                    @foreach($products as $product)
                        <tr>
                            <td class="text--center p--1">{{ $product->ingredient }}</td>
                            <td class="text--center p--1">{{ $product->quantity }} {{ $product->quantity_name }}</td>
                            <td class="text--center p--1">{{ $product->useby_date }}</td>
                            <td class="text--center p--1"><a href="#" class="button--sm">Modify</a></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </main>
</div>
@endsection