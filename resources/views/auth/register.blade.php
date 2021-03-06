@extends('auth.guest')

@section('main')
    @include('partials.alert')
    <form method="POST" action="{{ route('user.store') }}" class="text--light m--3">
        @csrf
        <label for="username">Name</label>
        <input type="text" id="username" name="username" value="{{ old('username') }}" minlength="2" maxlength="80" class="input--inset" required>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" class="input--inset" required>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" minlength="10" maxlength="80" class="input--inset" required>
        <fieldset class="my--2">
            <legend>Options</legend>
            <input type="checkbox" value="true" id="create_ingredients" name="create_ingredients"><label for="create_ingredients">Create a list of common ingredients</label>
        </fieldset>
        <div class="dsp--flex justify--center">
            <button type="submit" class="button button--secondary my--2">Register</button>
        </div>
    </form>
@endsection