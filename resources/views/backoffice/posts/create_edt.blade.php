@extends('backoffice.layout.base')

@section('css')

@endsection

@section('js')

    <script>

        CKEDITOR.disableAutoInline = true;
        CKEDITOR.inline('editor1');

        $("#tags").select2({
            width: "100%",
        });
        // Animations initialization

    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-2 mt-5">
            <div class="row">
                <h3 class="text-center text-muted w-100">
                    @if(isset($object))
                        Edit Post
                    @else
                        Create Post
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
                    @if(isset($object))
                        {!! Form::model($object, ['route' => ['post.update', $object->id], 'method' => 'PUT', 'files' => true]) !!}
                    @else
                        {!! Form::open(['route' => 'post.store', 'method' => 'post', 'files' => true]) !!}
                    @endif
                    <div class="form-group">
                        {!! Form::label('subject','Subject',['class' => 'control-label']) !!}
                        {!! Form::text('subject',
                                null,
                                ['class' =>[
                                    'form-control',
                                    $errors->first('subject') ? 'is-invalid' : ''
                                ]])
                        !!}
                        @if ($errors->has('subject'))
                            <div class="invalid-feedback">
                                {{$errors->first('subject')}}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="banner_image">Banner Image</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input {{ $errors->has('banner_image') ? 'is-invalid' : null }}" name="banner_image" id="banner_image"
                                       aria-describedby="banner_image">
                                {!! Form::label('banner_image', $object->banner_image ?? 'Choose the banner image' , ['class' =>[ 'custom-file-label' ]]) !!}
                            </div>
                        </div>
                        @if ($errors->has('banner_image'))
                            <div class="invalid-feedback">
                                {{$errors->first('banner_image')}}
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="tags">Tags</label>
                            <select name="tags[]" id="tags" multiple>
                                @foreach ($tags as $tag)
                                    <option value="{{$tag->id}}"
                                            @if (isset($object->tags) &&
                                                \DB::table("post_tag")
                                                    ->where(
                                                        ['post_id' => $object->id,
                                                         'tag_id' => $tag->id
                                                        ])->exists()
                                                )
                                            selected
                                        @endif>{{$tag->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        <div class="mt-3">
                            <label>Default Opitons</label><br>
                            <div class="custom-control custom-checkbox ">
                                <input type="checkbox" @if(isset($object->highlighted) && $object->highlighted == 1) checked @endif name="highlighted" class="custom-control-input" id="highlighted">
                                <label class="custom-control-label" for="highlighted">Highlighted (first page)</label>
                            </div>
                            <div class="custom-control custom-checkbox ">
                                <input type="checkbox" @if(!isset($object->status)) checked @endif @if(isset($object->status) && $object->status == 1) checked @endif name="status" class="custom-control-input" id="status">
                                <label class="custom-control-label"  for="status">Status (Active or not)</label>
                            </div>
                        </div>

                    <div class="form-group">
                        {!! Form::label('body','Post Body',['class' => 'control-label mt-3 ']) !!}
                        <textarea id="editor1" name="body" class="is-invalid" contenteditable="true"
                                  style="border: 1px solid #4b565b; padding: 10px">
                            @if(isset($object->body)) {{$object->body}} @else
                                <div class="container">

                                    <!--Section: Post-->
                                    <section class="mt-4">

                                        <!--Grid row-->
                                        <div class="row">

                                            <!--Grid column-->
                                            <div class="col-md-12 mb-4">

                                                <!--Featured Image-->
                                                <div class="card mb-4 wow fadeIn">

                                                    <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(144).jpg"
                                                         class="img-fluid" alt="">

                                                </div>
                                                <!--/.Featured Image-->

                                                <!--Card-->
                                                <div class="card mb-4 wow fadeIn">

                                                    <!--Card content-->
                                                    <div class="card-body text-center">
                                                        <h5 class="my-4">
                                                            <strong>MDB - trusted by 400 000 + developers &amp;
                                                                designers</strong>
                                                        </h5>
                                                    </div>

                                                </div>
                                                <!--/.Card-->

                                                <!--Card-->
                                                <div class="card mb-4 wow fadeIn">

                                                    <!--Card content-->
                                                    <div class="card-body">

                                                        <p class="h5 my-4">That's a very long heading </p>


                                                        <blockquote class="blockquote">
                                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur
                                                                adipiscing elit. Integer posuere erat a ante.</p>
                                                            <footer class="blockquote-footer">Someone famous in
                                                                <cite title="Source Title">Source Title</cite>
                                                            </footer>
                                                        </blockquote>

                                                        <p class="h5 my-4">That's a very long heading </p>

                                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae,
                                                            ut rerum deserunt corporis
                                                            ducimus at, deleniti ea alias dolor reprehenderit sit vel.
                                                            Incidunt id illum doloribus,
                                                            consequuntur maiores sed eligendi.</p>

                                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae,
                                                            ut rerum deserunt corporis
                                                            ducimus at, deleniti ea alias dolor reprehenderit sit vel.
                                                            Incidunt id illum doloribus,
                                                            consequuntur maiores sed eligendi.</p>

                                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae,
                                                            ut rerum deserunt corporis
                                                            ducimus at, deleniti ea alias dolor reprehenderit sit vel.
                                                            Incidunt id illum doloribus,
                                                            consequuntur maiores sed eligendi.</p>

                                                    </div>

                                                </div>
                                                <!--/.Card-->

                                                <!--Card-->
                                                <div class="card mb-4 wow fadeIn">

                                                    <div class="card-header font-weight-bold">
                                                        <span>About author</span>
                                                        <span class="pull-right">
                                    <a href="">
                                        <i class="fab fa-facebook-f mr-2"></i>
                                    </a>
                                    <a href="">
                                        <i class="fab fa-twitter mr-2"></i>
                                    </a>
                                    <a href="">
                                        <i class="fab fa-instagram mr-2"></i>
                                    </a>
                                    <a href="">
                                        <i class="fab fa-linkedin-in mr-2"></i>
                                    </a>
                                </span>
                                                    </div>

                                                    <!--Card content-->
                                                    <div class="card-body">

                                                        <div class="media d-block d-md-flex mt-3">
                                                            <img class="d-flex mb-3 mx-auto z-depth-1"
                                                                 src="https://mdbootstrap.com/img/Photos/Avatars/img (30).jpg"
                                                                 alt="Generic placeholder image"
                                                                 style="width: 100px;">
                                                            <div
                                                                class="media-body text-center text-md-left ml-md-3 ml-0">
                                                                <h5 class="mt-0 font-weight-bold">Caroline Horwitz
                                                                </h5>
                                                                At vero eos et accusamus et iusto odio dignissimos ducimus
                                                                qui blanditiis praesentium voluptatum deleniti atque
                                                                corrupti
                                                                quos dolores et quas molestias excepturi sint occaecati
                                                                cupiditate non provident,
                                                                similique sunt in culpa qui officia deserunt mollitia animi,
                                                                id est laborum et dolorum
                                                                fuga.
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            @endif
                        </textarea>
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
