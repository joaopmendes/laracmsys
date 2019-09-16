

<!-- Modal -->
<div class="modal fade" id="uploader" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">File Uploader</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="file-uploader">
                    <form method="POST" action="{{ route('file.store') }}"
                          enctype="multipart/form-data" class="dropzone" id="my-dropzone">
                        {{ csrf_field() }}
                        <div class="dz-message">
                            <div class="col-xs-8">
                                <div class="message">
                                    <p>Upload your files</p>
                                </div>
                            </div>
                        </div>
                        <div class="fallback">
                            <input type="file" name="file[]" multiple>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="closeModal()"
                        }>Save</button>
            </div>
        </div>
    </div>
</div>
