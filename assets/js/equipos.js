function BuscarSerie(val) {
    var value= val.toLowerCase();

    if (value !="" || value !="sin serie" || value !="n/a") {                    
        
        $.ajax({
        url: "?c=equipos&a=ajax_load_validacionserie",
        dataType: "json",
        method: "POST",
        data: "serie="+value
        }).done(function(data) {
        var datos = data;        
        if(datos.length > 0){
            $("[type='submit']").attr('disabled','disabled');
            $("[name='numeroserie']").remove();
            var valor= "<p> <h4>El numero de serie ya se encuentra registrada. ¿Estas seguro de ingresar el equipo con la serie duplicada ?</h4> <button type='button' class='btn btn-default' data-toggle='modal' data-target='#modal-default'>Confirmar <i class='fa fa-check fa-lg'></i> </button> </p>";
            var div=
            "<div class='form-group' name='numeroserie' id='numeroserie'>"+
                "<div class='col-sm-12'> "+ 
                    "<div class='alert alert-warning alert-dismissible'>"+
                    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                    "<h4><i class='icon fa fa-warning'></i> Alerta!</h4>" + valor + "</div>"+
                "</div>"+
                "<table class='table table-bordered table-striped table-hover' role='grid'>"+
                " <thead>"+
                    "<tr>"+
                        "<th>Id</th>"+
                        "<th>Descripción</th>"+
                        "<th>Marca</th>"+
                        "<th>Modelo</th>"+
                        "<th>Serie</th>"+
                        "<th>Activo</th>"+
                    "</tr>"+
                "</thead>"+
                "<tbody>";
                var estadoeq="";
                var labeleq="";
                for(var i=0; i < datos.length;i++){

                    if (datos[i].activo=="1"){
                        estadoeq="Activo";
                        labeleq="label-success";                        
                    }
                    else{
                        estadoeq="Inactivo";
                        labeleq="label-danger";                        
                    }
                    div += "<tr>"+
                        "<td>"+ datos[i].alias +"</th>"+
                        "<td>"+datos[i].descripcion+"</th>"+
                        "<td>"+datos[i].marca+"</th>"+
                        "<td>"+datos[i].modelo+"</th>"+
                        "<td>"+datos[i].serie+"</th>"+
                        "<td > <span class='label "+ labeleq +"'>" + estadoeq + "</spam> </td>" +
                    "</tr>";
                }                                
                div += "</tbody>";
                div += "</div>";

            $("#alerta_numeroserie").after(div);
        }                    
        
        }).fail(function(data) {}).always(function(data) {
            //console.log(data);
        });                    
    }                
}
