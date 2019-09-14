@extends('backoffice.layout.base')



@section('js')
    <script>
        $("#permissions").select2({
            width:"100%",
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-2 mt-5">
            <div class="row">
                <h3 class="text-center text-muted w-100">
                    @if(isset($user))
                        Edit User
                    @else
                        Create User
                    @endif
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
                                <div class="col-12">
                                    <label for="permissions">Permissions</label>
                                    <select name="permissions[]" id="permissions" multiple>
                                        @foreach ($permissions as $permission)
                                            <option value="{{$permission->name}}" @if (isset($user->permissions) && $user_permissions->contains($permission->name))
                                                selected
                                            @endif>{{$permission->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endcan
                        <!-- End confirm Password -->
                        <div class="form-group mt-3">
                            <label for="avatar">User Avatar</label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input {{ $errors->has('avatar') ? 'is-invalid' : null }}" name="avatar" id="avatar"
                                           aria-describedby="avatar">
                                    {!! Form::label('avatar', $user->avatar ?? 'Choose the banner image' , ['class' =>[ 'custom-file-label' ]]) !!}
                                </div>
                            </div>
                        <div class="form-group float-right">
                            <a href="{{route('user.index')}}" class="btn btn-sm btn-outline-info">Go Back</a>
                            {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-outline-success']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>

    </div>

@endsection
