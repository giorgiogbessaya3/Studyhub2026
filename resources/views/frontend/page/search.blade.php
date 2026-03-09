@extends('layouts.app')

@section('title', 'search Products')

@section('content')
<div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h4>Recherchez Des Services</h4>
                    <div class="underline1"></div>
                    <div class="underline mb-5"></div>
                </div>
                @forelse($searchProducts as $productItem)
                <div class="col-md-10">
                    <div class="product-card ">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="product-card-img">
                                    <label for="" class="stock bg-danger">New</label>
                                    @if($productItem->productImages->count()>0)
                                        <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}">
                                            <img src="{{asset($productItem->productImages[0]->image)}}" alt="{{$productItem->name}}" class="img-fluid">
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="product-card-body">
                                    <p class="product-brand">{{$productItem->brand}}</p>
                                    <h5 class="product-name">
                                        <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}">{{$productItem->name}}</a>
                                    </h5>
                                    <div>
                                        <span class="selling-price">{{$productItem->original_price}} f cfa</span>
                                    </div>
                                    <p style="height:45px; overflow:hidden">
                                        <b>Description :</b>{{$productItem->description}}
                                    </p>
                                    <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}" class="btn btn-outline-primary">view</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-2 col-md-12">
                    <h4>Le services Que Vous Recherchez n'est  disponible </h4>
                </div>
                @endforelse
                <div class="col-md-10">
                    {{$searchProducts->appends(request()->input())->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection