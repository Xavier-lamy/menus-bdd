@extends("layouts.app")

@section("wrapper")
    @if($delete_confirmation == 'stocks')
        <div class="wrapper">
            <main class="element--center w--60 _mob_w--100">
                <h1 class="text--center">Delete stock products confirmation</h1>
                <p class="alert--message my--2 p--2">Do you really want to delete those products, they will be lost forever.</p>
                <div class="dsp--flex justify--between">
                    <a href="{{ route('stocks') }}" class="button m--3">Cancel (return to stocks)</a>
                    <button type="submit" form="confirm_stocks_deletion_form" class="button m--3">Confirm deletion</button>
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

                <form method="POST" action=" {{ route('stock.delete') }} " id="confirm_stocks_deletion_form">
                    @csrf
                </form>

                <table class="element--center table--striped w--100">
                    <thead class="w--100 bg--secondary text--light">
                        <th class="w--25">Ingredient</th>
                        <th class="w--25">Quantity</th>
                        <th class="w--25">Use-by Date</th>
                    </thead>
                    <tbody>
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
                    </tbody>
                </table>
            </main>
        </div>
    @elseif($delete_confirmation == 'commands')
        <div class="wrapper">
            <main class="element--center w--60 _mob_w--100">
                <h1 class="text--center">Confirm deletion of product types</h1>
                <p class="alert--message my--2 p--2">Do you really want to delete those products, this will delete all products related to this type.<br>
                Note: this is recommended to delete related products in stocks instead and keep the types in total stocks, this way you can easily change it back when you buy some again.<br>
                Prefer keeping delete ability for products you will never buy again for sure (like Brussels sprouts) </p>
                <div class="dsp--flex justify--between">
                    <a href="{{ route('commands') }}" class="button m--3">Cancel (return to total stocks)</a>
                    <button type="submit" form="confirm_commands_deletion_form" class="button m--3">Confirm deletion</button>
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

                <form method="POST" action=" {{ route('command.delete') }} " id="confirm_commands_deletion_form">
                    @csrf
                </form>

                <table class="element--center table--striped w--100">
                    <thead class="w--100 bg--secondary text--light">
                        <th class="w--25">Ingredient</th>
                        <th class="w--25">Total</th>
                        <th class="w--25">Safety stock</th>
                    </thead>
                    <tbody>
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
                    </tbody>
                </table>
            </main>
        </div>
    @endif
@endsection