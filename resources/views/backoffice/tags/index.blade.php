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
                    Show Tags
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
                        <th>Tag Id</th>
                        <th>Tag Name</th>
                        <th style="width: auto">Options</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($tags as $tag)
                        <tr>
                            <td scope="row">{{$tag->id}}</td>
                            <td>{{$tag->traduction->first()->pivot->name}}</td>
                            <td>
                                @can('edit permission')
                                    <a href="{{route('tag.edit', $tag->id)}}" class="btn btn-sm btn-outline-warning">Edit</a>
                                @endcan
                                @can('destroy permission')
                                    {!! Form::open(['route' => ['tag.destroy', $tag->id], 'method' => 'delete', 'class' => ['d-inline']]) !!}
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
