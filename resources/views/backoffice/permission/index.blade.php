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
                    Show Permissions
                </h3>
            </div>
            <hr>
            @if(Session::has('status-error'))
                <div class="alert alert-danger alert-dismissible ">
                    {!! session('status-error') !!}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>
            @endif
            @if(Session::has('status-success'))
                <div class="alert alert-success alert-dismissible ">
                    {!! session('status-success') !!}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>
            @endif
            <div class="row">

                <table class="table table-striped ">
                    <thead class="thead-default">
                    <tr>
                        <th>Permission Id</th>
                        <th>Permission Name</th>
                        <th style="width: 150px">Options</th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach ($permissions as $permission)
                            <tr>
                                <td scope="row">{{$permission->id}}</td>
                                <td>{{$permission->name}}</td>
                                <td>
                                    @can('edit permission')
                                        <a href="{{route('permission.edit', $permission->id)}}" class="btn btn-outline-warning">Edit</a>
                                    @endcan
                                    @can('destroy permission')
                                        {!! Form::open(['route' => ['permission.destroy', $permission->id], 'method' => 'delete', 'class' => ['d-inline']]) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-outline-danger']) !!}
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
