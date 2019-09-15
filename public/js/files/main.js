
$(window).on("load", () => {

    function getImagesData() {
        // language=HTML
        const rowTemplate = `<div class="grid-item shadow-lg position-relative" id="%id%">
                                <img src="%img_src%" class="img-fluid">
                                <div class="group-buttons">
                                    <a class="btn custom-btn btn-info clipboard" data-toggle="tooltip" data-placement="right" title="Copy url to the clipboard">
                                        <i class="far fa-clipboard"></i>
                                    </a>
                                    <form method="POST" action="%delete_route%"  accept-charset="UTF-8" class="d-inline"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value=%csrf%>
                                    <span class="waves-input-wrapper waves-effect waves-light"><input class="btn custom-btn btn-danger" type="submit" value="X" data-toggle="tooltip" data-placement="right" title="Delete the image"></span>
                                </form>
                                </div>
                             </div>`;
        $.getJSON(window.getAllFilesUrl)
            .then((data) => {
                data.forEach(file => {
                    let template = rowTemplate;
                    template = template
                        .replace(/%id%/g, file.id)
                        .replace(/%name%/g, file.name)
                        .replace(/%delete_route%/g, $('meta[name="APP_URL"]').prop('content') + '/backoffice/file/' + file.id)
                        .replace(/%csrf%/g, $('meta[name="csrf_token"]').prop('content'))
                        .replace(/%img_src%/g, $('meta[name="APP_URL"]').prop('content') + '/storage/' + file.path);

                    $("#image-container-grid").append(template);
                });
                $(".clipboard").on('click', function (event) {
                    event.preventDefault();
                    navigator.clipboard.writeText(event.target.src).then(r => {});
                });
            })
    }

    getImagesData();

    

});
