/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */

    function custom_open_popup()
    {
        open_popup(
            "Sections",
            600,
            400,
            "",
            true,
            false,
            {"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"section_id","name":"section_name"}},
            "single&building_id_advanced="+$('#building_id').val(),
            true
        );
    }



