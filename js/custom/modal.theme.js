function thMetaOpen(){
    var bg = $('#theme');
    var sc = 'selectedColour';
    
    bg.find('a').click(function(){
        bg.find('.'+sc).removeClass(sc);
        $(this).addClass(sc);
        thSave();
    });
}

function thSave(){
    var bg = $('#theme');
    var sc = bg.find('.selectedColour');
    var th = sc.attr('title');
    
    $('head').append('<link href="css/userstyles.php?t='+th+'" rel="stylesheet">');
    
    var data = {
        theme: th
    }
    
    $.ajax({
        type: "POST",
        url: self+'ajax/saveTheme.php',
        data: data
    });
}