

function showStatus( status, activity )
{
    switch (activity) {
        case 'Tasks':
            if( status.val() == "Completed" ) {
                hideStatus( false );
            } else {
                hideStatus( true );
            }
            break;
        case 'Meetings':
        case 'Calls':
            if( status.val() == "Held" || status.val() == "Not Held" ) {
                hideStatus( false );
            } else {
                hideStatus( true );
            }
            break;
    }
}

function hideStatus( hide )
{
    var show_results = $("#show_results");
    if( hide === true ){
       show_results.css( "display", "none" );
       show_results.parent().prev().css( "visibility", "hidden" );
       removeFromValidate("EditView", show_results[0].name);
    } else {
       show_results.css( "display", "" );
       show_results.parent().prev().css( "visibility", "visible" );
       addToValidate("EditView", show_results[0].name, "text", true, 'Результат');
    }

}