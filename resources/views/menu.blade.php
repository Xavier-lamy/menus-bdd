@extends("layouts.app")

@if(isset($menu) && !isset($is_creating) && !isset($is_editing))
    
    @include("partials.menu.show")

@elseif(isset($is_editing))

    @include("partials.menu.edit")

@else 

    @include("partials.menu.create")

@endif