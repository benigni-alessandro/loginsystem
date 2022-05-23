@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 justify-content-center" style="display: flex">
        <a href="{{route('images.create')}}">Posta una nuova immagine</a>
      </div>
    </div>
</div>
<div>
@foreach($images as $image)
        <a href="">
          <div class="card apartment-card">
            <img class="" src="{{asset($image->cover)}}" style="width: 200px; height: 200px; border: 2px solid red" alt="">
        </a>
        <div class="card-body col-12">

          <h5 class="card-title text-center"><i class="fas fa-home"></i>{{$image->image_id}}</h5>

          <div class="commands mt-20">
            <a href="{{route('images.edit', ['image'=>$image->id])}}" class="btn btn-second">Modifica</a>
            <form class="delete" action="{{route('images.destroy', ['image'=>$image->id])}}" method="post">
              @csrf
              @method('DELETE')
              <input type="submit" class="btn btn-third" name="Delete" value="Elimina">
            </form>
            <form class="share" action="{{route('images.share', ['image'=>$image->image_id])}}" method="post">
                @csrf
                @method('PATCH')
                <input type="submit" name="Share" value="Share">
            </form>
          </div>
        </div>
      </div>
      @endforeach
</div>
@endsection
