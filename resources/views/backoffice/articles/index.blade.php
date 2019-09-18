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
                    Show Articles
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
                        <th>article Id</th>
                        <th>article Name</th>
                        <th>Status</th>
                        <th style="width: auto">Options</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($articles as $article)
                        <tr>
                            <td scope="row">{{$article->id}}</td>
                            <td>{{$article->traduction->first()->pivot->name}}</td>
                            <td>
                                @can('edit permission')
                                    <a href="{{route('article.edit', $article->id)}}" class="btn btn-sm btn-outline-warning">Edit</a>
                                @endcan
                                @can('destroy permission')
                                    {!! Form::open(['route' => ['article.destroy', $article->id], 'method' => 'delete', 'class' => ['d-inline']]) !!}
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
