$(document).ready(function()
{
    $('#fechaInicio').datetimepicker({
        lang:"es",
        format:'Y-d-m',
        timepicker:false,
        onChangeDateTime:function(dp,$input)
        {
            //alert($input.val());
            //llenarTabla(1);
        }
      });

      $('#fechaFin').datetimepicker({
        lang:"es",
        format:'Y-d-m',
        timepicker:false,
        onChangeDateTime:function(dp,$input)
        {
            //alert($input.val());
            //llenarTabla(1);
        }
      });

      $('#excel').on('click',function(e){
        e.preventDefault();
        e.stopPropagation(); 
        
        //REVISAR QUE NO ESTÉN VACIOS LOS CAMPOS
        if($("#fechaInicio").val()=='' || $("#fechaFin").val()=='')
        {
            alert("las fechas no deben estar vacias");
        }
        else
        {
            $.redirect('services/infoReporteDiario.php', {'fechainicio': $("#fechaInicio").val(), 'fechafin': $("#fechaFin").val()},"POST");
        }

      });
});