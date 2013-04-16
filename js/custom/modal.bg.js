function bgMetaOpen(){
    var bg = $('#background');
    var sc = 'selectedColour';
    
    bg.find('a').click(function(){
        bg.find('.'+sc).removeClass(sc);
        $(this).addClass(sc);
        bgSave();
    });
}

function bgSave(){
    var bg = $('#background');
    var sc = bg.find('.selectedColour');
    var img = sc.css('background');
    
    $('body').css('background','none');
    $('body').css('background',img);
    //$('#modal-background').modal('hide');
    
    if(sc.css('background-image') == 'none'){
        var bg = sc.css('background-color');
    }
    else{
        var bg = sc.css('background-image');
    }
    
    var data = {
        bg: bg
    }
    
    $.ajax({
        type: "POST",
        url: self+'ajax/saveBg.php',
        data: data
    });
}