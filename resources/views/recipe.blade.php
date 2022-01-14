@if(!empty($recipe))
    @extends("layouts.app")

    @section("wrapper")
    <div class="wrapper">
        <main class="element--center w--60 _mob_w--100">
            <h1 class="text--center">{{ $recipe->name }}</h1>

            @include("partials.alert")

            <div class="dsp--flex justify--between">
                <!--Bouton modifier-->
            </div>

            <ul>
                @forelse($recipe->quantities as $ingredient)
                <li>{{ $ingredient->command->ingredient }} : 
                    {{ $ingredient->quantity }} {{ $ingredient->command->unit }}
                </li>
                
                @empty
                    Recipe has no ingredients 
                @endforelse
            </ul>
            <p> {!! nl2br($recipe->process) !!} </p>
        </main>
    </div>
    @endsection    
@endif
