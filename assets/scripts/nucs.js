$(document).ready(function()
{
    function llenarTabla()
    {
        $.post("services/searchNucs.php",
                       {
                           server:$('#servidor').val(),
                           nuc:$('#nucg').val()
                       },
                       function(data) 
                       {                       
                        var info=JSON.parse(data);   
                        if(info.resultado=="OK")
                        {
                            //PRESENTAR LA SECCION DE LA TABLA Y CARGAR DATOS
                            //$('#cardTablaNucs').
                            $('#tablaNucs tbody').html(info.table);
                        }

                       } 
                      );
    }
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
        llenarTabla();
    });

    //BOTONES DE BORRAR NUC EN LA TABLA
    $(document.body).on('click','.deleteNuc', function(e) 
    {
        //alert ("test");
        //alert("valores:"+$(this).attr('nuc')+",rac:"+$(this).attr('rac'));    
        $('#hdNuc').val($(this).attr('nuc'));
        $('#hdRac').val($(this).attr('rac'));
        $('#hdHecho').val($(this).attr('hecho'));
        $('#hdAtencion').val($(this).attr('atencion'));
        //alert($(this).attr("href"));

        
       //$('#borrarNucDialog').modal('toggle');
       // $('#borrarNucDialog').show();    
        //e.preventDefault();
        //e.stopPropagation();
      });



    //BOTON DE  BORRAR NUC
    $('#botonBorrar').on('click',function(e)
    {
    var borradoCompleto=0;
    if ($('#borradoCompleto').is(":checked"))
        borradoCompleto=1;
    else
        borradoCompleto=0;

        $.post("services/borrarNUC.php",
        {
            rac:$('#hdRac').val(),
            nuc:$('#hdNuc').val(),
            hecho:$('#hdHecho').val(),
            distrito:$('#servidor').val(),
            atencion:$('#hdAtencion').val(),
            completo:borradoCompleto
        },
        function(data) 
        {                       
            var info=JSON.parse(data);
            $('#cancelarBorrar').trigger("click");
            if(info.resultado=="OK")
            {
               alert("NUC Borrado");
               llenarTabla();
               //llenarTabla($("#paginaActual").val());     
            }
            else
            {
                alert(info.info);
            }
            
        } 
        );  
   });                  
});