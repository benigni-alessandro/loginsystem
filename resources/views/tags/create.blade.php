@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 justify-content-center" style="display: flex">
        <h4>Nuovo tag</h4>
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
        <form class="crea" action="{{route('admin.tags.store')}}" method="post">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="title" name="name" value="{{ old('name') }}">
            @error('name')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <button type="submit" name="button">Save</button>
        </form>
      </div>
    </div>
</div>
@endsection