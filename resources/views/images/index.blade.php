@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 justify-content-center" style="display: flex">
        <a class="btn btn-primary" href="{{route('images.create')}}">Posta una nuova immagine</a>
      </div>
    </div>
</div>
<div style= "display: flex; justify-content-center; flex-direction:column; text-align:center; margin:10px;"">
@foreach($images as $image)
          <div class="card apartment-card" style="margin:30px padding-top:20px; padding-bottom:20px;">
          <a href="{{route('images.show', ['image'=>$image->image_id])}}">
            <img class="" src="{{asset($image->cover)}}" style="width: 300px; height: 300px; border: 2px solid black" alt="">
            
            <div class="card-body col-12">

              <h5 class="card-title text-center"><i class="fas fa-home"></i>{{$image->image_id}}</h5>

              <div class="commands mt-20" style= "display: flex; justify-content:center; flex-direction:row; text-align:center">
                <a href="{{route('images.edit', ['image'=>$image->id])}}" class="btn btn-second">Modifica</a>
                <form class="delete" action="{{route('images.destroy', ['image'=>$image->id])}}" method="post">
                @csrf
                @method('DELETE')
                  <input type="submit" class="btn btn-danger" name="Delete" value="Elimina">
                </form>
                <form class="share" action="{{route('images.share', ['image'=>$image->image_id])}}" method="post">
                  @csrf
                  @method('PATCH')
                  <input type="submit" class="btn btn-info" name="Share" value="Share">
                </form>
              </div>
            </div>
          </a>
        </div>
        
      @endforeach
</div>
@endsection
