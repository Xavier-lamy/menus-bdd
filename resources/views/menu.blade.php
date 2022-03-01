@extends("layouts.app")

@if(isset($menu) && !isset($is_creating) && !isset($is_editing))
    @section('title')
        {{ $menu->day }} Menu
    @endsection

    @section('buttons')
        <a href=" {{ route('menus') }} " class="button m--3">Return to menus</a>
        <a href=" {{ route('menu.modify', ['id' => $menu->id]) }} " class="button m--3">Modify menu</a>
    @endsection

    @section('forms')
        {{--empty--}}
    @endsection

    @section('table-head')
        <th class="w--40">Eating time</th>
        <th class="w--60">Dishes</th>
    @endsection
    @section('table-body')
        @isset($morning_dishes)
            <tr>
                <td class="text--center p--1">Breakfast</td>
                <td class="p--1">
                    <ul>
                        @foreach ($morning_dishes as $morning_dish)
                            <li>
                                <a href="{{ route('recipe.show', ['id' => $morning_dish->recipe]) }}" class="link">{{ $morning_dish->recipe->name }}</a>
                                 (x {{ $morning_dish->portion }})
                            </li>
                        @endforeach
                    </ul>
                </td>
            </tr>   
        @endisset
        @isset($noon_dishes)
            <tr>
                <td class="text--center p--1">Lunch</td>
                <td class="p--1">
                    <ul>
                        @foreach ($noon_dishes as $noon_dish)
                            <li>
                                <a href="{{ route('recipe.show', ['id' => $noon_dish->recipe]) }}" class="link">{{ $noon_dish->recipe->name }}</a>
                                (x {{ $noon_dish->portion }})
                            </li>
                        @endforeach
                    </ul>
                </td>
            </tr>   
        @endisset
        @isset($evening_dishes)
            <tr>
                <td class="text--center p--1">Dinner</td>
                <td class="p--1">
                    <ul>
                        @foreach ($evening_dishes as $evening_dish)
                            <li>
                                <a href="{{ route('recipe.show', ['id' => $evening_dish->recipe]) }}" class="link">{{ $evening_dish->recipe->name }}</a>
                                (x {{ $evening_dish->portion }})
                            </li>
                        @endforeach
                    </ul>
                </td>
            </tr>   
        @endisset
    @endsection

@elseif(isset($is_editing))
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
                <th colspan="3" class="bg--secondary-fade text--light">Breakfast</th>
                @php
                    $morning_i = 1;
                @endphp 
                {{--Display old values from failed redirection or values from menu--}}
                @if(old('morning') != null)
                    @forelse (old('morning') as $morning_dish)
                        <tr name="morning_recipe_row">
                            <td class="text--center p--1">
                                <select name="morning[{{$morning_i}}][recipe]" id="recipe_morning{{$morning_i}}" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>
                                    @if(isset($recipes) && $recipes->count() > 0)
                                        <option value="">Choose a recipe</option>
                                        @foreach($recipes as $recipe)
                                            <option value="{{ $recipe->id }}" {{ $morning_dish['recipe'] == $recipe->id ? "selected" : "" }}>
                                                {{ $recipe->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" selected>No recipe available</option>
                                    @endif
                                </select>
                            </td>
                            <td class="text--center p--1">
                                <input type="number" aria-label="Portions" min="0" name="morning[{{ $morning_i }}][portion]" value="{{ old("morning.". $morning_i .".portion") }}" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>
                                <input type="hidden" name="morning[{{ $morning_i }}][id]" value="{{ old("morning.". $morning_i .".id") }}" form="update_menu_form" required>
                            </td>
                            <td class="text--center p--1">
                                <button type="button" name="delete_row" id="delete_morning_row{{ $morning_i }}" class="button--sm">Delete row</button>
                            </td>
                        </tr>
                        @php
                            $morning_i ++;
                        @endphp
                    @empty
                        {{--display nothing if empty--}}
                    @endforelse
                @else
                    @forelse($morning_dishes as $morning_dish)
                        <tr name="morning_recipe_row">
                            <td class="text--center p--1">
                                <select name="morning[{{$morning_i}}][recipe]" id="recipe_morning{{$morning_i}}" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>
                                    @if(isset($recipes) && $recipes->count() > 0)
                                        <option value="">Choose a recipe</option>
                                        @foreach($recipes as $recipe)
                                            <option value="{{ $recipe->id }}" {{ $morning_dish->recipe->id == $recipe->id ? "selected" : "" }}>
                                                {{ $recipe->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" selected>No recipe available</option>
                                    @endif
                                </select>
                            </td>
                            <td class="text--center p--1">
                                <input type="number" aria-label="Portions" min="0" name="morning[{{ $morning_i }}][portion]" value="{{ $morning_dish->portion }}" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>
                                <input type="hidden" name="morning[{{ $morning_i }}][id]" value="{{ $morning_dish->id }}" form="update_menu_form" required>
                            </td>
                            <td class="text--center p--1">
                                <button type="button" name="delete_row" id="delete_morning_row{{ $morning_i }}" class="button--sm">Delete row</button>
                            </td>
                        </tr>
                        @php
                            $morning_i ++;
                        @endphp
                    @empty
                        {{--display nothing if empty--}}
                    @endforelse
                @endif
                <tr id="add_morning_recipe_row">
                    <td colspan="3" class="text--center">
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
                        <button type="button" id="add_morning_recipe_button" class="button m--1">Add row</button>
                    </td>
                </tr>

                <th colspan="3" class="bg--secondary-fade text--light">Lunch</th>   
                @php
                    $noon_i = 1;
                @endphp
                {{--Display old values from failed redirection or values from menu--}}
                @if(old('noon') != null)
                    @forelse (old('noon') as $noon_dish)
                        <tr name="noon_recipe_row">
                            <td class="text--center p--1">
                                <select name="noon[{{$noon_i}}][recipe]" id="recipe_noon{{$noon_i}}" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>
                                    @if(isset($recipes) && $recipes->count() > 0)
                                        <option value="">Choose a recipe</option>
                                        @foreach($recipes as $recipe)
                                            <option value="{{ $recipe->id }}" {{ $noon_dish['recipe'] == $recipe->id ? "selected" : "" }}>
                                                {{ $recipe->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" selected>No recipe available</option>
                                    @endif
                                </select>
                            </td>
                            <td class="text--center p--1">
                                <input type="number" aria-label="Portions" min="0" name="noon[{{ $noon_i }}][portion]" value="{{ old("noon.". $noon_i .".portion") }}" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>
                                <input type="hidden" name="noon[{{ $noon_i }}][id]" value="{{ old("noon.". $noon_i .".id") }}" form="update_menu_form" required>
                            </td>
                            <td class="text--center p--1">
                                <button type="button" name="delete_row" id="delete_noon_row{{ $noon_i }}" class="button--sm">Delete row</button>
                            </td>
                        </tr>
                        @php
                            $noon_i ++;
                        @endphp
                    @empty
                        {{--display nothing if empty--}}
                    @endforelse
                @else
                    @forelse($noon_dishes as $noon_dish)
                        <tr name="noon_recipe_row">
                            <td class="text--center p--1">
                                <select name="noon[{{$noon_i}}][recipe]" id="recipe_noon{{$noon_i}}" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>
                                    @if(isset($recipes) && $recipes->count() > 0)
                                        <option value="">Choose a recipe</option>
                                        @foreach($recipes as $recipe)
                                            <option value="{{ $recipe->id }}" {{ $noon_dish->recipe->id == $recipe->id ? "selected" : "" }}>
                                                {{ $recipe->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" selected>No recipe available</option>
                                    @endif
                                </select>
                            </td>
                            <td class="text--center p--1">
                                <input type="number" aria-label="Portions" min="0" name="noon[{{ $noon_i }}][portion]" value="{{ $noon_dish->portion }}" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>
                                <input type="hidden" name="noon[{{ $noon_i }}][id]" value="{{ $noon_dish->id }}" form="update_menu_form" required></td>
                            <td class="text--center p--1">
                                <button type="button" name="delete_row" id="delete_noon_row{{ $noon_i }}" class="button--sm">Delete row</button>
                            </td>
                        </tr>
                        @php
                            $noon_i ++;
                        @endphp
                    @empty
                        {{--display nothing if empty--}}
                    @endforelse
                @endif
                <tr id="add_noon_recipe_row">
                    <td colspan="3" class="text--center">
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
                        <button type="button" id="add_noon_recipe_button" class="button m--1">Add row</button>
                    </td>
                </tr>

                <th colspan="3" class="bg--secondary-fade text--light">Dinner</th> 
                @php
                    $evening_i = 1;
                @endphp
                {{--Display old values from failed redirection or values from menu--}}
                @if(old('evening') != null)
                    @forelse (old('evening') as $evening_dish)
                        <tr name="evening_recipe_row">
                            <td class="text--center p--1">
                                <select name="evening[{{$evening_i}}][recipe]" id="recipe_evening{{$evening_i}}" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>
                                    @if(isset($recipes) && $recipes->count() > 0)
                                        <option value="">Choose a recipe</option>
                                        @foreach($recipes as $recipe)
                                            <option value="{{ $recipe->id }}" {{ $evening_dish['recipe'] == $recipe->id ? "selected" : "" }}>
                                                {{ $recipe->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" selected>No recipe available</option>
                                    @endif
                                </select>
                            </td>
                            <td class="text--center p--1">
                                <input type="number" aria-label="Portions" min="0" name="evening[{{ $evening_i }}][portion]" value="{{ old("evening.". $evening_i .".portion") }}" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>
                                <input type="hidden" name="evening[{{ $evening_i }}][id]" value="{{ old("evening.". $evening_i .".id") }}" form="update_menu_form" required>
                            </td>
                            <td class="text--center p--1">
                                <button type="button" name="delete_row" id="delete_evening_row{{ $evening_i }}" class="button--sm">Delete row</button>
                            </td>
                        </tr>
                        @php
                            $evening_i ++;
                        @endphp
                    @empty
                        {{--display nothing if empty--}}
                    @endforelse
                @else
                    @forelse($evening_dishes as $evening_dish)
                        <tr name="evening_recipe_row">
                            <td class="text--center p--1">
                                <select name="evening[{{$evening_i}}][recipe]" id="recipe_evening{{$evening_i}}" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>
                                    @if(isset($recipes) && $recipes->count() > 0)
                                        <option value="">Choose a recipe</option>
                                        @foreach($recipes as $recipe)
                                            <option value="{{ $recipe->id }}" {{ $evening_dish->recipe->id == $recipe->id ? "selected" : "" }}>
                                                {{ $recipe->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" selected>No recipe available</option>
                                    @endif
                                </select>
                            </td>
                            <td class="text--center p--1">
                                <input type="number" aria-label="Portions" min="0" name="evening[{{ $evening_i }}][portion]" value="{{ $evening_dish->portion }}" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>
                                <input type="hidden" name="evening[{{ $evening_i }}][id]" value="{{ $evening_dish->id }}" form="update_menu_form" required></td>
                            </td>
                            <td class="text--center p--1">
                                <button type="button" name="delete_row" id="delete_evening_row{{ $evening_i }}" class="button--sm">Delete row</button>
                            </td>
                        </tr>
                        @php
                            $evening_i ++;
                        @endphp
                    @empty
                        {{--display nothing if empty--}}
                    @endforelse
                @endif
                <tr id="add_evening_recipe_row">
                    <td colspan="3" class="text--center">
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
                        <button type="button" id="add_evening_recipe_button" class="button m--1">Add row</button>
                    </td>
                </tr>
            </tbody>
        </table>
    @endsection

@else 
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
    @endsection

    @section('table')
        <input type="date" name="day" aria-label="Menu date" min="2000-01-01" max="2300-01-01" form="add_menu_form" class="text--center input--inset my--2" placeholder="Menu date" value="{{ old('day') }}" required autofocus>
        <table class="element--center table--striped w--100" id="add_menu_table">
            <thead class="w--100 bg--secondary text--light">
                <th class="w--60">Dishes</th>
                <th class="w--40" colspan="2">Number of portions</th>
            </thead>
            <tbody>
                <th colspan="3" class="bg--secondary-fade text--light">Breakfast</th>
                @php
                    $morning_i = 1;
                @endphp
                {{--Check for old values--}}
                @if(old('morning') != null)
                    @foreach (old('morning') as $morning_recipe)
                        <tr name="morning_recipe_row">
                            <td class="text--center p--1">
                                <select name="morning[{{$morning_i}}][recipe]" id="recipe_morning{{$morning_i}}" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>
                                    @if(isset($recipes) && $recipes->count() > 0)
                                        <option value="">Choose a recipe</option>
                                        @foreach($recipes as $recipe)
                                            <option value="{{ $recipe->id }}" {{ $morning_recipe['recipe'] == $recipe->id ? "selected" : "" }}>
                                                {{ $recipe->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" selected>No recipe available</option>
                                    @endif
                                </select>
                            </td>
                            <td class="text--center p--1">
                                <input type="number" aria-label="Portions" min="0" name="morning[{{ $morning_i }}][portion]" value="{{ old("morning.". $morning_i .".portion") }}" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>
                            </td>
                            <td class="text--center p--1">
                                <button type="button" name="delete_row" id="delete_morning_row{{ $morning_i }}" class="button--sm">Delete row</button>
                            </td>
                        </tr>
                        @php
                            $morning_i ++;
                        @endphp
                    @endforeach
                @else
                    <tr name="morning_recipe_row">
                        <td class="text--center p--1">
                            <select name="morning[{{$morning_i}}][recipe]" id="recipe_morning{{$morning_i}}" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>
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
                            <input type="number" aria-label="Portions" min="0" name="morning[{{ $morning_i }}][portion]" value="{{ old("morning.". $morning_i .".portion") }}" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>
                        </td>
                        <td class="text--center p--1">
                            <button type="button" name="delete_row" id="delete_morning_row{{ $morning_i }}" class="button--sm">Delete row</button>
                        </td>
                    </tr>
                    @php
                        $morning_i ++;
                    @endphp
                @endif
                <tr id="add_morning_recipe_row">
                    <td colspan="3" class="text--center">
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
                        <button type="button" id="add_morning_recipe_button" class="button m--1">Add row</button>
                    </td>
                </tr>

                <th colspan="3" class="bg--secondary-fade text--light">Lunch</th>   
                @php
                    $noon_i = 1;
                @endphp
                {{--Check for old values--}}
                @if(old('noon') != null)
                    @foreach (old('noon') as $noon_recipe)
                        <tr name="noon_recipe_row">
                            <td class="text--center p--1">
                                <select name="noon[{{$noon_i}}][recipe]" id="recipe_noon{{$noon_i}}" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>
                                    @if(isset($recipes) && $recipes->count() > 0)
                                        <option value="">Choose a recipe</option>
                                        @foreach($recipes as $recipe)
                                            <option value="{{ $recipe->id }}" {{ $noon_recipe['recipe'] == $recipe->id ? "selected" : "" }}>
                                                {{ $recipe->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" selected>No recipe available</option>
                                    @endif
                                </select>
                            </td>
                            <td class="text--center p--1">
                                <input type="number" aria-label="Portions" min="0" name="noon[{{ $noon_i }}][portion]" value="{{ old("noon.". $noon_i .".portion") }}" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>
                            </td>
                            <td class="text--center p--1">
                                <button type="button" name="delete_row" id="delete_noon_row{{ $noon_i }}" class="button--sm">Delete row</button>
                            </td>
                        </tr>
                        @php
                            $noon_i ++;
                        @endphp
                    @endforeach
                @else
                    <tr name="noon_recipe_row">
                        <td class="text--center p--1">
                            <select name="noon[{{$noon_i}}][recipe]" id="recipe_noon{{$noon_i}}" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe">
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
                            <input type="number" aria-label="Portions" min="0" name="noon[{{ $noon_i }}][portion]" value="{{ old("noon.". $noon_i .".portion") }}" form="add_menu_form" class="text--center input--inset" placeholder="Portions">
                        </td>
                        <td class="text--center p--1">
                            <button type="button" name="delete_row" id="delete_noon_row{{ $noon_i }}" class="button--sm">Delete row</button>
                        </td>
                    </tr>
                    @php
                        $noon_i ++;
                    @endphp
                @endif
                <tr id="add_noon_recipe_row">
                    <td colspan="3" class="text--center">
                        <button type="button" id="add_noon_recipe_button" class="button m--1">Add row</button>
                    </td>
                </tr> 
                <th colspan="3" class="bg--secondary-fade text--light">Dinner</th> 
                @php
                    $evening_i = 1;
                @endphp
                {{--Check for old values--}}
                @if(old('evening') != null)
                    @foreach (old('evening') as $evening_recipe)
                        <tr name="evening_recipe_row">
                            <td class="text--center p--1">
                                <select name="evening[{{$evening_i}}][recipe]" id="recipe_evening{{$evening_i}}" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe">
                                    @if(isset($recipes) && $recipes->count() > 0)
                                        <option value="">Choose a recipe</option>
                                        @foreach($recipes as $recipe)
                                            <option value="{{ $recipe->id }}" {{ $evening_recipe['recipe'] == $recipe->id ? "selected" : "" }}>
                                                {{ $recipe->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" selected>No recipe available</option>
                                    @endif
                                </select>
                            </td>
                            <td class="text--center p--1">
                                <input type="number" aria-label="Portions" min="0" name="evening[{{ $evening_i }}][portion]" value="{{ old("evening.". $evening_i .".portion") }}" form="add_menu_form" class="text--center input--inset" placeholder="Portions">
                            </td>
                            <td class="text--center p--1">
                                <button type="button" name="delete_row" id="delete_evening_row{{ $evening_i }}" class="button--sm">Delete row</button>
                            </td>
                        </tr>
                        @php
                            $evening_i ++;
                        @endphp
                    @endforeach
                @else
                    <tr name="evening_recipe_row">
                        <td class="text--center p--1">
                            <select name="evening[{{$evening_i}}][recipe]" id="recipe_evening{{$evening_i}}" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe">
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
                            <input type="number" aria-label="Portions" min="0" name="evening[{{ $evening_i }}][portion]" value="{{ old("evening.". $evening_i .".portion") }}" form="add_menu_form" class="text--center input--inset" placeholder="Portions">
                        </td>
                        <td class="text--center p--1">
                            <button type="button" name="delete_row" id="delete_evening_row{{ $evening_i }}" class="button--sm">Delete row</button>
                        </td>
                    </tr>
                    @php
                        $evening_i ++;
                    @endphp
                @endif
                <tr id="add_evening_recipe_row">
                    <td colspan="3" class="text--center">
                        <button type="button" id="add_evening_recipe_button" class="button m--1">Add row</button>
                    </td>
                </tr>    
            </tbody>
        </table>
    @endsection

@endif