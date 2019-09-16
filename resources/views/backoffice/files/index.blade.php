@extends('backoffice.layout.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/basic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
@endsection
@section('js')

    <script src="{{ asset('js/dropzone.js') }}"></script>
    <script>
        window.getAllFilesUrl = "{{ route("file.getAllFilesJson") }}";
    </script>
    <script src="{{ asset('js/files/main.js') }}"></script>

@endsection


@section('content')
    <div class="row">
        <div class="col-md-8 offset-2 mt-5 position-relative">
            <div class="row">
                <h3 class="text-center text-muted w-100">
                    Show Files

                </h3>
                <button type="button" style="right: -10px" class="btn position-absolute btn-primary btn-sm float-right d-sm-block d-inline" data-toggle="modal" data-target="#uploader">
                    Upload Files
                </button>
            </div>
            <hr>
            <small class="text-muted text-center w-100 d-block mb-2">Click the images to return the link</small>
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
                <div class="image-container-grid" id="image-container-grid">

                </div>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade right" id="clipboard_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true" data-backdrop='false'>
            <div class="modal-dialog modal-sm modal-side modal-top-right" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Image path copied to clipboard
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal -->

    </div>
    @include('backoffice.files.uploader')

@endsection
