<nav class="navbar dsp--flex justify--around">
    <ul class="navbar__links list--unstyled dsp--flex justify--between">
        <li><a href= {{ route('front') }} >Home</a></li>
        <li><a href="#">Menus</a></li>
        <li><a href=" {{ route('recipes') }} ">Recipes</a></li>
        <li><a href= {{ route('stocks') }} >Stocks</a></li>
    </ul>
    <ul class="navbar__login list--unstyled dsp--flex justify--between">
        <li><a href="#" aria-label="Register"><i class="fas fa-user-plus fa-lg"></i>Register</a></li>
        <li><a href="#" aria-label="Login"><i class="fas fa-sign-in-alt fa-lg"></i>Login</a></li>
    </ul>
</nav>