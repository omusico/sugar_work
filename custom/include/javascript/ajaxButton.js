    function ajaxButton(subpabel, record, parent_record_id, from_module, current_module, $reload)
    {
        $.ajax({
            
            type: 'GET',
            url:'index.php',
            data: 
            {
                module:current_module, 
                action:'Loadrel', 
                subpabel:subpabel, 
                id_record:record, 
                parent_record_id:parent_record_id, 
                from_module:from_module 
            },
            success: function(){
				if($reload)
					window.location.reload(false); 
            }
            
        });
    }
    
    function inform(name, current_module, from_module)
    {
        if(current_module=='Realty')
        {
            if(from_module == 'Contacts')
                return confirm("Вы точно хотите добавить - ["+name+"] в интересующиеся физ. лица ?");
            if(from_module == 'Accounts')
                return confirm("Вы точно хотите добавить - ["+name+"] в интересующиеся юр. лица ?");
            else
                return confirm("Вы точно хотите закрепить запрос '"+name+"'?");
        }
        else return confirm("Вы точно хотите добавить - "+name+" в интересующую недвижимость?");
    }
    


