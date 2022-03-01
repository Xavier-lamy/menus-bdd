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