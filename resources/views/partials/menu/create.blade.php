@section('title')
Add menu
@endsection

@section('buttons')
<a href=" {{ route('menus') }} " class="button m--3">Return to menus</a>
<button type="submit" form="add_menu_form" class="button m--3">Add menu</button>
@endsection

@section('forms')
<form method="POST" action=" {{ route('menu.add') }} " id="add_menu_form">
    @csrf
</form>
{{--Prepare select options for JS:--}}
<select name="select_recipe_options" id="select_recipe_options" hidden>
    @if(isset($recipes) && $recipes->count() > 0)
        <option value="" selected>Choose a recipe</option>
        @foreach($recipes as $recipe)
            <option value="{{ $recipe->id }}">{{ $recipe->name }}</option>
        @endforeach
    @else
        <option value="" selected>No recipe available</option>
    @endif
</select>
@endsection

@section('table')
<input type="date" name="day" aria-label="Menu date" min="2000-01-01" max="2300-01-01" form="add_menu_form" class="text--center input--inset my--2" placeholder="Menu date" value="{{ old('day') }}" required autofocus>
<table class="element--center table--striped w--100" id="add_menu_table">
    <thead class="w--100 bg--secondary text--light">
        <th class="w--60">Dishes</th>
        <th class="w--40" colspan="2">Number of portions</th>
    </thead>
    <tbody>
        @foreach ($moments as $moment => $displayed_moment)
            <th colspan="3" class="bg--secondary-fade text--light">{{ $displayed_moment }}</th>
            @php
                $moment_i = 1
            @endphp 
            {{--Check for old values--}}
            @if(old($moment) != null)
                @foreach (old($moment) as $moment_recipe)
                    <tr name="{{ $moment }}_recipe_row">
                        <td class="text--center p--1">
                            <select name="{{$moment}}[{{$moment_i}}][recipe]" id="recipe_{{ $moment }}_{{ $moment_i }}" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>
                                @if(isset($recipes) && $recipes->count() > 0)
                                    <option value="">Choose a recipe</option>
                                    @foreach($recipes as $recipe)
                                        <option value="{{ $recipe->id }}" {{ $moment_recipe['recipe'] == $recipe->id ? "selected" : "" }}>
                                            {{ $recipe->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" selected>No recipe available</option>
                                @endif
                            </select>
                        </td>
                        <td class="text--center p--1">
                            <input type="number" aria-label="Portions" min="0" name="{{$moment}}[{{$moment_i}}][portion]" value="{{ old( "{$moment}.{$moment_i}.portion" ) }}" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>
                        </td>
                        <td class="text--center p--1">
                            <button type="button" name="delete_row" id="delete_{{ $moment }}_row{{ $moment_i }}" class="button--sm">Delete row</button>
                        </td>
                    </tr>
                    @php
                        $moment_i ++;
                    @endphp
                @endforeach
            @else
                <tr name="{{ $moment }}_recipe_row">
                    <td class="text--center p--1">
                        <select name="{{$moment}}[{{$moment_i}}][recipe]" id="recipe_{{ $moment }}_{{ $moment_i}}" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>
                            @if(isset($recipes) && $recipes->count() > 0)
                                <option value="" selected>Choose a recipe</option>
                                @foreach($recipes as $recipe)
                                    <option value="{{ $recipe->id }}">{{ $recipe->name }}</option>
                                @endforeach
                            @else
                                <option value="" selected>No recipe available</option>
                            @endif
                        </select>
                    </td>
                    <td class="text--center p--1">
                        <input type="number" aria-label="Portions" min="0" name="{{$moment}}[{{$moment_i}}][portion]" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>
                    </td>
                    <td class="text--center p--1">
                        <button type="button" name="delete_row" id="delete_{{ $moment }}_row{{ $moment_i }}" class="button--sm">Delete row</button>
                    </td>
                </tr>
                @php
                    $moment_i ++;
                @endphp
            @endif
            <tr id="add_{{ $moment }}_recipe_row">
                <td colspan="3" class="text--center">
                    <button type="button" id="add_{{ $moment }}_recipe_button" data-moment="{{ $moment }}" class="button m--1">Add row</button>
                </td>
            </tr>
        @endforeach
  
    </tbody>
</table>
@endsection