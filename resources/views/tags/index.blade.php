@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 justify-content-center" style="display: flex">
        <a class="btn btn-primary" href="{{route('tags.create')}}">Crea nuovo tag</a>
      </div>
      @foreach($tags as $tag)
      <a href="{{route('tags.show', ['tag'=>$tag->id])}}">
        <div class="col-md-3">
          <div class="card" style="text-align: center; padding:50px">
              <div class="card-header"  style="background-color:red; color:white;"><?php echo('#' . $tag->name )?> </div>
                <div class="card-body">
                  <div class="controls" style="display: flex; justify-content: space-between; align-items: center;">
                    <a class="btn btn-info" href="{{route('tags.edit', ['tag'=> $tag->id])}}">Edit</a>
                    <form class="delete" action="{{route('tags.destroy', ['tag'=>$tag->id])}}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" name="Delete" value="Delete">
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
