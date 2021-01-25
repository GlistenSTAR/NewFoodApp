@extends('client.main')
@section('category')

<div class="col-md-3" >
    <div class="w3-bar-block">

        @foreach ($category as $cat)
            <a href="#" class="w3-bar-item w3-button "> {{$cat->name}}</a>
        @endforeach
    </div>
</div>

@endsection