
$(window).on("load", () => {

    function getImagesData() {
        const rowTemplate = `<div class="grid-item shadow-lg position-relative" id="%id%">
                                <img src="%img_src%" class="img-fluid">
                                <div class="group-buttons">
                                    <a class="btn custom-btn btn-info clipboard">X</a>
                                    <a href="%delete_route%/%id%" class="btn custom-btn btn-danger">X</a>

                                </div>
                             </div>`;
        $.getJSON(window.getAllFilesUrl)
            .then((data) => {
                data.forEach(file => {
                    let template = rowTemplate;
                    template = template
                        .replace(/%id%/g, file.id)
                        .replace(/%name%/g, file.name)
                        .replace(/%delete_route%/g, $('meta[name="APP_URL"]').prop('content') + '/backoffice/file/delete/' + file.path)
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
