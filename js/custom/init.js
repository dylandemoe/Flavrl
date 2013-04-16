//JS file for loading on DOM ready

$(function(){
    //Check if login form is there
    if($('#login_check').length !== 0){
        $('#login_submit').click(function(){
            login();
        });
        //bind enter button functionally for the form
        $(document).keypress(function(e) {
            if(e.which == 13) {
                login();
            }
        });
    }
    else{// we are logged in!
        //add custom js for bootstrap modal
        $('.modal-link').click(function(){
            $(this).modalx();
        });
        //Load the JS for the search engine
        onMainSearchLoad();
        //Load the JS for the apps-list (adding apps)
        onMainAppListLoad();

        //Make the page scroll side to side instead of down
        /*$("html, body, *").mousewheel(function(event, delta) {
            this.scrollLeft -= (delta * 30);
            this.scrollRight -= (delta * 30);
            event.preventDefault();
        });*/
    }
})