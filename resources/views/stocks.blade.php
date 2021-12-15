@extends("layouts.app")

@section("wrapper")
<div class="wrapper">
    <main class="element--center w--60 _mob_w--100">
        <h1 class="text--center">Stocks</h1>
        <div class="dsp--flex justify--between">
            <a href=" {{ route('safety-stocks') }} " class="button m--3">Safety stocks</a>
            <a href="{{-- stocks.php?param=add_item --}}" class="button m--3">Add ingredient</a>
            <button type="submit" form="delete_product_form" class="button m--3">Delete selection</button>
        </div>
        
        @if(session('error') !== null)
            <div class="alert--message my--2 p--2">
                {{ session('error') }}
            </div>
        @elseif(session('success') !== null)
            <div class="alert--success my--2 p--2">
                {{ session('success') }}
            </div>
        @endif

        <!--Forms-->
{{--         <form method="POST" action=" {{ route('command.add') }} " id="add_product_type_form">
            @csrf
        </form> --}}
        <!--End forms-->

        <table class="element--center table--striped w--100">
            <thead class="w--100 bg--secondary text--light">
                <th class="w--25">Ingredient</th>
                <th class="w--25">Quantity</th>
                <th class="w--25">Use-by Date</th>
                <th class="w--25">Modifications</th>
            </thead>
            <tbody>                
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