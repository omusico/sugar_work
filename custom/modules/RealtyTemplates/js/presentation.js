


(function($, undefined){

    $(document).ready(function(){
        //$("#presentation_array").css("display","none");
        
        $(".presentationC").live('click',function(){
            var ln;
            if($(this).prop("checked"))
                {
                    ln=1;
                }
            else
                {
                    ln=0; 
                }
            $.ajax({
            url: 'index.php?module=Realty&action=ajax&checked='+ln+'&id='+$(this).val()
            }); 

        });
        $(".presentationA").live('click',function(){
            var ln;
            if($(this).prop("checked"))
                {
                    ln=1;
                }
            else
                {
                    ln=0; 
                }
            $.ajax({
            url: 'index.php?module=Realty&action=ajax2&checked='+ln+'&id='+$(this).val()
            }); 

        });
        $(".presentationR").live('click',function(){
            var ln;
            var realty_id;
            realty_id = getUrlVars()["record"];
            if($(this).prop("checked"))
                {
                    ln=1;
                }
            else
                {
                    ln=0; 
                }
            $.ajax({
            url: 'index.php?module=Realty&action=ajax3&checked='+ln+'&id='+$(this).val()+'&realty_id='+realty_id
            }); 

        });
    });
    
    function changedone(ln, id)
    {    
        $.ajax({
            url: 'index.php?module=Realty&action=ajax&checked='+ln+'&id='+id
        });
    }

    function getUrlVars()
    {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
})(jQuery);