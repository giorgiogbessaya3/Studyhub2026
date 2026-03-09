@extends('layouts.app')

@section('title')


@section('descripion')
{{$category->descripion}}
@endsection


@section('content')

<div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <h3 class="display-3 mb-4 animated slideInDown">Nos Services</h3>
    </div>
    <livewire:frontend.product.index :category="$category"/>
</div>

@endsection


















