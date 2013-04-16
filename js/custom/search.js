//JS for the search engine
function setForm(id){
    //set the vars
    var form = $('#main-form');
    var input = $('.main-search');
    var mainImg = $('.main-search-img');
    var h1In = $('#search-h1');
    var h2In = $('#search-h2');
    var img = id.find('img').attr('src');
    var action = id.attr('data-action'); 
    var sq = id.attr('data-sq');
    var h1 = id.attr('data-h1');
    var h2 = id.attr('data.h2');
    var place = id.find('a').attr('data-name');
    
    //Store current search locally so user can switch after they add value
    localStorage.setItem('temp_engine',input.val());
    
    //Do the switching!
    mainImg.attr('src',img);
    form.attr('action',action);
    input.attr('name',sq);
    h1In.attr('name',h1);
    h2In.attr('name',h2);
    input.attr('placeholder', 'Search '+place);
    
    //Get the local info back
    input.val(localStorage.getItem('temp_engine'));
    
    //Remove the locally stored value
    localStorage.removeItem('temp_engine');
    
}

function onMainSearchLoad(){
    var mainImg = $('.main-search-img').attr('src');
    var item = $('.main-search-item');
    var input = $('.main-search');
    var list = $('.main-search-list');
    var selectSearchItem = 'selectSearchItem';
        
    item.each(function(){
        var thisItem = $(this);
        var img = thisItem.find('img').attr('src');
        var short = thisItem.attr('data-short');
        if(img == mainImg){
            thisItem.addClass(selectSearchItem);
            setForm(thisItem);
        }
        thisItem.find('a').click(function(){
            //Remove the currently hidden item
            $('.'+selectSearchItem).removeClass(selectSearchItem);
            //Now do the switching function
            setForm(thisItem);
            thisItem.addClass(selectSearchItem);
        });
            
    });
        
    if(item.length <= 1){
        list.find('.divider').hide();
    }
}