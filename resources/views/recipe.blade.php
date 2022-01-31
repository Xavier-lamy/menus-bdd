@extends("layouts.app")

@section("wrapper")
<div class="wrapper">
    <main class="element--center w--60 _mob_w--100">
        @if(!empty($recipe) && !isset($is_creating))
            <h1 class="text--center">{{ $recipe->name }}</h1>

            @include("partials.alert")

            <div class="dsp--flex justify--between">
                <a href=" {{ route('recipes') }} " class="button m--3">Return to recipes</a>
                <!--Bouton modifier-->
            </div>

            <ul>
                @forelse($recipe->quantities as $ingredient)
                <li>{{ $ingredient->command->ingredient }} : 
                    {{ $ingredient->quantity }} {{ $ingredient->command->unit }}
                </li>
                
                @empty
                    Recipe has no ingredients 
                @endforelse
            </ul>
            <p> {!! nl2br($recipe->process) !!} </p>
        @else
            <h1 class="text--center">Add new recipe</h1>

            @include("partials.alert")

            <div class="dsp--flex justify--between">
                <a href=" {{ route('recipes') }} " class="button m--3">Return to recipes</a>
                <a href=" {{ route('recipe.add') }} " class="button m--3">Add to recipes</a>
            </div>

            <table class="element--center table--striped w--100">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--75">Ingredient</th>
                    <th class="w--25">Quantity</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="text--center p--1">
                            <select name="command_id"  aria-label="Ingredient (unit)" form="add_product_form" class="text--center input--inset" title="Ingredient (unit)" required autofocus>
                                @if(isset($commands_products) && $commands_products->count() > 0)
                                    <option value="" selected>Choose an ingredient and a unit</option>
                                    @foreach($commands_products as $commands_product)
                                        <option value="{{ $commands_product->id }}">{{ $commands_product->ingredient }} ({{ $commands_product->unit }})</option>
                                    @endforeach
                                @else
                                    <option value="" selected>No products available</option>
                                @endif
                            </select>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        @endif
    </main>
</div>
@endsection    
