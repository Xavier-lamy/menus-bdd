@extends("layouts.app")

@section("wrapper")
<div class="wrapper">
    <main class="element--center w--60 _mob_w--100">
        @if(!empty($recipe) && !isset($is_creating) && !isset($is_editing))
            <h1 class="text--center">{{ $recipe->name }}</h1>
            <div class="dsp--flex justify--between">
                <a href=" {{ route('recipes') }} " class="button m--3">Return to recipes</a>
                <a href=" {{ route('recipe.modify', ['id' => $recipe->id]) }} " class="button m--3">Modify</a>
            </div>
            
            @include("partials.alert")

            <table class="element--center table--striped w--100">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--60">Ingredient</th>
                    <th class="w--40">Quantity</th>
                </thead>
                <tbody>
                    @forelse($recipe->quantities as $ingredient)
                        <tr>
                            <td class="text--center p--1">{{ $ingredient->command->ingredient }}</td>
                            <td class="text--center p--1">{{ $ingredient->quantity }} {{ $ingredient->command->unit }}</td>
                        </tr> 
                    @empty
                       <tr>
                           <td colspan="2" class="text--center p--1">Recipe has no ingredients</td>
                        </tr>  
                    @endforelse
                    @if(isset($ingredient))
                        <tr>
                            <td class="text--center p--1 fw--bold">Total weight</td>
                            <td class="text--center p--1 fw--bold">{{ $recipe->total_weight }} {{ $ingredient->command->unit }}</td>
                        </tr>
                    @endif
                    <th colspan="2" class="bg--secondary text--light">Method</th>
                    <tr>
                        <td colspan="2">
                            <p class="mx--3 my--1">{!! nl2br($recipe->process) !!}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        @elseif(isset($is_editing))
            <h1 class="text--center">Modify recipe</h1>
            <p class="alert--message my--2 p--2">
                In order to count recipe total weight, all ingredients should use same unit.
            </p>
            <div class="dsp--flex justify--between">
                <a href=" {{ route('recipes') }} " class="button m--3">Return to recipes</a>
            </div>
            
            @include("partials.alert")

            <form method="POST" action=" {{ route('recipe.apply') }} " id="update_recipe_form">
                @csrf
            </form>
            <input type="text" name="recipe_name" aria-label="Recipe quantity" min="1" max="120" form="update_recipe_form" class="text--center input--inset my--2" placeholder="Recipe name" value="{{ $recipe->name }}" required autofocus>
            <table class="element--center table--striped w--100" id="modifyRecipeTable">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--60">Ingredient</th>
                    <th colspan="2" class="w--40">Quantity</th>
                </thead>
                <tbody>
                    @php
                        $i = 1; 
                    @endphp
                    @forelse ($recipe->quantities as $ingredient)
                        <tr name="ingredientRow">
                            <td class="text--center p--1">
                                <select name="ingredient[{{ $i }}][command_id]" id="ingredient_id_{{ $i }}" aria-label="Ingredient (unit)" form="update_recipe_form" class="text--center input--inset" title="Ingredient (unit)" required>
                                    @if(isset($commands_products) && $commands_products->count() > 0)
                                        <option value="">Choose an ingredient and a unit</option>
                                        @foreach($commands_products as $commands_product)
                                            @if($ingredient->command_id == $commands_product->id )
                                                <option value="{{ $commands_product->id }}" selected>{{ $commands_product->ingredient }} ({{ $commands_product->unit }})</option>
                                            @else 
                                                <option value="{{ $commands_product->id }}">{{ $commands_product->ingredient }} ({{ $commands_product->unit }})</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value="" selected>No products available</option>
                                    @endif
                                </select>
                            </td>
                            <td  class="text--center p--1">
                                <input type="number" aria-label="Quantity" min="0" name="ingredient[{{ $i }}][quantity]" value="{{ $ingredient->quantity }}" form="update_recipe_form" class="text--center input--inset" placeholder="Quantity" required>
                            </td>
                            <td class="text--center p--1">
                                <button type="button" name="deleteRow" id="deleteRow{{ $i }}" class="button--sm">Delete row</button>
                            </td>
                        </tr>
                        @php
                            $i ++;
                        @endphp
                    @empty
                        <tr name="ingredientRow">
                           <td colspan="2" class="text--center p--1">Recipe has no ingredients</td>
                        </tr> 
                    @endforelse
                    <tr id="addIngredientRow">
                        <td colspan="3" class="text--center">
                            <select name="selectIngredientOptions" id="selectIngredientOptions" hidden>
                                @if(isset($commands_products) && $commands_products->count() > 0)
                                    <option value="" selected>Choose an ingredient and a unit</option>
                                    @foreach($commands_products as $commands_product)
                                        <option value="{{ $commands_product->id }}">{{ $commands_product->ingredient }} ({{ $commands_product->unit }})</option>
                                    @endforeach
                                @else
                                    <option value="" selected>No products available</option>
                                @endif
                            </select>
                            <button type="button" id="addIngredientButton" class="button m--1">Add ingredient</button>
                        </td>
                    </tr>
                    <th colspan="3" class="bg--secondary text--light">Method</th>
                    <tr>
                        <td colspan="3">
                            <textarea name="process" cols="30" rows="10" form="update_recipe_form" class="textarea--inset" placeholder="Enter method here" required>{{ $recipe->process }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="dsp--flex justify--center">
                <input type="hidden" name="id" form="update_recipe_form" value="{{ $recipe->id }}" required>
                <button type="submit" form="update_recipe_form" class="button m--3">Update recipe</button>
            </div>
        @else
            <h1 class="text--center">Add new recipe</h1>
            <p class="alert--message my--2 p--2">
                In order to count recipe total weight, all ingredients should use same unit.
            </p>
            <div class="dsp--flex justify--between">
                <a href=" {{ route('recipes') }} " class="button m--3">Return to recipes</a>
            </div>
            
            @include("partials.alert")

            <form method="POST" action=" {{ route('recipe.add') }} " id="add_recipe_form">
                @csrf
            </form>
            <input type="text" name="recipe_name" aria-label="Recipe quantity" min="1" max="120" form="add_recipe_form" class="text--center input--inset my--2" placeholder="Recipe name" value="{{ old('recipe_name') }}" required autofocus>
            <table class="element--center table--striped w--100" id="addRecipeTable">
                <thead class="w--100 bg--secondary text--light">
                    <th class="w--60">Ingredient</th>
                    <th colspan="2" class="w--40">Quantity</th>
                </thead>
                <tbody>
                    <tr name="ingredientRow">
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
                            <select name="selectIngredientOptions" id="selectIngredientOptions" hidden>
                                @if(isset($commands_products) && $commands_products->count() > 0)
                                    <option value="" selected>Choose an ingredient and a unit</option>
                                    @foreach($commands_products as $commands_product)
                                        <option value="{{ $commands_product->id }}">{{ $commands_product->ingredient }} ({{ $commands_product->unit }})</option>
                                    @endforeach
                                @else
                                    <option value="" selected>No products available</option>
                                @endif
                            </select>
                            <button type="button" id="addIngredientButton" class="button m--1">Add ingredient</button>
                        </td>
                    </tr>
                    <th colspan="3" class="bg--secondary text--light">Method</th>
                    <tr>
                        <td colspan="3">
                            <textarea name="process" cols="30" rows="10" form="add_recipe_form" class="textarea--inset" placeholder="Enter method here" required>{{ old('process') }}</textarea>
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
