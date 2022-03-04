<nav class="navbar dsp--flex justify--around">
    <ul class="navbar__links list--unstyled dsp--flex justify--between">
        <li><a href=" {{ route('front') }} ">Home</a></li>
        <li><a href=" {{ route('menus') }} ">Menus</a></li>
        <li><a href=" {{ route('recipes') }} ">Recipes</a></li>
        <li><a href=" {{ route('stocks') }} ">Stocks</a></li>
    </ul>
    <ul class="navbar__login list--unstyled dsp--flex justify--between">
        <li><a href="{{ route('options.index') }}" aria-label="Options"><i class="fa fa-gear fa-lg"></i>Options</a></li>
        <li><a href="{{ route('logout') }}" aria-label="Logout"><i class="fas fa-sign-out-alt fa-lg"></i>Logout</a></li>
    </ul>
</nav>