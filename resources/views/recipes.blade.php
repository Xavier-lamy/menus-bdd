@extends("layouts.app")

    @section('title')
        Recipes
    @endsection

    @section('buttons')
        <a href=" {{ route('recipe.create') }} " class="button m--3">Add new</a>
        <button type="submit" form="delete_recipe_form" class="button m--3">Delete selection</button>
    @endsection

    @section('forms')
        <form method="POST" action=" {{ route('recipe-delete-confirmation') }} " id="delete_recipe_form">
            @csrf
        </form>
    @endsection

    @section('table-head')
        <th class="w--75">Recipe Title</th>
        <th class="w--25">Actions</th>
    @endsection
    @section('table-body')
        @forelse($recipes as $recipe)
            <tr>
                <td class="text--center p--1">{{ $recipe->name }}</td>
                <td class="text--center p--1">
                    <a href="{{ route('recipe.show', ['id' => $recipe->id]) }}" class="button--sm">See details</a>
                    <input type="checkbox" id="{{ $recipe->id }}" name="delete_{{ $recipe->id }}" form="delete_recipe_form" value="{{ $recipe->id }}">
                </td>
            </tr>
        @empty 
            <tr>
                <td colspan="2" class="text--center">No recipes available</td>
            </tr>
        @endforelse
    @endsection
