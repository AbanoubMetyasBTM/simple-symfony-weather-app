var ajaxLoaderImgFunc;
var baseUrl;

$(function () {

    baseUrl           = $(".base_url").val();
    ajaxLoaderImgFunc = function () {
        return $(".load_parent_div").html();
    };

    $("body").on("click", ".get_result", function () {

        const formElement = $(this).parents("form");
        const formData    = new FormData(formElement[0]);

        console.log("clicked");

        $(".weather_parent_div").html(ajaxLoaderImgFunc());

        $.ajax({
            url: formElement.attr("action"),
            type: 'POST',
            cache: false,
            processData: false,
            contentType: false,
            data: formData,
            error: function (request, status, error) {
                console.log(error);
                $(".weather_parent_div").html("error happen, please refresh");
            },
            success: function (data) {
                $(".weather_parent_div").html(data);
            }
        });


        return false;

    });


});