@extends('backoffice.layout.base')

@section('css')

@endsection

@section('js')
    <script>
        @foreach ($languages as $index => $lang)
            @if($errors->any() && $errors->first("name_{$lang->slug}"))
                $('#{{$lang->slug}}').tab('show')
                @break
            @endif
        @endforeach
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-2 mt-5">
            <div class="row">
                <h3 class="text-center text-muted w-100">
                    @if(isset($tag))
                        Edit Tag
                    @else
                        Create Tag
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
                    @if(isset($tag))
                        {!! Form::model($tag, ['route' => ['tag.update', $tag->id], 'method' => 'PUT']) !!}
                    @else
                        {!! Form::open(['route' => 'tag.store', 'method' => 'post']) !!}
                    @endif
                    {{--
                        ---------------------------
                     --}}
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach ($languages as $i => $language)
                            <li class="nav-item" style="width:{{$tabsAdjust}}%;">
                                <a class="nav-link @if ($i == 0) active @endif" id="{{$language->slug}}"
                                   style="color:black;" data-toggle="tab" href="#section-{{$language->slug}}" role="tab"
                                   aria-controls="{{$language->slug}}"
                                   aria-selected="@if ($i == 0) true @else false @endif">{{$language->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @foreach ($languages as $index => $language)
                            <div value="{{ $language->slug }}" class="tab-pane fade @if ($index == 0)show active @endif"
                                 id="section-{{$language->slug}}" role="tabpanel" aria-labelledby="{{$language->slug}}">
                                <div class="form-group">
                                    {!! Form::label('name_' . $language->slug ,'Name ' . $language->slug ,['class' => 'control-label']) !!}
                                    {!! Form::text('name_' . $language->slug,
                                            old('name_' . $language->slug, isset($tag)?$tag->traduction->where("id", $language->id)->first()->pivot->name ?? null:null),
                                            ['class' =>[
                                                'form-control',
                                                $errors->first('name_' . $language->slug) ? 'is-invalid' : ''
                                            ]])
                                    !!}
                                    @if ($errors->has('name_' . $language->slug))
                                        <div class="invalid-feedback">
                                            {{$errors->first('name_' . $language->slug)}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- ---------- --------------------- --}}

                    <div class="form-group">
                        <label for="color">Display</label><br>
                        <div class="row">
                            <div class="col-4">
                                <label>
                                    {!! Form::radio('color', 'primary', null,  ['id' => 'color']) !!}
                                    <button class="btn btn-sm ml-3 btn-primary" disabled>Tag Color</button>
                                </label>
                                <label>
                                    {!! Form::radio('color', 'secundary', null,  ['id' => 'color']) !!}
                                    <button class="btn btn-sm ml-3 btn-secondary" disabled>Tag Color</button>
                                </label>
                            </div>
                            <div class="col-4">
                                <label>
                                    {!! Form::radio('color', 'info', null,  ['id' => 'color']) !!}
                                    <button class="btn btn-sm ml-3 btn-info" disabled>Tag Color</button>
                                </label>

                                <label>
                                    {!! Form::radio('color', 'dark', null,  ['id' => 'color']) !!}
                                    <button class="btn btn-sm ml-3 btn-dark" disabled>Tag Color</button>
                                </label>
                            </div>
                            <div class="col-4">
                                <label>
                                    {!! Form::radio('color', 'success', null,  ['id' => 'color']) !!}
                                    <button class="btn btn-sm ml-3 btn-success" disabled>Tag Color</button>

                                </label>
                                <label>
                                    {!! Form::radio('color', 'danger', null,  ['id' => 'color']) !!}
                                    <button class="btn btn-sm ml-3 btn-danger" disabled>Tag Color</button>
                                </label>


                            </div>
                        </div>


                    </div>
                    <div class="form-group float-right">
                        <a href="{{route('tag.index')}}" class="btn btn-sm btn-outline-info">Go Back</a>
                        {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-outline-success']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>

    </div>

@endsection
