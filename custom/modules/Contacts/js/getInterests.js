/**
 * Created by Kolerts
 * Protected by SugarTalk.ru
 */

$(document).ready(function() {

    $('#realty_name').live('click', function(){
		if(!$('#realty_name_interests').length)
			$(this).parent().append('<button type="button" id="realty_name_interests" title="Выбрать из интересующих" class="button" value="Выбрать" onclick="getInterests();"><img src="themes/default/images/id-ff-down.png"/></button>');
    });
	$('._realty_interests_ li').live('click',function(){
		$('#realty_name').val($(this).text());
		$('#realty_id').val($(this).attr('record'));
		$('#realty_interests_div').html('');
	});
});

function getInterests(){
	if(!$('#realty_interests_div').length)
		$('#realty_name').parent().append("<div id='realty_interests_div'>searching..</div>");
	else
		$('#realty_interests_div').html('searching..');
	var link='index.php?module=Realty&action=getInterests&to_pdf=1&record='+document.DetailView.record.value;
	$.ajax({
            url: link,
            type: "GET",
            async: false,
            success: function(data){
               $('#realty_interests_div').html(data);
            }
	}); 
}