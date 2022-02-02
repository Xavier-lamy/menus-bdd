@include("layouts.header")
    @section('wrapper')
        <div class="wrapper">
            <main class="element--center w--60 _mob_w--100">

                <h1 class="text--center">@yield('title')</h1>

                @section('buttons-container')
                <div class="dsp--flex justify--between">
                    @yield('buttons')
                </div>
                @show 
                
                @include("partials.alert")

                @yield('forms')

                @section('table')
                <table class="element--center table--striped w--100">
                    <thead class="w--100 bg--secondary text--light">
                        @yield('table-head')
                    </thead>
                    <tbody>
                        @yield('table-body')
                    </tbody>
                </table>
                @show

            </main>
        </div>
    @show
@include("layouts.footer")
