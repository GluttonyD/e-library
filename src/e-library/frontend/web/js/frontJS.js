var order='';

$(document).ready(function () {
    $(document).on("submit", "form#search-form", function (e) {
        $(".glyphicon").click(function(event) {
            order=event.target.id;
        });
        e.preventDefault();
        var url='/library/search-publications?order='+order;
        console.log(url);
        var form = $(e.target);
        var data_new = new FormData(this);
        $.ajax({
            url: url, // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            dataType: 'json',
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false,        // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                // console.log(data[0]);
                var i;
                var input='<b>Результаты поиска :</b>';
                console.log(data);
                if(data!=null) {
                    for (i = 0; i < data.length; i++) {
                        input = input +
                            '<div class="row" style="border: 1px solid #000000">' +
                            '<div class="col-md-9">' +
                            '<p style="font-size: small">' +
                            data[i]['name'] +
                            '</p>' +
                            '</div>';
                        input = input + '<div class="col-md-1">';
                        if (data[i]['file'] != null) {
                            input = input +'<a href="/' + data[i]['file'] + '" class="glyphicon glyphicon-folder-open"></a>';
                        }
                        input=input+ '</div>';
                        input = input + '<div class="col-md-1">' +
                            '<a href="/library/info?publication_id=' + data[i]['id'] + '" class="glyphicon glyphicon-zoom-in"></a>' +
                            '</div>';
                        input = input + '</div>';
                    }
                }
                console.log(input);
                $('#publications').html(input);
                $('#pagination').remove();
            }
        });
    });
});