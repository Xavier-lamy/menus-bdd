@section('title')
{{ $recipe->name }}
@endsection

@section('buttons')
<a href=" {{ route('recipes') }} " class="button m--3">Return to recipes</a>
<a href=" {{ route('recipe.modify', ['id' => $recipe->id]) }} " class="button m--3">Modify</a>
@endsection

@section('forms')
{{--empty--}}
@endsection

@section('table-head')
<th class="w--60">Ingredient</th>
<th class="w--40">Quantity</th>
@endsection
@section('table-body')
@forelse($recipe->quantities as $ingredient)
    <tr>
        <td class="text--center p--1">{{ $ingredient->command->ingredient }}</td>
        <td class="text--center p--1">{{ $ingredient->quantity }} {{ $ingredient->command->unit }}</td>
    </tr> 
@empty
    <tr>
        <td colspan="2" class="text--center p--1">Recipe has no ingredients</td>
    </tr>  
@endforelse
@if(isset($ingredient) && isset($recipe->total))
    <tr>
        <td class="text--center p--1 fw--bold">Total</td>
        <td class="text--center p--1 fw--bold">{{ $recipe->total }} {{ $ingredient->command->unit }}</td>
    </tr>
@endif
    <th colspan="2" class="bg--secondary text--light">Method</th>
    <tr>
        <td colspan="2">
            <p class="mx--3 my--1">{!! nl2br($recipe->process) !!}</p>
        </td>
    </tr>
@endsection