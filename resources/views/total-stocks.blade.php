@extends("layouts.app")

@section("wrapper")
<div class="wrapper">
    <main class="element--center w--60 _mob_w--100">
        <h1 class="text--center">Total stocks</h1>
        <div class="dsp--flex justify--between">
            <a href=" {{ route('stocks') }} " class="button m--3">Return to stocks</a>
            <a href=" {{ route('command.create') }} " class="button m--3">Add a new type of product</a>
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
                    <tr class="bg--secondary-fade">
                        <td class="text--center p--1">
                            <input type="text" aria-label="Ingredient" maxlength="60" minlength="1" name="ingredient" form="add_product_type_form" class="text--center input--inset" placeholder="Ingredient" required autofocus>
                        </td>
                        <td class="text--center p--1">
                            <input type="text" aria-label="Unit" maxlength="40" minlength="1" name="quantity_name" form="add_product_type_form" class="text--center input--inset" placeholder="Unit" required>
                        </td>
                        <td class="text--center p--1">
                            <input type="number" min="0" name="alert_stock" form="add_product_type_form" class="text--center input--inset" placeholder="Alert Stock" required>
                        </td>
                        <td class="text--center p--1">
                            <button type="submit" form="add_product_type_form" class="button--sm">Add new</button>
                            <a href=" {{ route('total-stocks') }} " class="button--sm">Cancel</a>
                        </td>
                    </tr>  
                @endisset
                @if ($products->count() > 0)
                    @foreach($products as $product)
                        @if(isset($modifying_product_id) && $modifying_product_id == $product->id)
                            <tr class="bg--secondary-fade">
                                <td class="text--center p--1">
                                    <input type="text" aria-label="Ingredient" maxlength="60" minlength="1" name="ingredient" form="modify_product_form" class="text--center input--inset" value="{{ $product->ingredient }}" required autofocus>
                                </td>
                                <td class="text--center p--1">
                                    <input type="text" aria-label="Unit" maxlength="40" minlength="1" name="quantity_name" form="modify_product_form" class="text--center input--inset" value="{{ $product->quantity_name }}" required>
                                </td>
                                <td class="text--center p--1">
                                    <input type="number" min="0" name="alert_stock" form="modify_product_form" class="text--center input--inset" value="{{ $product->alert_stock }}" required>
                                </td>
                                <td class="text--center p--1">
                                    <input type="hidden" name="id" form="modify_product_form" value="{{ $product->id }}" required>
                                    <button type="submit" form="modify_product_form" class="button--sm">Apply</button>
                                    <a href=" {{ route('total-stocks') }} " class="button--sm">Cancel</a>
                                </td>
                            </tr>
                        @else 
                            <tr>
                                <td class="text--center p--1">{{ $product->ingredient }}</td>
                                <td class="text--center p--1">{{ $product->quantity }} {{ $product->quantity_name }}</td>
                                <td class="text--center p--1">{{ $product->alert_stock }}</td>
                                <td class="text--center p--1">
                                    <a href=" {{ route('command.modify', ['id' => $product->id]) }} " class="button--sm">Modify</a>
                                    <input type="checkbox" id="{{ $product->id }}" name="delete_{{ $product->id }}" form="delete_product_form" value="{{ $product->id }}">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @else 
                    <tr>
                        <td colspan="4" class="text--center">Total stocks are empty</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </main>
</div>
@endsection