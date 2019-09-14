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
                    Show Posts
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
                        <th>Post Id</th>
                        <th>Post Subject</th>
                        <th style="width: auto">Options</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($object_list as $object)
                        <tr>
                            <td scope="row">{{$object->id}}</td>
                            <td>{{$object->subject}}</td>
                            <td>
                                @can('edit post')
                                    <a href="{{route('post.edit', $object->id)}}" class="btn btn-sm btn-outline-warning">Edit</a>
                                @endcan
                                @can('destroy post')
                                    {!! Form::open(['route' => ['post.destroy', $object->id], 'method' => 'delete', 'class' => ['d-inline']]) !!}
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
