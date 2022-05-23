@extends('layouts.app')
@section('content')

<div style="display:flex;flex-direction:column; align-items:center;">
  <div class="container desc" style="display:flex;flex-direction:column; align-items:center;">
      <?php 
      use App\Models\User;
      $proprietario = User::findOrFail($image->proprietario);?>
    <h5 class="title"><i class="fas fa-home"></i>Proprietario: {{$proprietario->name}} </h5>
  </div>

  <div class="container foto">
    <div id="thumb" style="display:flex;flex-direction:column; align-items:center;">
        <img  src="{{asset($image->cover)}}" style="width: 300px; height: 300px; border: 2px solid black" alt="">
    </div>

  </div>
  <div id="info">
    <div class="container info">
      <div class="list">
        <div class="left" style="display:flex; text-align:center; margin-top:20px; ">
          <h2>Tags:</h2>
            @foreach($image->tags as $tag )
          <p class="card-text" style="padding-top:7px;"># {{ $tag->name }}</p>
          @endforeach
        </div>
      </div>
    </div>
  </div>



  <div class="col-md-8"style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
    <p style="display:flex; flex-direction:row; align-items:center; justify-content:center;">
    <a class="btn btn-danger" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
      Report
    </a>
    </p>
    <div class="collapse col-md-8" id="collapseExample">
  <form class="creamsg mt-20 " action="{{route('reports.store')}}" method="post" enctype="multipart/form-data">
  @csrf
  @method('POST')

  <div class="mb-3">
    <input type="hidden" class="form-control @error('Sender') is-invalid @enderror" id="whomadeit" name="whomadeit" value="{{Auth::user()->id}}">
    @error('whomadeit')
    <small class="text-danger">{{ $message }}</small>
    @enderror
  </div>

  <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Oggetto</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"></input>
    @error('title')
    <small class="text-danger">{{ $message }}</small>
    @enderror
  </div>

  <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Messaggio</label>
    <textarea type="text" class="form-control @error('content') is-invalid @enderror" name="content"></textarea>
    @error('content')
    <small class="text-danger">{{ $message }}</small>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label"></label>
    <input type="hidden" class="form-control-file @error('image_id') is-invalid @enderror" id="image_id" name="image_id" value="{{$image->id}}">
    @error('image_id')
    <small class="text-danger">{{ $message }}</small>
    @enderror
  </div>
  <div class="mb-3">
  <?php 
      ?>
    <label for="exampleFormControlInput1" class="form-label"></label>
    <input type="hidden" class="form-control-file @error('user_id_image') is-invalid @enderror" id="user_id_image" name="user_id_image" value="{{$proprietario->id}}">
    @error('user_id_image')
    <small class="text-danger">{{ $message }}</small>
    @enderror
  </div>
  <button class="btn btn-primary" type="submit" name="button">Segnala</button>
</form>
</div>
</div>
    <div class="col-md-8"style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
    <p style="display:flex; flex-direction:row; align-items:center; justify-content:center;">
    <a class="btn btn-warning" data-toggle="collapse" href="#collapse" role="button" aria-expanded="false" aria-controls="collapse">
      Vota
    </a>
    </p>
    <div class="collapse col-md-4"style="width:100%;" id="collapse">
    <div class="input-group mb-3" style="width:100%; justify-content:center;">
        <div class="input-group-prepend">
          <a class="btn btn-success" type="button">Scegli</a>
        </div>
        <select name="vote"  value="{{$vote->voto}}"class="custom-select" id="inputGroupSelect03">
          <option selected>Choose...</option>
          <option value="1">One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
      </div>
    </div>
  </div>
</div>

  
@endsection
