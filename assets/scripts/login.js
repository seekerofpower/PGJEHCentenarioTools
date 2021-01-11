$(document).ready(function()
{
    
    //alert("hola");
    $('#botonLogin').on("click",function(e)
    {
       e.preventDefault();
       e.stopPropagation();
        $.post("services/login.php",
                            {
                                usuario:$('#username').val(),
                                password:$('#password').val()

                            },
                            function(data) 
                            {                       
                                var info=JSON.parse(data);
                                if(info.resultado=="OK")
                                {
                                    window.location.href= 'index.php';
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
