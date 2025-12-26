@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $brand->name }}</h1>
    <div class="row">
        @foreach($brand->products as $product)
            <div class="col-md-4">
                <x-product-card :product="$product" />
            </div>
        @endforeach
    </div>
</div>
@endsection
