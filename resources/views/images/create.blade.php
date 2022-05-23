@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 justify-content-center" style="display: flex">
        <h4>Nuova Immagine</h4>
      </div>
      <div class="col-md-8 justify-content-center">
        @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
      </div>
      <div class="col-md-8">
        <form class="crea" action="{{route('images.store')}}" method="post" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Immagine</label>
            <input type="file" class="form-control-file @error('cover') is-invalid @enderror" id="title" name="cover" value="">
            @error('cover')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          

          @foreach($tags as $tag)
          <div class="mb-3">
            <label for="">#{{$tag->name}}</label>
            <input type="checkbox" name="tag_ids[]" class="switch-input" value="{{$tag->id}}" {{ old('tag') ? 'checked="checked"' : '' }}/>
          </div>
          @endforeach
          
          <button type="submit" class="btn btn-primary" name="button">Save</button>
        </form>
      </div>
    </div>
</div>
@endsection