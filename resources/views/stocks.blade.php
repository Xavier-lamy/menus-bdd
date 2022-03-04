@extends("layouts.app")
    @section('title')
        Stocks
    @endsection

    @section('buttons')
        <a href=" {{ route('commands') }} " class="button m--3">Total stocks</a>
        <a href=" {{ route('stock.create') }} " class="button m--3">Add ingredient</a>
        <button type="submit" form="delete_product_form" class="button m--3">Delete selection</button>
    @endsection

    @section('alert')
        @parent
        @if(isset($is_creating) && $commands_products->count() < 1)
        <div class="alert--message my--2 p--2">
            No products are available in total stocks, please create one first, in order to be able to add products in stocks.<br>
            You can go in options to generate a list of common ingredients.
        </div>
        @endif        
    @endsection

    @section('forms')
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
    @endsection

    @section('table-head')
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
    @endsection
    @section('table-body')
        @isset ($is_creating)
            <tr class="bg--secondary-fade">
                <td class="text--center p--1">
                    <select name="command_id"  aria-label="Ingredient (unit)" form="add_product_form" class="text--center input--inset" title="Ingredient (unit)" required autofocus>
                        @if($commands_products->count() > 0)
                            <option value="" {{ old("command_id") == "" ? "selected" : "" }}>
                                Choose an ingredient and a unit
                            </option>
                            @foreach($commands_products as $commands_product)
                                <option value="{{ $commands_product->id }}" {{ old("command_id") == $commands_product->id ? "selected" : "" }}>
                                    {{ $commands_product->ingredient }} ({{ $commands_product->unit }})
                                </option>
                            @endforeach
                        @else
                            <option value="" selected>No products available</option>
                        @endif
                    </select>
                </td>
                <td class="text--center p--1">
                    <input type="number" aria-label="Quantity" min="0" name="quantity" value="{{ old("quantity") }}" form="add_product_form" class="text--center input--inset" placeholder="Quantity" required>
                </td>
                <td class="text--center p--1">
                    <input type="date" min="2000-01-01" max="2300-01-01" aria-label="Useby date" name="useby_date" value="{{ old("useby_date") }}" form="add_product_form" class="text--center input--inset" required>
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
                    <td class="text--center p--1">{{ $product->command->ingredient }}</td>
                    <td class="text--center p--1 dsp--flex align--center">
                        <input type="number" aria-label="Quantity" min="0" name="quantity" form="modify_product_form" class="text--center w--50 input--inset" value="{{ $product->quantity }}" required autofocus>
                        <span class="w--50">{{ $product->command->unit }}</span>
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
                    <td class="text--center p--1">{{ $product->command->ingredient }}</td>
                    <td class="text--center p--1">{{ $product->quantity }} {{ $product->command->unit }}</td>
                    <td class="text--center p--1 text-{{ checkProductExpire($product->useby_date); }}">
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
    @endsection
