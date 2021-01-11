$(document).ready(function()
{
    $('#botonLogin').on("click",function()
    {
       
        $.post("services/login.php",
                            {
                                usuario:$('#user').val(),
                                password:$('#pswd').val()

                            },
                            function(data) 
                            {                       
                                var info=JSON.parse(data);
                                if(info.resultado=="OK")
                                {
                                    if(info.tipousuario==1)
                                        window.location.href= 'index.php';
                                    if(info.tipousuario==2)
                                        window.location.href= 'reportes.php';
                                    if(info.tipousuario==3)
                                        window.location.href= 'admin.php';    

                                }
                                else
                                {
                                    alert(info.info);
                                }
                            } 
                        );
    });

    $(document.body).on("keypress",function(e)
    {   
        
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13)
        {
            e.preventDefault();
            e.stopPropagation();
            $('#botonLogin').click();
        }
    });

});
