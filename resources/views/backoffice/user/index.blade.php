@extends('backoffice.layout.base')

@section('css')

@endsection

@section('js')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-2 mt-5">
            <div class="row">
                <h3 class="text-center text-muted w-100">
                    Show Users
                </h3>
            </div>
            <hr>
            @if(Session::has('status-success'))
                <div class="alert alert-success alert-dismissible ">
                    {!! session('status-success') !!}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>
            @endif
            @if(Session::has('status-error'))
                <div class="alert alert-danger alert-dismissible ">
                    {!! session('status-error') !!}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>
            @endif
            <div class="row">

                <table class="table table-striped ">
                    <thead class="thead-default">
                    <tr>
                        <th>User Id</th>
                        <th>User Name</th>
                        <th>User E-mail</th>
                        <th style="width: auto">Options</th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                            <tr>
                                <td scope="row">{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @can('edit user')
                                        <a href="{{route('user.edit', $user->id)}}" class="btn btn-sm btn-outline-warning">Edit</a>
                                    @endcan
                                    @can('destroy user')
                                        {!! Form::open(['route' => ['user.destroy', $user->id], 'method' => 'delete', 'class' => ['d-inline']]) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-outline-danger']) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
