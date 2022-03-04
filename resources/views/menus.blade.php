@extends("layouts.app")

    @section('title')
        Menus
    @endsection

    @section('buttons')
        <a href=" {{ route('menu.create') }} " class="button m--3">Add a new menu</a>
        <button type="submit" form="delete_menu_form" class="button m--3">Delete selection</button>
    @endsection

    @section('forms')
        <form method="POST" action=" {{ route('menu-delete-confirmation') }} " id="delete_menu_form">
            @csrf
        </form>
    @endsection

    @section('table-head')
        <th class="w--60">Menu date</th>
        <th class="w--40">Modifications</th>
    @endsection
    @section('table-body')
        @forelse($menus as $menu)
            <tr>
                <td class="text--center p--1">{{ $menu->day }} menu</td>
                <td class="text--center p--1">
                    <a href=" {{ route('menu.show', ['id' => $menu->id]) }} " class="button--sm">Details</a>
                    <input type="checkbox" id="{{ $menu->id }}" name="delete_{{ $menu->id }}" form="delete_menu_form" value="{{ $menu->id }}">
                </td>
            </tr>
        @empty 
            <tr>
                <td colspan="2" class="text--center">No menus available</td>
            </tr>
        @endforelse
    @endsection