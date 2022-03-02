@extends('auth.guest')

@section('main')
    @include('partials.alert')
    <form method="POST" action="{{ route('login.authenticate') }}" class="text--light">
        @csrf
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="input--inset" required>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="input--inset" required>
        <div class="dsp--flex justify--center">
            <button type="submit" class="button button--secondary my--2">Login</button>
        </div>
    </form>
@endsection