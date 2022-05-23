@extends('layouts.app')

@can('role-create')

@section('content')

<div class="container" style="margin-bottom:50px;"">
  <div class="row">
      <div class="col-lg-8 margin-tb">
          <div class="pull-left">
              <h2>Users Management</h2>
          </div>
          <div class="pull-right">
              <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
          </div>
      </div>
    
  </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<div class="container">
  <div class="row">
    <div class="col-lg-12">
    <table class="table table-bordered">
 <tr>
   <th>No</th>
   <th>Name</th>
   <th>Email</th>
   <th>Credito</th>
   <th>N.img</th>
   <th>Roles</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($data as $key => $user)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->credito }}</td>
    <td>{{ $user->n_post_caricati }}</td>
    <td>
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
        <?php echo ($user->getRoleNames()[0]);?>
           <label class="badge badge-success">{{ $v }}</label>
        @endforeach
      @endif
    </td>
    <td>
       <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
       <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
        <a class="btn btn-warning" href="{{ route('users.show',$user->id) }}">Vote</a>
    </td>
  </tr>
 @endforeach
</table>
    </div>
  </div>

</div>

{!! $data->render() !!}

@endsection
@endcan