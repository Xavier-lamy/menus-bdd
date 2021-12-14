@extends("layouts.app")

@section("wrapper")
<div class="wrapper">
    <main class="element--center w--60 _mob_w--100">
        <h1 class="text--center">Safety stocks</h1>
        <a href=" {{ route('stocks') }} " class="button m--3">Return to stocks</a>

        <table class="element--center table--striped w--100">
            <thead class="w--100 bg--secondary text--light">
                <th class="w--25">Ingredient</th>
                <th class="w--25">Total</th>
                <th class="w--25">Safety stock</th>
                <th class="w--25">Modifications</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </main>
</div>
@endsection