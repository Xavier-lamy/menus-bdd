@extends("layouts.app")

    @section('title')
        My shopping list
    @endsection

    @section('buttons')
        {{--empty--}}
    @endsection

    @section('forms')
        {{--empty--}}
    @endsection

    @section('table-head')
        <th class="w--25">Ingredient</th>
        <th class="w--25">Quantity needed</th>
    @endsection
    @section('table-body')
        @forelse($products as $product)
            <tr>
                <td class="text--center p--1">{{ $product->ingredient }}</td>
                <td class="text--center p--1">{{ (($product->alert_stock) * 1.5) - ($product->quantity) }} {{ $product->unit }}</td>
            </tr>
        @empty 
            <tr>
                <td colspan="2" class="text--center">Shopping list is empty</td>
            </tr>                        
        @endforelse
    @endsection