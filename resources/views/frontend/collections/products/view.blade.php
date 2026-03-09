@extends('layouts.app')



@section('meta_descripion')
{{$product->descripion}}
@endsection


@section('content')


<div class="container-fluid  m-5 wow fadeIn" data-wow-delay="0.1s">
    
    <livewire:frontend.product.view :category="$category" :product="$product" />
</div>


@endsection















