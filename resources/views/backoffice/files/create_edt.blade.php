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
                    Edit {{$file->name}}
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
                <div class="col-md-12">
                    {!! Form::model($file, ['route' => ['file.update', $file->id], 'method' => 'PUT']) !!}
                   
                        <div class="form-group">
                            {!! Form::label('name','Name',['class' => 'control-label']) !!}
                            {!! Form::text('name',
                                    null,
                                    ['class' =>[
                                        'form-control',
                                        $errors->first('name') ? 'is-invalid' : ''
                                    ]])
                            !!}
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{$errors->first('name')}}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('path', 'Path', ['class' => 'control-label']) !!}
                            {!! Form::text('path', asset( "storage/".$file->path), ["readonly"=>true ,'class' => 'form-control']) !!}
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 form-group">
                                {!! Form::label('image', 'Image', ['class' => 'control-label']) !!}
                                {!! Form::text('image', $file->image ? "true" : "false" , ["readonly"=>true ,'class' => 'form-control']) !!}
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                {!! Form::label('type', 'Type', ['class' => 'control-label']) !!}
                                {!! Form::text('type', null , ["readonly"=>true ,'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group float-right">
                            <a href="{{route('file.index')}}" class="btn btn-sm btn-outline-info">Go Back</a>
                            {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-outline-success']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>


@endsection
