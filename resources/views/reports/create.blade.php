@extends('layouts.app')
@section('content')
<div class="col-md-8"> <!-- MESSAGGI -->

  <form class="creamsg mt-20" action="{{route('reports.store')}}" method="post" enctype="multipart/form-data">
  @csrf
  @method('POST')

  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">La tua Email</label>
    <input type="hidden" class="form-control @error('Sender') is-invalid @enderror" id="whomadeit" name="whomadeit" value="{{Auth::user() ? Auth::user()->email : ''}}">
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
    <input type="hidden" class="form-control-file @error('user_id_image') is-invalid @enderror" id="user_id_image" name="user_id_image" value="{{$proprietario->name}}">
    @error('user_id_image')
    <small class="text-danger">{{ $message }}</small>
    @enderror
  </div>
  <button class="btn btn-primary" type="submit" name="button">Segnala</button>
</form>

</div>
@endsection