@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 justify-content-center" style="display: flex">
        <a class="btn btn-primary" style="margin:10px;" href="{{route('images.create')}}">Posta una nuova immagine</a>
        <a class="btn btn-danger" style="margin:10px;" href="{{route('images.ordenar')}}">Ordinare per data</a>
      </div>
      <div class="col-md-12 justify-content-center" style="display: flex">    
      <form class="crea" style="width:80%;" action="{{route('images.searchperhashtag')}}" method="post">
          @csrf
          @method('POST')
          <div class="mb-5" style="display:flex;">
            <input type="text" placeholder="Cerca per hashtag" class="form-control @error('tag') is-invalid @enderror" id="tag" name="tag" value="{{ old('tag') }}">
            @error('tag')
              <small class="text-danger">{{ $message }}</small>
            @enderror
            <button class="btn btn-danger" type="submit" name="button">Cerca</button>
          </div>
        </form>
      </div>
    </div>
</div>
<div style= "display: flex; justify-content-center; flex-direction:column; text-align:center; padding:10px;"">

@foreach($images as $image)
@if($image->image_id)
          <div class="card apartment-card" style="margin:30px padding-top:20px; padding-bottom:20px;">
          <a href="{{route('images.show', ['image'=>$image->image_id])}}">
            <img class="" src="{{asset($image->cover)}}" style="width: 300px; height: 300px; border: 2px solid black" alt="">
            
            <div class="card-body col-12">

              <h5 class="card-title text-center"><i class="fas fa-home"></i>{{$image->image_id}}</h5>

              <div class="commands mt-20" style= "display: flex; justify-content:center; flex-direction:row; text-align:center">
                <a href="{{route('images.edit', ['image'=>$image->id])}}" class="btn btn-warning">Modifica</a>
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
@else
<div class="card apartment-card" style="margin:30px padding-top:20px; padding-bottom:20px;">
          <a href="{{route('images.show', ['image'=>$image->id])}}">
            <img class="" src="{{asset($image->cover)}}" style="width: 300px; height: 300px; border: 2px solid black" alt="">
            
            <div class="card-body col-12">

              <h5 class="card-title text-center"><i class="fas fa-home"></i>{{$image->id}}</h5>

              <div class="commands mt-20" style= "display: flex; justify-content:center; flex-direction:row; text-align:center">
                <a href="{{route('images.edit', ['image'=>$image->id])}}" class="btn btn-warning">Modifica</a>
                <form class="delete" action="{{route('images.destroy', ['image'=>$image->id])}}" method="post">
                @csrf
                @method('DELETE')
                  <input type="submit" class="btn btn-danger" name="Delete" value="Elimina">
                </form>
                <form class="share" action="{{route('images.share', ['image'=>$image->id])}}" method="post">
                  @csrf
                  @method('PATCH')
                  <input type="submit" class="btn btn-info" name="Share" value="Share">
                </form>
              </div>
            </div>
          </a>
        </div>
@endif
      @endforeach
</div>
@endsection
