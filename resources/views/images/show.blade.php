@extends('layouts.app')
@section('content')

<div id="root">
  <div class="container desc">
      <?php 
      use App\Models\User;
      $proprietario = User::findOrFail($image->proprietario); ?>
    <h5 class="title"><i class="fas fa-home"></i> {{$image->proprietario}} </h5>
  </div>

  <div class="container foto">
    <div id="thumb">
        <img  src="{{asset($image->cover)}}" style="width: 300px; height: 300px; border: 2px solid black" alt="">
    </div>

  </div>
  <div id="info">
    <div class="container info">
      <div class="list">
        <div class="left">
            @foreach($image->tags as $tag )
          <p class="card-text"># {{ $tag->name }}</p>
          @endforeach
        </div>
        <div class="right">
          
        </div>
      </div>

    </div>
  </div>






  @endsection
