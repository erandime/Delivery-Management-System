$(document).ready( function() {
    $("form").submit( function() {
        var username = $("#username").val();
        var password = $("#password").val();
        
        if(username === "") {
            $("#alertmsg").html("<p>Username Cannot Be Empty!!!</p>");
            $("#alertmsg").addClass("alert alert-danger");
            return false;
        }
        if(password === "") {
            $("#alertmsg").html("<p>Password Cannot Be Empty!!!</p>");
            $("#alertmsg").addClass("alert alert-danger");
            return false;
        }    
        
        
        
    });
});