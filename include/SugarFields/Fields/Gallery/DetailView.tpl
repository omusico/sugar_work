{*http://www.simplecoding.org/galleria-plagin-dlya-sozdaniya-galerej-s-kartinkami.html*}

{php}
global $current_language;
$app_list_strings = return_app_list_strings_language($current_language);
{/php}

{   assign var = images value = "^|^"|explode:{{sugarvar key='value' string = true}}     }

{   assign var = width value = {{sugarvar key='width' string = true}}     }

{   assign var = height value = {{sugarvar key='height' string = true}}     }
{   assign var = turn_on value = {{sugarvar key='turn_on' string = true}}     }


{assign var = upload_path     value = "upload/gallery_images/`$id`/"}



{if !empty($images.0)}

<div id="content-gallery">
    <a id="openGallery" href="#">{$APP.LBL_GALLERY_OPEN}</a>
    <div id="gallery"></div>
</div>

{*<script src="custom/include/GalleryField/Jcrop/js/jquery.min.js" type="text/javascript"></script>*}





<script type="text/javascript" language="javascript">


    {*function openImg(elem) {ldelim}*}
    {*YAHOO.dialog_img =*}
    {*new YAHOO.widget.Dialog(elem.id + '_div',*}
    {*{*}
    {*fixedcenter : true,*}
    {*visible : false,*}
    {*close: false,*}
    {*draggable: true,*}
    {*modal: true,*}
    {*constraintoviewport : true,*}
    {*buttons: [{ text:"Закрыть", handler: function(){this.hide()}, isDefault:true }]*}
    {*});*}
    {**}
    {*YAHOO.dialog_img.render();*}
    {**}
    {*YAHOO.util.Dom.setStyle([elem.id + '_div'], 'display', 'block');*}
    {**}
    {*YAHOO.dialog_img.show();*}
    {*{rdelim}*}



    SUGAR.util.doWhen("typeof $ != 'undefined'", function(){ldelim}

        jQuery.getScript("custom/include/GalleryField/Galleria/galleria.1.2.2.min.js", function(){ldelim}

            var images = [

                {assign var = i      value = 1}
                {assign var = count      value = $images|@count}

                {foreach item = image    from = $images}

                    {assign var = item      value = "^,^"|explode:$image}

                    {ldelim}
                        image: '{$upload_path}{$item.1}?qwer=' + Math.random(),
                        title: '{$item.0}',
                    {rdelim} {if $i < $count},{/if} //вся лабуда с i и условием для того, чтобы не выводилась последняя ненужная запятая

                    {assign var = i      value = $i+1}


                {*<img id="image_{$i}" src='{$upload_path}{$item.1}' style='height:80px;cursor:pointer;' title="Кликните для просмотра исходного изображения" onclick='openImg(this);'>*}

                {*<div id="image_{$i}_div" style="background-color:#333333;color:#FFFFFF;display:none">*}
                {*<div class="bd" style="text-align:center;"> <img src="{$upload_path}{$item.1}" style="max-width: 1200px;max-height: 500px;"/> </div>*}
                {*</div>*}

                {/foreach}

            ];



            var gallery = $("#gallery");

            Galleria.loadTheme('custom/include/GalleryField/Galleria/themes/simplecoding/galleria.simplecoding.js');


            function openGal()
            {ldelim}
                $("#gallery").galleria(
                        {ldelim}
                            data_source: images,
                            //width: {$width},
                            height:{$height},
                            autoplay: false,
                            clicknext: true,
                            imageCrop: false,
                            debug: false,
                            show:{{$position}}
                        {rdelim});
                $('#openGallery').css('display', 'none');
                return false;
            {rdelim}



            $('#openGallery').click(function()
            {ldelim}
                openGal();
                return false;
            {rdelim});



            {if !empty($turn_on)}
                openGal();
            {/if}

        {rdelim});
    {rdelim});
</script>


    {else} <b>{$APP.LBL_GALLERY_WARN}</b>
{/if}


