
$(document).ready(function(){
	if(module_sugar_grp1=='Realty' || module_sugar_grp1=='Opportunities'){
		$contact = $('#contact_id');
		if($contact.text()!=''){
			$contact_url=$contact.parent().attr('href');
			$url_parts = $contact_url.split('record=');
			$('#parent_name').val($contact.text());
			$('#parent_id').val($url_parts[1]);
			$contact_name = $('#contact_name');
			$contact_name.val($contact.text());
			$contact_name.parent().children().eq(2).val($url_parts[1]);
		}
	}
});