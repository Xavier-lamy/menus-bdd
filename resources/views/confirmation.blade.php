@extends("layouts.app")

@if($delete_confirmation == 'stocks')

    @section('title')
        Delete stock products confirmation
    @endsection

    @section('buttons')
        <a href="{{ route('stocks') }}" class="button m--3">Cancel (return to stocks)</a>
        <button type="submit" form="confirm_stocks_deletion_form" class="button m--3">Confirm deletion</button>
    @endsection

    @section('alert')
        @parent
        <p class="alert--message my--2 p--2">Do you really want to delete those products, they will be lost forever.</p>
    @endsection

    @section('forms')
        <form method="POST" action=" {{ route('stock.delete') }} " id="confirm_stocks_deletion_form">
            @csrf
        </form>
    @endsection

    @section('table-head')
        <th class="w--25">Ingredient</th>
        <th class="w--25">Quantity</th>
        <th class="w--25">Use-by Date</th>
    @endsection
    @section('table-body')
        @if ($products->count() > 0)
            @foreach($products as $product)
                <tr>
                    <td class="text--center p--1">{{ $product->command->ingredient }}</td>
                    <td class="text--center p--1">{{ $product->quantity }} {{ $product->command->unit }}</td>
                    <td class="text--center p--1">
                        {{ $product->useby_date }}
                        <input type="hidden" name="delete_{{ $product->id }}" form="confirm_stocks_deletion_form" value="{{ $product->id }}" required>
                    </td>
                </tr>
            @endforeach
        @endif 
    @endsection

@elseif($delete_confirmation == 'commands')

    @section('title')
        Confirm deletion of product types
    @endsection

    @section('buttons')
        <a href="{{ route('commands') }}" class="button m--3">Cancel (return to total stocks)</a>
        <button type="submit" form="confirm_commands_deletion_form" class="button m--3">Confirm deletion</button>
    @endsection

    @section('alert')
        @parent
        <p class="alert--message my--2 p--2">
            Do you really want to delete those products, this will delete all products related to this type.<br>
            Products will also be remove from all the recipes they belong to<br>
            Note: this is recommended to delete related products in stocks instead and keep the types in total stocks, this way you can easily change it back when you buy some again.<br>
            Prefer keeping delete ability for products you will never buy again for sure (like Brussels sprouts) 
        </p>
    @endsection

    @section('forms')
        <form method="POST" action=" {{ route('command.delete') }} " id="confirm_commands_deletion_form">
            @csrf
        </form>
    @endsection

    @section('table-head')
        <th class="w--25">Ingredient</th>
        <th class="w--25">Total</th>
        <th class="w--25">Safety stock</th>
    @endsection
    @section('table-body')
        @forelse($products as $product)
            <tr>
                <td class="text--center p--1">{{ $product->ingredient }}</td>
                <td class="text--center p--1">{{ $product->quantity }} {{ $product->unit }}</td>
                <td class="text--center p--1">
                    {{ $product->alert_stock }}
                    <input type="hidden" name="delete_{{ $product->id }}" form="confirm_commands_deletion_form" value="{{ $product->id }}" required>
                </td>
            </tr>
        @empty 
            <tr>
                <td colspan="3" class="text--center">No products to delete</td>
            </tr>
        @endforelse
    @endsection

@elseif($delete_confirmation == 'recipes')

    @section('title')
        Confirm deletion of recipes
    @endsection

    @section('buttons')
        <a href="{{ route('recipes') }}" class="button m--3">Cancel (return to recipes)</a>
        <button type="submit" form="confirm_recipes_deletion_form" class="button m--3">Confirm deletion</button>
    @endsection

    @section('alert')
        @parent
        <p class="alert--message my--2 p--2">Do you really want to delete those recipes ?<br>
        All menus using these recipes will have them remove from their list</p>
    @endsection

    @section('forms')
        <form method="POST" action=" {{ route('recipe.delete') }} " id="confirm_recipes_deletion_form">
            @csrf
        </form>
    @endsection

    @section('table-head')
        <th class="w--100">Recipe Title</th>
    @endsection
    @section('table-body')
        @forelse($recipes as $recipe)
            <tr>
                <td class="text--center p--1">
                    {{ $recipe->name }}
                    <input type="hidden" name="delete_{{ $recipe->id }}" form="confirm_recipes_deletion_form" value="{{ $recipe->id }}" required>
                </td>
            </tr>
        @empty 
            <tr>
                <td class="text--center">No recipes to delete</td>
            </tr>
        @endforelse
    @endsection

@elseif($delete_confirmation == 'menus')

    @section('title')
        Confirm deletion of menus
    @endsection

    @section('buttons')
        <a href="{{ route('menus') }}" class="button m--3">Cancel (return to menus)</a>
        <button type="submit" form="confirm_menus_deletion_form" class="button m--3">Confirm deletion</button>
    @endsection

    @section('alert')
        @parent
        <p class="alert--message my--2 p--2">Do you really want to delete those menus ?</p>
    @endsection

    @section('forms')
        <form method="POST" action=" {{ route('menu.delete') }} " id="confirm_menus_deletion_form">
            @csrf
        </form>
    @endsection

    @section('table-head')
        <th class="w--100">Menus</th>
    @endsection
    @section('table-body')
        @forelse($menus as $menu)
            <tr>
                <td class="text--center p--1">
                    {{ $menu->day }} menu
                    <input type="hidden" name="delete_{{ $menu->id }}" form="confirm_menus_deletion_form" value="{{ $menu->id }}" required>
                </td>
            </tr>
        @empty 
            <tr>
                <td class="text--center">No menu to delete</td>
            </tr>
        @endforelse
    @endsection
@endif