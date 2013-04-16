(function( $ ){

  $.fn.modalx = function( options ) {  

    // Create some defaults, extending them with any options that were provided
    var settings = $.extend( {
      'id'        : this.attr('data-id'),
      'header'    : this.attr('data-head'),
      'saveFn'    : this.attr('data-save'),
      'openFn'    : this.attr('data-open'),
      'closeFn'   : this.attr('data-close'),
      'url'       : this.attr('data-href'),
      'enterClass': 'thisEnter'
    }, options);


    return this.each(function() {        

        var obj = $(this);
            
        var open = settings.openFn;
        var save = settings.saveFn;
        var close = settings.closeFn;
        var id = settings.id;
        
        var container = $('#modals');
        var modalID = $('#modal'+id);
            
        if(modalID.length === 0){
            //modal is not yet created, add it!
            var html ='';
            html += '<div id="modal'+id+'" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
            html += '   <div class="modal-header">';
            html += '       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
            html += '       <h3 class="myModalLabel'+id+'">'+settings.header+'</h3>';
            html += '    </div>';
            html += '    <div class="modal-body">';
            html += '       Loading...';
            html += '    </div>';
            html += '    <div class="modal-footer">';
           // html += '       <div class="modal-status">';
            //html += '           <span>You have unsaved changes.</span>';
            //html += '           <a href="javascript:void(0)">Reset</a>';
            //html += '       </div>';
            html += '       <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>';
            if(save !== undefined){
                html += '   <button class="btn btn-primary">Save</button>';   
            }
            html += '    </div>';
            html += '</div>';
            container.append(html);
            //redefine the element
            modalID = $('#modal'+id);
            //add the functions..
            //add the modal function and show it
            modalID.modal();
            
            modalID.modal('show');
            var body = modalID.find('.modal-body');
            //lets load the body!
            body.load(settings.url, function(){
                //add enter options..
                body.find('.'+settings.enterClass).keyup(function(event){
                    if(event.keyCode == 13){
                        saveBtn.click();
                    }
                });
            });
            //modalID.modal('show');
            if(close !== undefined){ //if close is there..
                modalID.on('hide', function () {
                    window[close]();
                });
            }
            
            if(open !== undefined){ //if open is there..
                modalID.on('show', function () {
                    window[open]();
                });
            }
            
            if(save !== undefined){//if save is there...
                var saveBtn = modalID.find('.modal-footer .btn:eq(1)');
                saveBtn.click(function(){
                    window[save]();
                });
            }
            
            modalID.find('.modal-status').click(function(){
                body.html('Loading...');
                body.load(settings.url);
                $(this).hide();
            });
        }
        modalID.modal('show');
    });

  };
})( jQuery );