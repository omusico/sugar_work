$(document).ready(function(){  


   $('#reports').change(function () {

    if($("#reports").val() == '0'){

        $('#list_data').css("display", "none");
        $("#list_label").html('');
        
    }
    if($("#reports").val() == '1'){

        $("#users").html('');
        $('#list_data').css("display", "block"); 
        $("#list_label").html('Сотрудники:');

        $.getJSON('index.php?module=ZuckerReports&action=htmlReportsAction&to_pdf=1&type_report=users_list', function(data){
            jQuery.each(data, function(key, val){

                $("#users").append ('<option value="'+val.user_id+'">'+val.user_name+'</option>');           
            });
        });               
    }
    if($("#reports").val() == '2'){

        $("#users").html('');
        $('#list_data').css("display", "block"); 
        $("#list_label").html('Источник контакта:');

        $.getJSON('index.php?module=ZuckerReports&action=htmlReportsAction&to_pdf=1&type_report=source_list', function(data){
            jQuery.each(data, function(key, val){

                $("#users").append ('<option value="'+val.source_id+'">'+val.source_name+'</option>');           
            });            
         });
    }

   });

   $('#generate_report').click(function(){

        var date_time_start = $('#date_time_start').attr('value');
        var date_time_end = $('#date_time_end').attr('value');     

            var date_time_start = $('#date_time_start').attr('value');
            var date_time_end = $('#date_time_end').attr('value');

            if(!date_time_start.length){
                date_time_start = 1;
            }                  
            if(!date_time_end.length){
                date_time_end = 1;
            }       
            var dataUsers = $('#users').val();  
           
            if ($('#reports').val() == '1')
            {
                $.ajax({
                    url: 'index.php?module=ZuckerReports&action=htmlReportsAction&to_pdf=1&type_report=quality_manager&date_time_start='+date_time_start+'&date_time_end='+date_time_end+'&dataUsers='+dataUsers,
                    type: "GET",
                    async: false,
                    success: function(data)
                    {
                        $("#graph").html(''); 
                        $('#table_container').html(data);                        
                    }
                }); 
            }      

            if ($('#reports').val() == '2')
            {
                $.ajax({
                    url: 'index.php?module=ZuckerReports&action=htmlReportsAction&to_pdf=1&type_report=quality_source&date_time_start='+date_time_start+'&date_time_end='+date_time_end+'&dataUsers='+dataUsers,
                    type: "GET",
                    async: false,
                    success: function(data)
                    {
                        $("#graph").html(''); 
                        $('#table_container').html(data);
                    }
                }); 
            } 

            if ($('#reports').val() == '2')
            {

                $.getJSON('index.php?module=ZuckerReports&action=htmlReportsAction&to_pdf=1&type_report=diagramm_source&date_time_start='+date_time_start+'&date_time_end='+date_time_end+'&dataUsers='+dataUsers, function(data){
                    
                    $("#graph").html(''); 
                    myData = new Array();
                    colors = new Array();
                    jQuery.each(data, function(key, val){

                        myData.push(new Array(val.source_name,val.source_res));                        
                        colors.push(val.source_color);
         
                    });
                   
                var myChart = new JSChart('graph', 'pie');
                myChart.setDataArray(myData);
                myChart.colorizePie(colors);
                myChart.setTitle('');
                myChart.setTitleColor('#8E8E8E');
                myChart.setTitleFontSize(11);
                //myChart.setTextPaddingTop(10);
                myChart.setPieUnitsColor('#8F8F8F');
                myChart.setPieValuesColor('#6E6E6E');
                //myChart.setSize(1000, 321);
                //myChart.setPiePosition(578, 145);
                myChart.setPieRadius(85);
                myChart.draw(); 

                });;
                    
                    setTimeout(hide_img, 1000);                    
            } 
   });

    function hide_img()
    {        
        $("#map_JSChart_graph").next().hide();
    }


});  



  

