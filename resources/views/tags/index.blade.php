@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 justify-content-center" style="display: flex">
        <a href="{{route('admin.tags.create')}}">Crea nuovo tag</a>
      </div>
      @foreach($tags as $tag)
      <a href="{{route('admin.tags.show', ['tag'=>$tag->id])}}">
        <div class="col-md-3">
          <div class="card">
              <div class="card-header">{{ $tag->name }}</div>
                <div class="card-body">
                  <div class="controls" style="display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{route('admin.tags.edit', ['tag'=> $tag->id])}}">Edit</a>
                    <form class="delete" action="{{route('admin.tags.destroy', ['tag'=>$tag->id])}}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" name="Delete" value="Delete">
                    </form>
                  </div>
                </div>
          </div>

        </div>
      </a>
      @endforeach
    </div>
</div>
@endsection
