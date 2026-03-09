
       
<div class="col-md-11 mx-auto">  
    <div class="row">
    @forelse($products as $productItem)

        <div class="col-md-3">
            <div class="product-card">
                <div class="product-card-img">
                    @if($productItem->productImages->count()>0)
                    <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}">
                        <img src="{{asset($productItem->productImages[0]->image)}}" alt="{{$productItem->name}}" class="img-fluid">
                    </a>
                    @endif
                </div>
                <div class="product-card-body">
                    <p class="product-brand">{{$productItem->small_descriptions}}</p>
                    <h5 class="product-name">
                        <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}">{{$productItem->name}}</a>
                    </h5>
                    <div>
                        <span class="selling-price h4">{{$productItem->original_price}} f cfa</span>
                    </div>
                    <div class="mt-2">
                    </div>
                </div>
            </div>

        </div>
        @empty
        <div class="col-md-12">
            <div class="p-2">
                <h4>{{$category->name}} non disponible </h4>
            </div>
        </div>
        @endforelse
    </div>
</div>










