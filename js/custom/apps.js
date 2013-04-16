//JS for apps and app list (adding, removing, moving etc)

function onMainAppListLoad(){
    var resizeTimer;
    var applist = $('#apps-list');
    var body = $('#content');
    var inner = $('#content-apps');
    var master = $('.app-master')[0].outerHTML;
    var notloaded = inner.find('.notloaded');

    //define height for the app area
    resizeArea();

    //the first thing we need to do is check if we need to add columns on load
    if(notloaded.length > 0){
        //apps! show em!
        notloaded.each(function(){
            //show the app
            $(this).fadeIn('fast');
            //get the manifest and load data
            var appnameLower = $(this).attr('data-name').toLowerCase();
            var manifest = apps+appnameLower+'/'+$(this).attr('data-man');
            getManny($(this),manifest);
            //no longer need the manifest data so remove it
            $(this).removeAttr('data-man');
            $(this).removeClass('notloaded');
        });
    }


    applist.find('li a').click(function(){
        //add clicks for the app list apps..

        //first we add the column with meta data for the user then add the loaded data
        var appname = $(this).attr('data-name');
        var appnameLower = $(this).attr('data-name').toLowerCase();
        var appbg = $(this).attr('data-bg');
        var appcolor = $(this).attr('data-color');
        var manifest = $(this).attr('data-m');
        var appID = $(this).attr('data-id');
        var num = 1;
        var id = 'flavrl-app-'+appnameLower+'-'+num;

        inner.append(master);
        
        while($('#'+id).length == 1){
            //console.log(id.attr('id')+' is there!')
            num++;
            var id = 'flavrl-app-'+appnameLower+'-'+num;
        }
        body.find('.app-column:last').attr('id',id);
        var id = $('#'+id);
        id.addClass('flavrl-app-'+appname);
        id.find('.app-name').html(appname);
        id.find('.app-header').css({"background": appbg, "color" : appcolor});
        id.removeClass('notloaded app-master');

        //construct data to save to server
        var data = {
            type: 'add',
            id: appID
        }
        //save app to the server
        saveApp(id,data);

        //get the data!
        getManny(id,apps+appname+'/'+manifest);

    });


    //Add resize event for adjusting the height of the app area
    $(window).resize(function(){
        //we sent a timeout so the adjustment only happens when
        //the user stops resizing their window
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(resizeArea, 100);
    });
}

function resizeArea(){
    var body = $('#content-apps');
    var ac = body.find('.app-column');
    var math = $(window).height()-60;
    body.height(math);
    ac.height(math-2);
}

function addScrollBar(action,id){
    //add the custom scrollbar
    var body = id.find(".app-body");
    var cb = id.find('.mCSB_container');
    var sb = id.find('.mCSB_scrollTools');
    if(action == 'add'){
        setTimeout(function(){
            body.mCustomScrollbar();
            //some margin fix
            id.find('.mCSB_container').css('margin-right','0px')
            //lets add the hover power because it looks so cool! ya!
            id.hover(function(){
                sb.addClass('show');
            },function(){
                sb.removeClass('show');
            });
        },300);
    }
    else if(action == 'update'){
        //check
        body.mCustomScrollbar("update");
    }
}

function saveApp(id,data){
    var type = data.type;

   $.post(self+'ajax/saveApp.php',data,function(rep){
        if(type == 'add'){
            //we need to add the returned id of the app for later use
            id.attr('data-column-id',rep)
        }
        console.log(rep);
    });
}

function getManny(id,manifest){
    //get data and events etc from the manifest
    $.getJSON(manifest,function(rep){
            /*$.each(rep, function(key, value) {
                console.log(key)
            });*/
            //set vars
            var name = rep.name;
            var url = rep.url;
            var modes = rep.modes;
            var scripts = rep.scripts;
            var styles = rep.styles;
            var parser = rep.parser;
            var events = rep.events;
            var resized = rep.resize;
            var data = rep.data;

            //first lets load the styles
            var ss = '<link href="'+url+styles+'" rel="stylesheet">';
            $('head').append(ss);

            

            //now the js
            $.getScript(url+scripts,function(){
                //now use the parser to create the html with the data
                //For now, the parameters used for the parser function should be:
                //id (given by flavrl) then one para for the data array
                window[parser](id,data);

                //now we have some data the user can see, so lets show it!
                id.find('.app-loading').fadeOut('fast',function(){
                    id.find('.notloaded').fadeIn('fast');
                    id.find('.notloaded').removeClass('notloaded');
                });
                //then we use the given function to add the events and listeners
                window[events](id);
                //resize events of column
                //column resizable
                id.resizable({
                  handles: 'e',
                  minWidth: 310,
                  resize: function( event, ui ){
                    var elem = ui.element;
                    if(elem.hasClass('fullsize')){
                        elem.removeClass('fullsize');
                        var btn = elem.find('.btn-size');
                        btn.removeClass('icon-resize-small');
                        btn.addClass('icon-resize-full');
                    }
                    window[resized](id);
                  },
                  stop: function( event, ui){
                    //save apps new size to server
                    var data = {
                        type: 'resize',
                        id: ui.element.attr('data-column-id'),
                        width: ui.size.width
                    }
                    saveApp(ui.element,data);
                  }
                });
                /*id.resizable({
                    resize: function(){
                        window[resized](id);
                    }
                });*/
                //add scrollbar
                addScrollBar('add',id);
                //add our header clicks
                id.find('.icon-remove').click(function(){
                    id.remove();
                    //save to server
                    var data = {
                        type: 'remove',
                        id: id.attr('data-column-id')
                    }
                    saveApp(id,data);
                });
                id.find('.icon-external-link').attr('href',url);
                id.find('.btn-size').click(function(){
                    var parent = $(this).parent().parent().parent();
                    var full = 'fullsize';
                    var big = 'icon-resize-full';
                    var small = 'icon-resize-small';
                    if(parent.hasClass(full)){
                        //make it small
                        parent.removeClass(full);
                        $(this).removeClass(small);
                        $(this).addClass(big);
                        var newWidth = parent.width();
                    }
                    else{
                        //make it big
                        parent.addClass(full);
                        $(this).removeClass(big);
                        $(this).addClass(small);
                        var newWidth = 'full';
                    }
                    //do the resize event
                    window[resized](parent);
                    //check the scrollbar
                    addScrollBar("update",parent);

                    //save to server
                    var data = {
                        type: 'resize',
                        id: parent.attr('data-column-id'),
                        width: newWidth
                    }
                    saveApp(id,data);
                });
                id.find('.btn-blend').click(function(){
                    var parent = $(this).parent().parent().parent();
                    var header = $(this).parent().parent();
                    var blend = 'blend';
                    var bcircle = 'icon-circle-blank';
                    var fcircle = 'icon-circle';

                    if(parent.hasClass(blend)){
                        //it is blended, so unblend
                        parent.removeClass(blend);
                        header.removeClass(blend);
                        $(this).removeClass(fcircle);
                        $(this).addClass(bcircle);

                       // header.unbind('hover');
                        var blend = '0';
                    }
                    else{
                        //blend!
                        parent.addClass(blend);
                        header.addClass(blend);
                        $(this).removeClass(bcircle);
                        $(this).addClass(fcircle);

                        /*header.hover(function(){
                            $(this).css('opacity',1);
                        },function(){
                            $(this).css('opacity',0);
                        });*/
                        var blend = '1';
                    }
                    //save to server
                    var data = {
                        type: 'blend',
                        id: parent.attr('data-column-id'),
                        blend: blend
                    }
                    saveApp(id,data);
                });
                id.find('.icon-refresh').click(function(){
                    var parent = $(this).parent().parent().parent();
                    parent.find('.app-body').html($('.app-master .app-loading')[0].outerHTML);
                    var href = $(this).attr('data-href');
                    $.getJSON(manifest+href,function(rep){
                        var data = rep.data;
                        var parser = rep.parser;
                        var events = rep.events;
                        var resized = rep.resize;

                        window[parser](parent,data);
                        setTimeout(function(){
                            //call the resize to see if the new content needs it
                            window[resized](parent);
                        },300);
                        parent.find('.app-loading').fadeOut('fast',function(){
                            parent.find('.notloaded, .app-body').fadeIn('fast');
                            parent.find('.notloaded').removeClass('notloaded');

                        });
                        window[events](parent);

                        //add scrollbar
                        addScrollBar('add',parent);
                    });
                });
            });
            //resize content to make sure it is accurate
            setTimeout(function(){
                window[resized](id);
            },300);
        });
}