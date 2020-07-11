function checkGenreSelect(el) {
    if($(el).val() === "default") {
        $("#inputNewGenre").attr('disabled',false);
        $("#inputNewGenre").attr('required',true);
    } else {
        $("#inputNewGenre").attr('disabled',true);
        $("#inputNewGenre").attr('required',false);
    }
}

function checkGenreInput(el) {
    if($(el).val().length === 0) {
        $("#inputGenre").attr('disabled',false);
        $("#inputGenre").attr('required',true);
    } else {
        $("#inputGenre").attr('disabled',true);
        $("#inputGenre").attr('required',false);
    }
}

function deleteConfirmation(el, url, token) {

    if(confirm("Si si istý?")){
        ajaxDelete(el, url, token);
    }
    else{
        return false;
    }

}

function ajaxDelete(el, url, token){

    $.ajax({
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': token,
            "X-HTTP-Method-Override": "DELETE"
        },
        success: function(data) {

            $(el).parent().hide();

        }
    });
}
