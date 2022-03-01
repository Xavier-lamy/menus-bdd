@extends("layouts.app")

@if(!empty($recipe) && !isset($is_creating) && !isset($is_editing))

    @include("partials.recipe.show")

@elseif(isset($is_editing))

    @include("partials.recipe.edit")

@else

    @include("partials.recipe.create")

@endif  
