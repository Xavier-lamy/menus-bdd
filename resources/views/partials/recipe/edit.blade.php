@section('title')
Modify recipe
@endsection

@section('buttons')
<a href=" {{ route('recipes') }} " class="button m--3">Return to recipes</a>
@endsection

@section('alert')
<p class="alert--message my--2 p--2">In order to count recipe total weight, all ingredients should use same unit.</p>
@parent
@endsection

@section('forms')
<form method="POST" action=" {{ route('recipe.apply') }} " id="update_recipe_form">
    @csrf
</form>
@endsection

@section('table')
<input type="text" name="recipe_name" aria-label="Recipe name" min="1" max="120" form="update_recipe_form" class="text--center input--inset my--2" placeholder="Recipe name" value="{{ old('recipe_name') ?? $recipe->name }}" required autofocus>
<table class="element--center table--striped w--100" id="modify_recipe_table">
    <thead class="w--100 bg--secondary text--light">
        <th class="w--60">Ingredient</th>
        <th colspan="2" class="w--40">Quantity</th>
    </thead>
    {{--Return all ingredient rows--}} 
    <tbody>
        @php
            $i = 1; 
        @endphp
        {{--Use nullish coalescing operator to check if values from previous failed validation exist, if they don't then return current recipe values--}}
        @forelse ((old('ingredient') ?? $recipe->quantities) as $ingredient)
            <tr name="ingredient_row">
                <td class="text--center p--1">
                    <select name="ingredient[{{ $i }}][command_id]" id="ingredient_id_{{ $i }}" aria-label="Ingredient (unit)" form="update_recipe_form" class="text--center input--inset" title="Ingredient (unit)" required>
                        @if(isset($commands_products) && $commands_products->count() > 0)
                            <option value="">
                                Choose an ingredient and a unit
                            </option>
                            @foreach($commands_products as $commands_product)
                                @if(old('ingredient.'. $i .'.command_id') == $commands_product->id)
                                    <option value="{{ $commands_product->id }}" selected>
                                        {{ $commands_product->ingredient }} ({{ $commands_product->unit }})
                                    </option>
                                @elseif(($ingredient['command_id'] ?? $ingredient->command_id) == $commands_product->id )
                                    <option value="{{ $commands_product->id }}" {{ old('ingredient.'. $i .'.command_id') == null ? "selected" : "" }}>
                                        {{ $commands_product->ingredient }} ({{ $commands_product->unit }})
                                    </option>
                                @else 
                                    <option value="{{ $commands_product->id }}">
                                        {{ $commands_product->ingredient }} ({{ $commands_product->unit }})
                                    </option>
                                @endif
                            @endforeach
                        @else
                            <option value="" selected>No products available</option>
                        @endif
                    </select>
                </td>
                <td  class="text--center p--1">
                    <input type="number" aria-label="Quantity" min="0" name="ingredient[{{ $i }}][quantity]" value="{{ old("ingredient.". $i .".quantity") ?? $ingredient->quantity }}" form="update_recipe_form" class="text--center input--inset" placeholder="Quantity" required>
                </td>
                <td class="text--center p--1">
                    <button type="button" name="delete_row" id="delete_row{{ $i }}" class="button--sm">Delete row</button>
                </td>
            </tr>
            @php
                $i ++;
            @endphp
        @empty
            <tr name="ingredient_row">
                <td colspan="2" class="text--center p--1">Recipe has no ingredients</td>
            </tr> 
        @endforelse
        <tr id="add_ingredient_row">
            <td colspan="3" class="text--center">
                <select name="select_ingredient_options" id="select_ingredient_options" hidden>
                    @if(isset($commands_products) && $commands_products->count() > 0)
                        <option value="" selected>Choose an ingredient and a unit</option>
                        @foreach($commands_products as $commands_product)
                            <option value="{{ $commands_product->id }}">{{ $commands_product->ingredient }} ({{ $commands_product->unit }})</option>
                        @endforeach
                    @else
                        <option value="" selected>No products available</option>
                    @endif
                </select>
                <button type="button" id="add_ingredient_button" class="button m--1">Add ingredient</button>
            </td>
        </tr>
        <th colspan="3" class="bg--secondary text--light">Method</th>
        <tr>
            <td colspan="3">
                <textarea name="process" cols="30" rows="10" form="update_recipe_form" class="textarea--inset" placeholder="Enter method here" required>{{ old('process') ?? $recipe->process }}</textarea>
            </td>
        </tr>
    </tbody>
</table>
<div class="dsp--flex justify--center">
    <input type="hidden" name="id" form="update_recipe_form" value="{{ $recipe->id }}" required>
    <button type="submit" form="update_recipe_form" class="button m--3">Update recipe</button>
</div>
@endsection