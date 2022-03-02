@section('title')
Modify Menu
@endsection

@section('buttons')
<a href=" {{ route('menus') }} " class="button m--3">Return to menus</a>
<button type="submit" form="update_menu_form" class="button m--3">Update menu</button>
@endsection

@section('forms')
<form method="POST" action=" {{ route('menu.apply', ['id' => $menu->id]) }} " id="update_menu_form">
    @csrf
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
</form>
@endsection

@section('table')
<input type="date" name="day" aria-label="Menu date" min="2000-01-01" max="2300-01-01" form="update_menu_form" class="text--center input--inset my--2" placeholder="Menu date" value="{{ old('day') ?? $menu->day }}" required autofocus>
<table class="element--center table--striped w--100" id="modify_menu_table">
    <thead class="w--100 bg--secondary text--light">
        <th class="w--60">Dishes</th>
        <th class="w--40" colspan="2">Number of portions</th>
    </thead>
    <tbody>
    @foreach($moments as $moment => $moment_datas)
        @php
            //Divide back array moments_data into displayable moment and dishes
            $displayed_moment = $moment_datas[0];
            $moment_dishes = $moment_datas[1];
            $moment_i = 1; 
        @endphp
        <th colspan="3" class="bg--secondary-fade text--light">{{ $displayed_moment }}</th>
        {{--Display old values from failed redirection or values from menu--}}
        @if(old($moment) != null)
            @forelse (old($moment) as $moment_dish)
                <tr name="{{ $moment }}_recipe_row">
                    <td class="text--center p--1">
                        <select name="{{$moment}}[{{$moment_i}}][recipe]" id="recipe_{{ $moment }}_{{ $moment_i }}" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>
                            @if(isset($recipes) && $recipes->count() > 0)
                                <option value="">Choose a recipe</option>
                                @foreach($recipes as $recipe)
                                    <option value="{{ $recipe->id }}" {{ $moment_dish['recipe'] == $recipe->id ? "selected" : "" }}>
                                        {{ $recipe->name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" selected>No recipe available</option>
                            @endif
                        </select>
                    </td>
                    <td class="text--center p--1">
                        <input type="number" aria-label="Portions" min="0" name="{{$moment}}[{{$moment_i}}][portion]" value="{{ old( "{$moment}.{$moment_i}.portion") }}" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>
                        <input type="hidden" name="{{$moment}}[{{$moment_i}}][id]" value="{{ old( "{$moment}.{$moment_i}.id") }}" form="update_menu_form" required>
                    </td>
                    <td class="text--center p--1">
                        <button type="button" name="delete_row" id="delete_{{ $moment }}_row{{ $moment_i }}" class="button--sm">Delete row</button>
                    </td>
                </tr>
                @php
                    $moment_i ++;
                @endphp
            @empty
                {{--display nothing if empty--}}
            @endforelse
        @else
            @forelse($moment_dishes as $moment_dish)
                <tr name="{{ $moment }}_recipe_row">
                    <td class="text--center p--1">
                        <select name="[recipe]" id="recipe_{{ $moment }}_{{ $moment_i }}" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>
                            @if(isset($recipes) && $recipes->count() > 0)
                                <option value="">Choose a recipe</option>
                                @foreach($recipes as $recipe)
                                    <option value="{{ $recipe->id }}" {{ $moment_dish->recipe->id == $recipe->id ? "selected" : "" }}>
                                        {{ $recipe->name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" selected>No recipe available</option>
                            @endif
                        </select>
                    </td>
                    <td class="text--center p--1">
                        <input type="number" aria-label="Portions" min="0" name="{{$moment}}[{{$moment_i}}][portion]" value="{{ $moment_dish->portion }}" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>
                        <input type="hidden" name="{{$moment}}[{{$moment_i}}][id]" value="{{ $moment_dish->id }}" form="update_menu_form" required>
                    </td>
                    <td class="text--center p--1">
                        <button type="button" name="delete_row" id="delete_{{ $moment }}_row{{ $moment_i }}" class="button--sm">Delete row</button>
                    </td>
                </tr>
                @php
                    $moment_i ++;
                @endphp
            @empty
                {{--display nothing if empty--}}
            @endforelse
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