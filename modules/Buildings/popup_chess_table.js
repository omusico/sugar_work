
$(document).ready(function(){
    var p = $('.popup__overlay');
    p.click(function(event) {
        var e = event || window.event;
        if (e.target == this) {
            $(p).fadeOut('fast');
            $('body').css('overflow','auto');
            return false;
        }
    });
    $('.popup__close').click(function() {
        p.fadeOut('fast');
        $('body').css('overflow','auto');
        return false;
    });
});

function openPopupWin(floor, sec_id){
    $("#section_cht").val(sec_id);
    $('#floor_cht').val(floor);
    $('#desc_popup_floor').text(" Объект будет размещён на "+floor+" этаже");
    var p = $('.popup__overlay');
//    $('.popup__toggle').click(function() {
    p.fadeIn('fast');
    $('body').css('overflow','hidden');
//    });
}

function create_obj(build_id, floor, tpl_id, sec_id)
{
    var url = 'index.php?module=Buildings&entryPoint=create_tpl_obj&to_pdf=1&floor='+floor+'&tpl_id='+tpl_id+'&building_id='+build_id;
    if(sec_id !== "") url += "&section_id="+sec_id;
    $.get(url, function(data){
        alert(data);
        window.location.reload(false);
    });
}