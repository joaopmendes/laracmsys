
$(window).on("load", () => {
    const rowTemplate = `<tr>
                            <td scope="row">%id%</td><td>%name%</td>
                            <td><img width="70px" height="70px" src="%img_src%"></td>
                            <td>
                                <button class="clipboard btn btn-sm btn-outline-primary" value="%img_src%">Copy To Clipboard</button>
                                <form method="POST" action="http://127.0.0.1:8000/backoffice/file/%id%"  accept-charset="UTF-8" class="d-inline"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value=%csrf%>
                                <span class="waves-input-wrapper waves-effect waves-light"><input class="btn btn-sm btn-outline-danger" type="submit" value="Delete"></span>
                                </form>
                            </td>
                        </tr>`;



    $.getJSON(window.getAllFilesUrl,
        (data) => {
            data.forEach(file => {
                let template = rowTemplate;
                template = template
                    .replace(/%id%/g, file.id)
                    .replace(/%name%/g, file.name)
                    .replace(/%csrf%/g, $('meta[name="csrf_token"]').prop('content'))
                    .replace(/%img_src%/g, $('meta[name="APP_URL"]').prop('content') + '/storage/' + file.path);
                $("#image_table tbody").append(template);
            })
        }
).then(() =>{
        $(".clipboard").on('click', function (event) {
            event.preventDefault();
            // trigger modal top right

            navigator.clipboard.writeText(event.target.value).then(function () {
                console.log('Async: Copying to clipboard was successful!');
            }, function (err) {
                console.error('Async: Could not copy text: ', err);
            });

            $('#clipboard_modal').modal('show');
            setTimeout(() => {
                $('#clipboard_modal').modal('hide')
            }, 5000);
        } )
    })
});
