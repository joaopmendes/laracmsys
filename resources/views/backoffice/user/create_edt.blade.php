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
                    Create User
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
                    @if(isset($user))
                        {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'PUT', 'files' => true]) !!}
                        <span>When camps are blank, it means that if you don't change them, they will not be edited.</span>
                    @else
                        {!! Form::open(['route' => 'user.store', 'method' => 'post', 'files' => true]) !!}
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
                            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                            {!! Form::text('email', null,
                                        [
                                        'class' =>[
                                            'form-control',
                                            $errors->first('email') ? 'is-invalid' : ''
                                        ]])
                            !!}
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{$errors->first('email')}}
                                </div>
                            @endif
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
                            {!! Form::password('password',
                                        [
                                        'class' =>[
                                            'form-control',
                                            $errors->first('password') ? 'is-invalid' : ''
                                        ]])
                            !!}
                            @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{$errors->first('password')}}
                                </div>
                            @endif
                        </div>
                        <!-- End Password -->
                        <!-- confirm password -->
                        <div class="form-group">
                            {!! Form::label('confirm-password', 'Confirm Password', ['class' => 'control-label']) !!}
                            {!! Form::password('confirm-password',                                        [
                                            'class' => [
                                                'form-control',
                                                $errors->first('confirm-password') ? 'is-invalid' : ''
                                            ]
                                        ])
                            !!}
                            @if ($errors->has('confirm-password'))
                                <div class="invalid-feedback">
                                    {{$errors->first('confirm-password')}}
                                </div>
                            @endif
                        </div>
                        @can('assign permission')
                            <div class="row">
                            <div class="col-3">
                                @foreach ($permissions as $permission)
                                        {!! Form::checkbox($permission->name, $permission->id); !!}
                                        {{$permission->name}}
                                        @if (($loop->index + 1) % 3 === 0)
                                            </div>
                                            <div class="col-3">

                                        @endif<br>
                                @endforeach
                            </div>
                            </div>
                        @endcan
                        <!-- End confirm Password -->
                        <div class="form-group">
                            {!! Form::label('avatar', 'Choose your avatar', ['class' => 'control-label']) !!}
                            <span class="text-muted">Current: {{$user->avatar ?? null}}</span><br>
                            {!! Form::file('avatar', []) !!}
                            @if ($errors->has('avatar'))
                                <div class="invalid-feedback">
                                    {{$errors->first('avatar')}}
                                </div>
                            @endif
                        </div>
                        <div class="form-group float-right">
                            <a href="{{route('user.index')}}" class="btn btn-outline-info">Go Back</a>
                            {!! Form::submit('Submit', ['class' => 'btn btn-outline-success']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>

    </div>

@endsection
