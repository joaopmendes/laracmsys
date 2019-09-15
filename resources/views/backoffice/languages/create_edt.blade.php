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
                    @if(isset($language))
                        Edit Language
                    @else
                        Create Language
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
                    @if(isset($language))
                        {!! Form::model($language, ['route' => ['language.update', $language->id], 'method' => 'PUT']) !!}
                    @else
                        {!! Form::open(['route' => 'language.store', 'method' => 'post']) !!}
                    @endif
                        <div class="form-group">
                            {!! Form::label('slug','Slug',['class' => 'control-label']) !!}
                            {!! Form::text('slug',
                                    null,
                                    ['class' =>[
                                        'form-control',
                                        $errors->first('slug') ? 'is-invalid' : ''
                                    ]])
                            !!}
                            @if ($errors->has('slug'))
                                <div class="invalid-feedback">
                                    {{$errors->first('slug')}}
                                </div>
                            @endif
                        </div>
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
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="status" class="custom-control-input" id="statusSwitch"
                                   @if (isset($language) && $language->status == 1) checked @endif>
                            <label class="custom-control-label" for="statusSwitch">Status</label>
                        </div>
                        <div class="form-group float-right">
                            <a href="{{route('language.index')}}" class="btn btn-sm btn-outline-info">Go Back</a>
                            {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-outline-success']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>

    </div>

@endsection
