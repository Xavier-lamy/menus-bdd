@extends("layouts.app")

@section("wrapper")
<div class="wrapper">
    <main class="element--center w--60 _mob_w--100">
        <h1 class="text--center">Recipes</h1>
        <div class="dsp--flex justify--between">

        </div>

        @include("partials.alert")

        <table class="element--center table--striped w--100">
            <thead class="w--100 bg--secondary text--light">

            </thead>
            <tbody>

            </tbody>
        </table>
    </main>
</div>
@endsection