@extends("layouts.app")

@section('title')
    Options
@endsection

@section('forms')

    <form method="POST" action="">
        <fieldset>
            <legend class="h5">General Options</legend>
            @isset($dish_moments)
            <div class="dsp--flex flxdir--row align--center my--3">
                <label for="dish_moment" class="dsp--flex flxdir--col pr--3 lh--small">
                    <span class="fw--bold">Menu Moments</span>
                    <span class="text--small">Define how menus work</span> 
                </label>
                <select name="dish_moment" id="dish_moment" class="text--center input--inset" aria-label="Dish moment" required>
                    @foreach($dish_moments as $dish_moment)
                        <option value="{{$dish_moment->id}}" {{ ($dish_moment->pivot->active == 1) ? 'selected' : '' }}>
                            @php
                                $separator = '';
                            @endphp
                            @foreach($dish_moment->options as $dish_option_slug => $dish_option) 
                                {{ $separator }}{{ $dish_option }}
                                @php
                                    $separator = '/ ';
                                @endphp
                            @endforeach
                        </option>
                    @endforeach
                </select> 
            </div>               
            @endisset
            @isset($command_created)
                @if (($command_created->pivot->active == 0) || $command_is_empty)
                <div class="dsp--flex flxdir--row align--center my--3">
                    <label class="dsp--flex flxdir--col pr--3 lh--small">
                        <span class="fw--bold">Total stocks</span>
                        <span class="text--small">Generate a list of common ingredients</span>
                    </label>
                    <input type="checkbox" name="generate_ingredients" id="generate_ingredients" value="true">
                </div>    
                @endif
            @endisset
        </fieldset>
    </form>
@endsection

@section('table')
    {{--Empty table--}}
@endsection