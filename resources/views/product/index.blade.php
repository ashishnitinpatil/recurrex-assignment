@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Products</div>
                <div class="panel-body">
                @if (!$is_operational)
                    <p>Sorry for the inconvenience, but we only serve {{ $operational_hours }}. Please come back later :)</p>
                @endif
                @if ($products->count() > 0)
                    @foreach ($products as $product)
                        <p>{{ $product->name }}</p>
                    @endforeach
                    {{ $products->links() }}
                @else
                    <p>No products to show :(</p>
                    <p><a href="{{ route('product.create') }}">Click here to add products if you are an admin</a></p>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
