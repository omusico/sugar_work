function sql_backup()
{
    $('#b-popup').show();
    var x;
    if (confirm("Подтвердите возобновление данных") == true) 
    {
        $.ajax({
            url: 'index.php?module=Import&action=importajax&to_pdf=true',
            dataType: 'json',
            type: 'post',
            success: function(data)
            {
                $('#b-popup').hide();
                alert(data);
            }
        });
    } 
    else
    {
        $('#b-popup').hide();
    }  

};

$(document).ready(function(){
    $("ul.jlevel").hide();//Свернули все вложенные списки
    $("span.expand").click(function(){
        var e = $(this).next();
        e.slideToggle("fast");//Сворачиваем/разворачиваем
    });
});
