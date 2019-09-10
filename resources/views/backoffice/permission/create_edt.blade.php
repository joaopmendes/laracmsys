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
                    Create Permission
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
                    @if(isset($permission))
                        {!! Form::model($permission, ['route' => ['permission.update', $permission->id], 'method' => 'PUT']) !!}
                    @else
                        {!! Form::open(['route' => 'permission.store', 'method' => 'post']) !!}
                    @endif
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
                            {!! Form::label('guard_name', 'Guard Name', ['class' => 'control-label']) !!}
                            {!! Form::text('guard_name', 'web',
                                        [
                                        'class' =>[
                                            'form-control',
                                            $errors->first('guard_name') ? 'is-invalid' : ''
                                        ],
                                        'placeholder'=>
                                            'web'
                                        ])
                            !!}
                            @if ($errors->has('guard_name'))
                                <div class="invalid-feedback">
                                    {{$errors->first('guard_name')}}
                                </div>
                            @endif
                        </div>
                        <div class="form-group float-right">
                            <a href="{{route('permission.index')}}" class="btn btn-outline-info">Go Back</a>
                            {!! Form::submit('Submit', ['class' => 'btn btn-outline-success']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>

    </div>

@endsection
