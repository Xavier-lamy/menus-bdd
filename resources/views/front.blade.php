@extends("layouts.app")

@section("wrapper")
    <div class="wrapper">
        <main class="element--center w--60 _mob_w--100">
            <h1 class="text--center">My shopping list</h1>

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

            <table class="element--center table--striped w--100">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--25">Ingredient</th>
                    <th class="w--25">Quantity needed</th>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="text--center p--1">{{ $product->ingredient }}</td>
                            <td class="text--center p--1">{{ (($product->alert_stock) * 1.5) - ($product->quantity) }} {{ $product->unit }}</td>
                        </tr>
                    @empty 
                        <tr>
                            <td colspan="2" class="text--center">Shopping list is empty</td>
                        </tr>                        
                    @endforelse
                </tbody>
            </table>
        </main>
    </div>
@endsection