//JS for logging in
function login(){
    var user = $('#login_user').val();
    var pass = $('#login_pass').val();
    var check = $('#login_check');
    
    if(check.is(':checked')){
        check = 'true';
    }
    else{
        check = 'false';
    }
    
    var data = {
        user: user,
        pass: pass,
        check: check
    };
    
    $.ajax({
        type: "POST",
        url: self+'ajax/signin.php',
        data: data,
        success: function(rep){
            if(rep == 'true'){
                var url = window.location;
                var para = getParameter('then',url);
                
                if(para == ''){
                    location.reload();
                }
                else{
                    location.href = para;
                }
                
            }
            else if(rep == 'false'){
                alert('Invalid Login');
            }
            else{
                alert(rep);
            }
        }
    });
}

//function to get url parameter
function getParameter( name,href ){
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( href );
  if( results == null )
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}