//JS for the modal search engines
function updateEngines(){
    $.ajax({
        type: 'POST',
        url: self+'ajax/saveEngines.php',
        data: {type:'update'},
        success: function(rep){
            $('#user_engines').html(rep);
            onMainSearchLoad();
            //add the modal click again
            $('#user_engines .modal-link').click(function(){
                $(this).modalx();
            });
        }
    }); 
}

function adjustDefault(id){//function to change the default search engine for the user
    var current = $('#engine_settings .icon-star');
    var fi = id.find('.fav-icon');
    var s_id = id.attr('data-id');
    var c_div = current.parent().parent();
    var c_id = c_div.attr('data-id');
    var btn = id.find('.normal');
    var cbtn = c_div.find('.normal');
    var star = 'icon-star';
    var empty = 'icon-star-empty';

    
    if(fi.hasClass(empty)){ //make it the default
        fi.removeClass(empty).addClass(star);
        //Check what to do now
        if(!btn.hasClass('own')){ //Do not own the engine? Now you do!
            saveEngine(s_id,'default-and-add');            
        }
        else{
            saveEngine(s_id,'default-add'); 
        }
    }
    
    if(current.length == 1){
        //We need to remove the current default cause you can only have one
        saveEngine(c_id,'default-remove');
        current.removeClass(star).addClass(empty);
    }
}

function saveEngine(id,action){
    
    var engine = $('#engine'+id);
    var btn = engine.find('.normal');
    
    btn.unbind('mouseenter mouseleave');
    btn.unbind('click');
    
    var data = {
        action: action,
        id: id,
        type: 'save'
    };
    
    $.ajax({
        type: 'POST',
        url: self+'ajax/saveEngines.php',
        data: data,
        success: function(rep){
            var eles = btn.find('.normal, .fav-icon-b');
            if(action == 'add'){
                showButton(engine,'own');
                eles.addClass('btn-info');
                removeEngine(engine);
            }
            else if(action == 'remove'){
                showButton(engine,'normal');
                eles.removeClass('btn-info');
                addEngine(engine);
            }
            else{
                showButton(engine,'own');
                removeEngine(engine);
            }

        }
    });
}

function showButton(id, btn){
    var eles = id.find('.normal, .fav-icon-b');
    if(btn == 'remove'){
        eles.removeClass('btn-info btn-success').addClass('btn-danger');
    }
    else if(btn == 'own'){
        eles.removeClass('btn-danger').addClass('btn-info own');
    }
    else if(btn == 'add'){
        eles.removeClass('btn-info').addClass('btn-success');
    }
    else if(btn == 'normal'){
        eles.removeClass('btn-success btn-danger btn-info own');
    }
}

function removeEngine(id){
    var normal = id.find('.normal');
    normal.hover(function(){
        showButton(id,'remove');
    }, function(){
        showButton(id,'own');
    });
    
    normal.click(function(){
        if($('#engine_settings .btn-info').length > 1){
            var e_id = id.attr('data-id');
            e_id = parseInt(e_id);
            saveEngine(e_id,'remove');
            var icon = id.find('.fav-icon');
            if(icon.hasClass('icon-star')){
                icon.removeClass('icon-star').addClass('icon-star-empty');
            }
        }
    });
}

function addEngine(id){
    var normal = id.find('.normal');
    normal.hover(function(){
        showButton(id,'add');
    }, function(){
        showButton(id,'normal');
    });
    
   normal.click(function(){
        var e_id = id.attr('data-id');
        e_id = parseInt(e_id);
        saveEngine(e_id,'add');
    });
}

function loadEngines(){
 //function for the loading of the engines settings   
    var body = $('#engine_settings');
    var btn = body.find('.btn-group');
    var list = $('.main-search-list li');
    var listArr = Array();
    
    list.each(function(){
        listArr.push($(this).find('a').attr('data-name'));
    });
    
    btn.each(function(){
        var thisGroup = $(this);
        var normal = thisGroup.find('.normal'); 
        var dft = thisGroup.find('.fav-icon-b');
        var name = normal.find('span').html();
        var s_id = thisGroup.attr('data-id');
        if($.inArray(name, listArr) > -1){
            normal.addClass('btn-info own');
            thisGroup.find('.fav-icon-b').addClass('btn-info');
            removeEngine(thisGroup);
            if($('#he'+s_id).attr('data-dft') == 'true'){
                dft.find('.fav-icon').removeClass('icon-star-empty').addClass('icon-star');
            }
        }
        else{
            addEngine(thisGroup);
        }
        dft.click(function(){
           adjustDefault(thisGroup); 
        });
    });
    
}