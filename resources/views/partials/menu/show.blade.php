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
    @forelse ($moments as $moment => $moment_datas)
        @php
            //Divide back array moments_data into displayable moment and dishes
            $displayed_moment = $moment_datas[0];
            $moment_dishes = $moment_datas[1];
        @endphp
        <tr>
            <td class="text--center p--1">{{ $displayed_moment }}</td>
            <td class="p--1">
                <ul>
                    @foreach ($moment_dishes as $moment_dish)
                        <li>
                            <a href="{{ route('recipe.show', ['id' => $moment_dish->recipe]) }}" class="link">{{ $moment_dish->recipe->name }}</a>
                            (x {{ $moment_dish->portion }})
                        </li>
                    @endforeach
                </ul>
            </td>
        </tr> 
    @empty
        <tr>
            <td colspan="2" class="text--center p--1">
                There is no recipes for this menu
            </td>
        </tr>
    @endforelse
@endsection