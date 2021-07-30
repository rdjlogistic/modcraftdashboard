
$("#modloginform").click(function()
{

    var name= $.session.get('loginemail');
    
if ($('#remember').prop('checked')) {
 alert(name);
}

});