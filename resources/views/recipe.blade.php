@extends("layouts.app")

@section("wrapper")
<div class="wrapper">
    <main class="element--center w--60 _mob_w--100">
        @if(!empty($recipe) && !isset($is_creating))
            <h1 class="text--center">{{ $recipe->name }}</h1>
            <div class="dsp--flex justify--between">
                <a href=" {{ route('recipes') }} " class="button m--3">Return to recipes</a>
                <!--Bouton modifier-->
            </div>
            
            @include("partials.alert")

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
            <div class="dsp--flex justify--between">
                <a href=" {{ route('recipes') }} " class="button m--3">Return to recipes</a>
            </div>
            
            @include("partials.alert")

            <form method="POST" action=" {{ route('recipe.add') }} " id="add_recipe_form">
                @csrf
            </form>
            <input type="text" name="recipe_name" aria-label="Recipe quantity" form="add_recipe_form" class="text--center input--inset my--2" placeholder="Recipe name" required autofocus>
            <table class="element--center table--striped w--100" id="addRecipeTable">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--60">Ingredient</th>
                    <th colspan="2" class="w--40">Quantity</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="text--center p--1">
                            <select name="ingredient[1][command_id]" id="ingredient_id_1" aria-label="Ingredient (unit)" form="add_recipe_form" class="text--center input--inset" title="Ingredient (unit)" required>
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
                        <td  class="text--center p--1">
                            <input type="number" aria-label="Quantity" min="0" name="ingredient[1][quantity]" form="add_recipe_form" class="text--center input--inset" placeholder="Quantity" required>
                        </td>
                        <td class="text--center p--1">
                            <button type="button" name="deleteRow" id="deleteRow1" class="button--sm">Delete row</button>
                        </td>
                    </tr>
                    <tr id="addIngredientRow">
                        <td colspan="3" class="text--center">
                            <button type="button" id="addIngredientButton" class="button m--1">Add ingredient</button>
                        </td>
                    </tr>
                    <th colspan="3" class="bg--secondary text--light">Method</th>
                    <tr>
                        <td colspan="3">
                            <textarea name="recipe_method" cols="30" rows="10" form="add_recipe_form" class="textarea--inset" placeholder="Enter method here" required></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="dsp--flex justify--center">
                <button type="submit" form="add_recipe_form" class="button m--3">Add recipe</button>
            </div>
        @endif
    </main>
</div>
@endsection    
