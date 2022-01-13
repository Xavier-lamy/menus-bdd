@php 
    use \App\Http\Controllers\FrontController; 
@endphp
@extends("layouts.app")

@section("wrapper")
<div class="wrapper">
    <main class="element--center w--60 _mob_w--100">
        <h1 class="text--center">Stocks</h1>
        <div class="dsp--flex justify--between">
            <a href=" {{ route('commands') }} " class="button m--3">Total stocks</a>
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
        @elseif($errors->any())
            <ul class="alert--warning my--2 p--2 list--unstyled">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <!--End alerts-->

        <!--Forms-->
        @if(isset($is_creating))
            <form method="POST" action=" {{ route('stock.add') }} " id="add_product_form">
                @csrf
            </form>
        @elseif(isset($modifying_product_id))
            <form method="POST" action=" {{ route('stock.apply') }} " id="modify_product_form">
                @csrf
            </form>
        @endif
        <form method="POST" action=" {{ route('stock-delete-confirmation') }} " id="delete_product_form">
            @csrf
        </form>
        <!--End forms-->

        <table class="element--center table--striped w--100">
            <thead class="w--100 bg--secondary text--light">
                <th class="w--25">Ingredient</th>
                <th class="w--25">Quantity</th>
                <th class="w--25 tooltip_container">
                    Use-by Date <i class="fas fa-question-circle"></i>
                    <span class="tooltip_text">
                        <ul class="list--unstyled fw--normal p--1 m--1">
                            <li class="text--warning">Expired !</li>
                            <li class="text--message">Expire soon</li>
                            <li class="text--success">Not urgent</li>
                        </ul>
                    </span>
                </th>
                <th class="w--25">Modifications</th>
            </thead>
            <tbody>
                @isset ($is_creating)
                    <tr class="bg--secondary-fade">
                        <td class="text--center p--1">
                            <select name="command_id"  aria-label="Ingredient (unit)" form="add_product_form" class="text--center input--inset" title="Ingredient (unit)" required autofocus>
                                @if($commands_products->count() > 0)
                                    <option value="" selected>Choose an ingredient and a unit</option>
                                    @foreach($commands_products as $commands_product)
                                        <option value="{{ $commands_product->id }}">{{ $commands_product->ingredient }} ({{ $commands_product->unit }})</option>
                                    @endforeach
                                @else
                                    <option value="" selected>No products available</option>
                                @endif
                            </select>
                        </td>
                        <td class="text--center p--1">
                            <input type="number" aria-label="Quantity" min="0" name="quantity" form="add_product_form" class="text--center input--inset" placeholder="Quantity" required>
                        </td>
                        <td class="text--center p--1">
                            <input type="date" min="2000-01-01" max="2300-01-01" aria-label="Useby date" name="useby_date" form="add_product_form" class="text--center input--inset" required>
                        </td>
                        <td class="text--center p--1">
                            <button type="submit" form="add_product_form" class="button--sm">Add new</button>
                            <a href=" {{ route('stocks') }} " class="button--sm">Cancel</a>
                        </td>
                    </tr>  
                @endisset                
                @forelse($products as $product)
                    @if(isset($modifying_product_id) && $modifying_product_id == $product->id)
                        <tr class="bg--secondary-fade">
                            <td class="text--center p--1">{{ $product->ingredient }}</td>
                            <td class="text--center p--1 dsp--flex align--center">
                                <input type="number" aria-label="Quantity" min="0" name="quantity" form="modify_product_form" class="text--center w--50 input--inset" value="{{ $product->quantity }}" required autofocus>
                                <span class="w--50">{{ $product->unit }}</span>
                            </td>
                            <td class="text--center p--1">
                                <input type="date" min="2000-01-01" max="3000-01-01" aria-label="Useby date" name="useby_date" form="modify_product_form" class="text--center input--inset" value="{{ $product->useby_date }}" required>
                            </td>
                            <td class="text--center p--1">
                                <input type="hidden" name="id" form="modify_product_form" value="{{ $product->id }}" required>
                                <input type="hidden" name="command_id" form="modify_product_form" value="{{ $product->command_id }}" required>
                                <button type="submit" form="modify_product_form" class="button--sm">Apply</button>
                                <a href=" {{ route('stocks') }} " class="button--sm">Cancel</a>
                            </td>
                        </tr>
                    @else 
                        <tr>
                            <td class="text--center p--1">{{ $product->ingredient }}</td>
                            <td class="text--center p--1">{{ $product->quantity }} {{ $product->unit }}</td>
                            <td class="text--center p--1 text-{{ FrontController::checkProductExpire($product->useby_date); }}">
                                {{ $product->useby_date }}
                            </td>
                            <td class="text--center p--1">
                                <a href=" {{ route('stock.modify', ['id' => $product->id]) }} " class="button--sm">Modify</a>
                                <input type="checkbox" id="{{ $product->id }}" name="delete_{{ $product->id }}" form="delete_product_form" value="{{ $product->id }}">
                            </td>
                        </tr>
                    @endif
                @empty
                        <tr>
                            <td colspan="4" class="text--center">Stocks are empty</td>
                        </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</div>
@endsection