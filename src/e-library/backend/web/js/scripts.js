var current_author = 0;
var current_penname = 0;
var clickID;
var order='';
$(document).ready(function () {
    current_author = $('#authors').data('authors_count');
    current_penname = $('#pennames').data('count');
    console.log(current_author);
});
$(document).on("click", "#add-fields", function (e) {
    e.preventDefault();
    var input;
    current_author++;
    var author_number = 'author_' + current_author;
    input = '<div id="' + author_number + '">' +
        '<h4>Автор</h4>' +
        '<p><label for="author_name">ФИО</label><input id="author_name_' + current_author + '" class="form-control author" style="width: 250px" type="text" name="Publications[authors][' + current_author + '][name]" value="" autocomplete="off"></p>' +
        '</div>';
    $("#authors").append(input);
    console.log(current_author);

});
$(document).on("click", "#delete-fields", function (e) {
    e.preventDefault();
    var author_number = 'author_' + current_author;
    var author_id = $('#author_name_' + current_author).data('id');
    var publication_id = $('#publication-form').data('publication_id');
    $('div#' + author_number).remove();
    if (current_author > 0)
        current_author--;
    $.ajax({
        url: '/author/author-erase', // Url to which the request is send
        type: "GET",             // Type of request to be send, called as method
        data: {author_id: author_id, publication_id: publication_id}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        cache: false,             // To unable request pages to be cached
        success: function (data)   // A function to be called if request succeeds
        {
            console.log(data);
        }
    });
});

$(function () {
    $('#publication-edition').autocomplete({
        serviceUrl: '/autocomplete/autocomplete-edition',
        minLength: 2,
        lookupLimit: 10,
        type: 'GET',
        data: {data: $('#publication-edition').val()},
        paramName: 'edition',
        dataType: 'json',
        transformResult: function (response) {
            return {
                suggestions: response
            };
        },
        onSelect: function (suggestion) {
            $('#publication-edition').val(suggestion.value);
        }
    });

});
$(document).ready(function () {
    $('#authors').on('click', '.author', function () {
        $(function () {
            $('.author').autocomplete({
                serviceUrl: '/autocomplete/autocomplete-authors',
                minLength: 2,
                lookupLimit: 10,
                type: 'GET',
                data: {data: $(clickID).val()},
                paramName: 'author_name',
                dataType: 'json',
                transformResult: function (response) {
                    console.log(response);
                    return {
                        suggestions: response
                    };
                },
                onSelect: function (suggestion) {
                    console.log(suggestion.value);
                }
            });

        });
    });
});
$(document).ready(function () {
    $('.author').click(function () {
        clickID = '#' + $(this).attr('id');
        console.log(clickID);
    });
});
$(document).ready(function () {
    $('#author').on('click', '.add-penname', function (e) {
        e.preventDefault();
        console.log($(this).attr('id'));
        var input = '<div id="' + current_penname + '" class="row" style="margin-bottom: 20px">' +
            '<label class="col-md-1">Псевдоним</label><input type="text" value="" name="Authors[pennames][' + current_penname + '][penname]" class="form-control col-md-4" style="width: 300px">' +
            '</div>';
        current_penname++;
        $('#pennames').append(input);
        console.log(current_penname);

    });
});

$(document).on("click", "#remove-penname", function (e) {
    e.preventDefault();
    var id = current_penname - 1;
    var penname_id = $('#' + id).data('id');
    $('div#' + id).remove();
    if (current_penname > 0)
        current_penname--;
    console.log(penname_id);
    $.ajax({
        url: '/author/penname-erase', // Url to which the request is send
        type: "GET",             // Type of request to be send, called as method
        data: {penname_id: penname_id}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        cache: false,             // To unable request pages to be cached
        success: function (data)   // A function to be called if request succeeds
        {
            console.log(data);
        }
    });
});
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
                            '<a href="/library/add-publication?publication_id=' + data[i]['id'] + '" class="glyphicon glyphicon-pencil"></a>' +
                            '</div>';
                        input = input + '<div class="col-md-1">' +
                            '<a href="/library/delete-publication?publication_id=' + data[i]['id'] + '" class="glyphicon glyphicon-remove"></a>' +
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
