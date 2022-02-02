@extends("layouts.app")

    @section('title')
        Total stocks
    @endsection

    @section('buttons')
        <a href=" {{ route('stocks') }} " class="button m--3">Return to stocks</a>
        <a href=" {{ route('command.create') }} " class="button m--3">Add a new type of product</a>
        <button type="submit" form="delete_product_form" class="button m--3">Delete selection</button>
    @endsection

    @section('forms')
        @if(isset($is_creating))
            <form method="POST" action=" {{ route('command.add') }} " id="add_product_type_form">
                @csrf
            </form>
        @elseif(isset($modifying_product_id))
            <form method="POST" action=" {{ route('command.apply') }} " id="modify_product_form">
                @csrf
            </form>
        @endif
        <form method="POST" action=" {{ route('command-delete-confirmation') }} " id="delete_product_form">
            @csrf
        </form>
    @endsection

    @section('table-head')
        <th class="w--25">Ingredient</th>
        <th class="w--25">Total</th>
        <th class="w--25">Safety stock</th>
        <th class="w--25">Modifications</th>
    @endsection
    @section('table-body')
        {{--Check if page is on creation mode:--}}
        @isset ($is_creating)
            {{--Add a row with "add product" form, return old values if user come back from a failed data validation redirection--}}
            <tr class="bg--secondary-fade">
                <td class="text--center p--1">
                    <input type="text" aria-label="Ingredient" maxlength="60" minlength="1" name="ingredient"  value="{{ old('ingredient') }}" form="add_product_type_form" class="text--center input--inset" placeholder="Ingredient" required autofocus>
                </td>
                <td class="text--center p--1">
                    <input type="text" aria-label="Unit" maxlength="40" minlength="1" name="unit" value="{{ old('unit') }}" form="add_product_type_form" class="text--center input--inset" placeholder="Unit" required>
                </td>
                <td class="text--center p--1">
                    <input type="number" min="0" name="alert_stock" value="{{ old('alert_stock') }}" form="add_product_type_form" class="text--center input--inset" placeholder="Alert Stock" required>
                </td>
                <td class="text--center p--1">
                    <button type="submit" form="add_product_type_form" class="button--sm">Add new</button>
                    <a href=" {{ route('commands') }} " class="button--sm">Cancel</a>
                </td>
            </tr>  
        @endisset

        {{--Loop for displaying all products in command--}}
        @forelse($products as $product)
            {{--Check if the current product in the loop is being modified, if yes display "modify" form--}}
            @if(isset($modifying_product_id) && $modifying_product_id == $product->id)
                <tr class="bg--secondary-fade">
                    <td class="text--center p--1">
                        <input type="text" aria-label="Ingredient" maxlength="60" minlength="1" name="ingredient" form="modify_product_form" class="text--center input--inset" value="{{ $product->ingredient }}" required autofocus>
                    </td>
                    <td class="text--center p--1">
                        <input type="text" aria-label="Unit" maxlength="40" minlength="1" name="unit" form="modify_product_form" class="text--center input--inset" value="{{ $product->unit }}" required>
                    </td>
                    <td class="text--center p--1">
                        <input type="number" min="0" name="alert_stock" form="modify_product_form" class="text--center input--inset" value="{{ $product->alert_stock }}" required>
                    </td>
                    <td class="text--center p--1">
                        <input type="hidden" name="id" form="modify_product_form" value="{{ $product->id }}" required>
                        <button type="submit" form="modify_product_form" class="button--sm">Apply</button>
                        <a href=" {{ route('commands') }} " class="button--sm">Cancel</a>
                    </td>
                </tr>
            {{--If product is not being modified: display standard layout:--}}
            @else 
                <tr>
                    <td class="text--center p--1">{{ $product->ingredient }}</td>
                    <td class="text--center p--1">{{ $product->quantity }} {{ $product->unit }}</td>
                    <td class="text--center p--1">{{ $product->alert_stock }}</td>
                    <td class="text--center p--1">
                        <a href=" {{ route('command.modify', ['id' => $product->id]) }} " class="button--sm">Modify</a>
                        <input type="checkbox" id="{{ $product->id }}" name="delete_{{ $product->id }}" form="delete_product_form" value="{{ $product->id }}">
                    </td>
                </tr>
            @endif
        {{--If loop doesn't have product:--}}
        @empty 
            <tr>
                <td colspan="4" class="text--center">Total stocks are empty</td>
            </tr>
        @endforelse
    @endsection