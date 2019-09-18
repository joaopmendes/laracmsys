@extends('backoffice.layout.base')

@section('css')

@endsection

@section('js')
    <script>
        @foreach ($languages as $index => $lang)
            CKEDITOR.disableAutoInline = true;
        CKEDITOR.inline("editor_{{$lang->slug}}");

        @if($errors->any() && $errors->first("name_{$lang->slug}"))
        $('#{{$lang->slug}}').tab('show')
        @foreach ($languages as $index => $lang)
        @if($errors->any() && $errors->first("body_{$lang->slug}"))
        $('#{{$lang->slug}}').tab('show')
        @break
        @endif
        @endforeach
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
                    @if(isset($article))
                        Edit article
                    @else
                        Create article
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
                    @if(isset($article))
                        {!! Form::model($article, ['route' => ['article.update', $article->id], 'method' => 'PUT']) !!}
                    @else
                        {!! Form::open(['route' => 'article.store', 'method' => 'post']) !!}
                    @endif
                    {{--
                        ---------------------------
                     --}}
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach ($languages as $i => $language)
                            <li class="nav-item " style="width:{{100 / $languages->count() }}%;">
                                <a class="nav-link font-weight-bolder @if ($i == 0) active @endif"
                                   id="{{$language->slug}}"
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
                                            old('name_' . $language->slug, isset($article) ? $article->traduction->where("id", $language->id)->first()->pivot->name ?? null:null),
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
                                <div class="form-group">
                                    {!! Form::label("body_{$language->slug}","Article Body {$language->slug}",['class' => 'control-label mt-3 ']) !!}
                                    <div class="rounded p-3" style="border: 1px solid #ced4da">
                                        <textarea id="editor_{{$language->slug}}" name="{{"body_{$language->slug}"}}"
                                                  class="form-control shadow  @if($errors->has('body_' . $language->slug)) is-invalid @endif"
                                                  contenteditable="true"
                                                  style="border: 1px solid #4b565b; padding: 10px">
                                                @if (old("body_{$language->slug}"))
                                                {{old("body_{$language->slug}")}}
                                            @else
                                                @if (isset($object) && $object->traduction->where('id', $language->id)->first())
                                                    {{$object->traduction->where('id', $language->id)->first()->pivot->body}}
                                                @else
                                                    Write your body here
                                                @endif
                                            @endif
                                    </textarea>

                                    </div>

                                    @if ($errors->has('body_' . $language->slug))
                                        <div class="invalid-feedback">
                                            {{$errors->first('body_' . $language->slug)}}
                                        </div>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>
                    {{-- ---------- --------------------- --}}
                    <div class="mt-3">
                        <label>Default Opitons</label><br>
                        <div class="custom-control custom-checkbox mr-4 d-inline">
                            <input type="checkbox" @if(isset($object->highlighted) && $object->highlighted == 1) checked
                                   @endif name="highlighted" class="custom-control-input" id="highlighted">
                            <label class="custom-control-label" for="highlighted">Highlighted (first page)</label>
                        </div>
                        <div class="custom-control custom-checkbox d-inline">
                            <input type="checkbox" @if(!isset($object->status)) checked
                                   @endif @if(isset($object->status) && $object->status == 1) checked
                                   @endif name="status" class="custom-control-input" id="status">
                            <label class="custom-control-label" for="status">Status (Active or not)</label>
                        </div>
                    </div>

                    <div class="form-group float-right">
                        <a href="{{route('article.index')}}" class="btn btn-sm btn-outline-info">Go Back</a>
                        {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-outline-success']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>

    </div>

@endsection
