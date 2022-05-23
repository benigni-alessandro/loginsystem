@extends('layouts.app')
@section('content')
@can('role-create')
<div id="root">
  <div class="container">
    <div class="row justify-content-center">
      <div class=" mex1 col-md-12 "  style="text-align: center;">
        <h3>MESSAGGI RICEVUTI</h3>
      </div>
      <table class="table">
        <thead class="thead-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Mittente</th>
            <th scope="col">id foto</th>
            <th scope="col">title</th>
            <th scope="col">content</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1;?>
        @foreach($reports as $report)
            <tr>
            <th scope="row">{{$i++}}</th>
            <td>{{$report->whomadeit}}</td>
            <td>{{$report->image_id}}</td>
            <td>{{$report->title}}</td>
            <td>{{$report->content}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
      
    </div>
  </div>
</div>
@endcan
@endsection
