$(document).ready(function()
{
    $.post("services/ipDistritos.php",
                       {
                           idUsuario:0
                       },
                       function(data) 
                       {                       
                        var info=JSON.parse(data);
                        //console.log(info);   
                        //$('#tipoidVisita').html(data);
                        var combo="";
                        info.info.forEach(function(value,index) 
                        {
                            var ip = Object.keys( value )[0];
                            var nombre = value[ip];
                            combo+='<option value="'+ip+'">'+nombre+'</option>';   
                            //console.log(value[0]);
                            $('#servidor').html(combo);
                        });



                       } 
                      );
    $('#botonBuscar').on('click',function(e)
    {
        $.post("services/searchRacs.php",
                       {
                           server:$('#servidor').val(),
                           rac:$('#racg').val()
                       },
                       function(data) 
                       {                       
                        var info=JSON.parse(data);   
                        if(info.resultado=="OK")
                        {
                            //PRESENTAR LA SECCION DE LA TABLA Y CARGAR DATOS
                            //$('#cardTablaRacs').
                            $('#tablaRacs tbody').html(info.table);
                        }

                       } 
                      );
    });                   
});