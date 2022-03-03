@extends('auth.guest')

@section('main')
    @include('partials.alert')
    <form method="POST" action="{{ route('login.authenticate') }}" class="text--light">
        @csrf
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="input--inset" required>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" minlength="10" maxlength="80" class="input--inset" required>
        <div class="my--2">
            <input type="checkbox" value="true" id="remember" name="remember"><label for="remember">Remember me</label>
        </div>
        <div class="dsp--flex justify--center">
            <button type="submit" class="button button--secondary my--2">Login</button>
        </div>
    </form>
@endsection