@extends("layouts.app")

@if(isset($menu) && !isset($is_creating) && !isset($is_editing))
    @section('title')
        {{ $menu->day }} Menu
    @endsection

    @section('buttons')
        <a href=" {{ route('menus') }} " class="button m--3">Return to menus</a>
        <a href=" {{ route('recipe.modify', ['id' => $menu->id]) }} " class="button m--3">Modify menu</a>
    @endsection

    @section('forms')
        {{--empty--}}
    @endsection

    @section('table-head')
        <th class="w--40">Eating time</th>
        <th class="w--60">Dishes</th>
    @endsection
    @section('table-body')
        @isset($morning_recipes)
            <tr>
                <td class="text--center p--1">Breakfast</td>
                <td class="p--1">
                    <ul>
                        @foreach ($morning_recipes as $morning_recipe)
                            <li>{{$morning_recipe->name}}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>   
        @endisset
        @isset($noon_recipes)
            <tr>
                <td class="text--center p--1">Lunch</td>
                <td class="p--1">
                    <ul>
                        @foreach ($noon_recipes as $noon_recipe)
                            <li>{{$noon_recipe->name}}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>   
        @endisset
        @isset($evening_recipes)
            <tr>
                <td class="text--center p--1">Dinner</td>
                <td class="p--1">
                    <ul>
                        @foreach ($evening_recipes as $evening_recipe)
                            <li>{{$evening_recipe->name}}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>   
        @endisset
    @endsection
@endif