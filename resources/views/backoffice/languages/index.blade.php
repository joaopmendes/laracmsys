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
                    Show Languages
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
                        <th>Language Id</th>
                        <th>Language Slug</th>
                        <th>Language Name</th>
                        <th>Language Status</th>
                        <th style="width: auto">Options</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($object_list as $object)
                        <tr>
                            <td scope="row">{{$object->id}}</td>
                            <td>{{$object->slug}}</td>
                            <td>{{$object->name}}</td>
                            <td><div class="custom-control custom-switch">
                                    <input type="checkbox" name="status" class="custom-control-input" id="statusSwitch{{$object->id}}"
                                           @if ($object->status === 1) checked @endif>
                                    <label onclick="window.location = '{{ route('status.update', ['id' => $object->id, 'table'=> 'languages', 'column' => 'id', 'prevStatus' => $object->status, 'permission' => 'edit_status language']) }}'" class="custom-control-label" for="statusSwitch{{$object->id}}"></label>
                                </div></td>
                            <td>
                                @can('edit language')
                                    <a href="{{route('language.edit', $object->id)}}" class="btn btn-sm btn-outline-warning">Edit</a>
                                @endcan
                                @can('destroy language')
                                    {!! Form::open(['route' => ['language.destroy', $object->id], 'method' => 'delete', 'class' => ['d-inline']]) !!}
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
