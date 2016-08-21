@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Products</div>
                <div class="panel-body">
                @if ($products->count() > 0)
                    @foreach ($products as $product)
                        <p>{{ $product->name }}</p>
                    @endforeach
                @else
                    <p>No more products to show</p>
                    @if (Auth::user()->isAdmin())
                        <p><a href="{{ route('product.create') }}">Click here to add products</a></p>
                    @endif
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
