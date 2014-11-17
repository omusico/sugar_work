$(document).ready(function() {
	
});

function assisRefresh(event) {
    var assis_id = event.target.previousSibling.value;
    refresh_btn = event.target;
    $.ajax({
        type: 'POST',
        url: "http://sugar-work/index.php?module=Realty&action=getInfoAboutAssisObj&to_pdf=1",

        // the name of the callback parameter, as specified by the YQL service
        json: "callback",

        // tell jQuery we're expecting JSONP
        dataType: "json",

        // tell YQL what we want and that we want JSON
        data: {
                       id: assis_id
        },

        // work with the response
        success: function( respons ) {
             // server response
             refresh_btn.nextSibling.innerHTML = 'Assis status: ' + respons.result.status;
        }
    });

}

