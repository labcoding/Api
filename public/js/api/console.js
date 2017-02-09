function sendRequest() {
    $('.request').html('');
    $('.response').html('');
    $('.response-headers').html('');
    $('.response-code').html('');

    var url = $('#query').val();
    var method = $('#method-btn').text().trim();
    var data = $('#post-body textarea').val().trim();

    if (method == 'GET') {
        $('.request').html(method + ' ' + url + "\n");
        data = null;
    } else {
        $('.request').html(method + ' ' + url + "\n\n" + data);
    }

    $.ajax(url, {
        type: method,
        data: data,
        dataType: 'json',
        contentType: "application/json",
        beforeSend: function (request) {
            // request.setRequestHeader("Authorization", "Bearer " + Cookies.get('accessToken'));
        },
        async: false,
        success: renderResponse,
        complete: function (XMLHttpRequest, textStatus) {
            if (XMLHttpRequest.status == 200) {
                $('.response-headers').append(XMLHttpRequest.status + " OK");
                $('.response-code').html(XMLHttpRequest.status + " OK");
            }
            $('.response-headers').append("\n" + XMLHttpRequest.getAllResponseHeaders());
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            if (textStatus == 'timeout') {
                $('.response-headers').append("The server is not responding");
                console.log('The server is not responding');
            }

            if (textStatus == 'error') {
                $('.response-headers').append(XMLHttpRequest.status + " " + errorThrown);

                $('.response-code').html(XMLHttpRequest.status + " " + errorThrown);
            }

            var response = JSON.stringify(XMLHttpRequest.responseJSON, null, 4);
            $('.response').html(response);
        }
    });
}

function renderResponse(data) {
    var response = JSON.stringify(data, null, 4);
    $('.response').html(response);
}

$(function () {
    $('#send-btn').click(function () {
        sendRequest();
    });
    $('#query').keypress(function (e) {
        if (e.which == 13) {
            sendRequest();
            return false;
        }
    });

    $('#query-builder').on('click', '#methods a', function () {
        var method = $(this).text();
        var target = $(this).data('target');

        $('#method-btn').html(method + ' <span class="fa fa-caret-down"></span>');

        if (target == "post") {
            $('#post-body').fadeIn();
        } else {
            $('#post-body').fadeOut();
        }
    });
});
