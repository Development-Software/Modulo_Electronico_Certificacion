<?php
include_once dirname(__DIR__) . '/model/db.php';
include_once dirname(__DIR__)  . '/model/permisos.php';
include_once dirname(__DIR__)  . '/model/configuracion.php';
include_once dirname(__DIR__)  . '/controller/controller_sesion.php';
include_once dirname(__DIR__)  . '/model/roles.php';
extract($_GET);
//echo '<pre>'.print_r(extract($_GET)).'</pre>';
$informacion_permisos = new roles();
$informacion_permisos->setIdRol($id_rol);
$permisos = $informacion_permisos->getReportePermisos();
?>
<form id="permisos_insert">
    <input hidden type="text" value="<?php echo $id_rol ?>" id="idRol" name="idRol">
<table id="tabla_permisos" class="table-sm" style="margin: auto; width:100%">
    <thead>
        <th></th>
        <th style="display: none;">IdPermiso</th>
        <th style="text-align: left !important;width:25%;">Permiso</th>
        <th style="text-align: left !important;width:70%;">Descripción</th>
        <th style="text-align: left !important;width:20%;">Activar</th>
        <th></th>
    </thead>
    <tbody>
        <?php
        foreach ($permisos as $row) {
        ?>
            <tr id="tr_<?php echo $row['idPermiso']; ?>"<?php echo $row['tr_Style']; ?>>
                <td></td>
                <td style="display: none;"><?php echo $row['idPermiso']; ?></td>
                <td id="menu_<?php echo $row['idPermiso']; ?>" <?php echo $row['Menu_Style']; ?>> <?php echo $row['SubMenu']; ?> </td>
                <td id="permiso_<?php echo $row['idPermiso']; ?>" <?php echo $row['Permiso_Style']; ?>><?php echo $row['Privilegio']; ?></td>
                <td id="descripcion_<?php echo $row['idPermiso']; ?>"><?php echo $row['Descripcion']; ?></td>
                <td>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="<?php echo str_replace(' ','',$row['SubMenu']).'-'.str_replace(' ','',$row['Privilegio']); ?>" <?php if ($row['Activo'] == 1 || $row['idPermiso']==1) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                        <label class="custom-control-label" for="<?php echo str_replace(' ','',$row['SubMenu']).'-'.str_replace(' ','',$row['Privilegio']); ?>"></label>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</form>

<!-- <script>
    $("#4").change(function(){
        if ($('#4').prop('checked')) {
            $('#3').prop('checked', true);
            $('#2').prop('checked', true);
        }
    });
    $("#5").change(function(){
        if ($('#5').prop('checked')) {
            $('#3').prop('checked', true);
            $('#2').prop('checked', true);
        }
    });
    $("#6").change(function(){
        if ($('#6').prop('checked')) {
            $('#3').prop('checked', true);
            $('#2').prop('checked', true);
        }
    });
    $("#3").change(function(){
        if (!$('#3').prop('checked')) {
            $('#4').prop('checked', false);
            $('#5').prop('checked', false);
            $('#6').prop('checked', false);
        }
        if(!$('#7').prop('checked')&&!$('#11').prop('checked')){
            $('#2').prop('checked', false);
        }
    });

    $("#8").change(function(){
        if ($('#8').prop('checked')) {
            $('#7').prop('checked', true);
            $('#2').prop('checked', true);
        }
    });
    $("#9").change(function(){
        if ($('#9').prop('checked')) {
            $('#7').prop('checked', true);
            $('#2').prop('checked', true);
        }
    });
    $("#10").change(function(){
        if ($('#10').prop('checked')) {
            $('#7').prop('checked', true);
            $('#2').prop('checked', true);
        }
    });
    $("#7").change(function(){
        if (!$('#7').prop('checked')) {
            $('#8').prop('checked', false);
            $('#9').prop('checked', false);
            $('#10').prop('checked', false);
        }
        if(!$('#3').prop('checked')&&!$('#11').prop('checked')){
            $('#2').prop('checked', false);
        }
    });

    $("#12").change(function(){
        if ($('#12').prop('checked')) {
            $('#11').prop('checked', true);
            $('#2').prop('checked', true);
        }
    });
    $("#13").change(function(){
        if ($('#13').prop('checked')) {
            $('#11').prop('checked', true);
            $('#2').prop('checked', true);
        }
    });

    $("#11").change(function(){
        if (!$('#11').prop('checked')) {
            $('#12').prop('checked', false);
            $('#13').prop('checked', false);
        }
        if(!$('#7').prop('checked')&&!$('#3').prop('checked')){
            $('#2').prop('checked', false);
        }

    });

    $("#16").change(function(){
        if ($('#16').prop('checked')) {
            $('#15').prop('checked', true);
            $('#14').prop('checked', true);
        }
    });
    $("#17").change(function(){
        if ($('#17').prop('checked')) {
            $('#15').prop('checked', true);
            $('#14').prop('checked', true);
        }
    });
    $("#18").change(function(){
        if ($('#18').prop('checked')) {
            $('#15').prop('checked', true);
            $('#14').prop('checked', true);
        }
    });
    $("#19").change(function(){
        if ($('#19').prop('checked')) {
            $('#15').prop('checked', true);
            $('#14').prop('checked', true);
        }
    });
    $("#15").change(function(){
        if (!$('#15').prop('checked')) {
            $('#16').prop('checked', false);
            $('#17').prop('checked', false);
            $('#18').prop('checked', false);
            $('#19').prop('checked', false);
        }
        if(!$('#20').prop('checked')&&!$('#25').prop('checked')){
            $('#14').prop('checked', false);
        }
    });

    $("#21").change(function(){
        if ($('#21').prop('checked')) {
            $('#20').prop('checked', true);
            $('#14').prop('checked', true);
        }
    });
    $("#22").change(function(){
        if ($('#22').prop('checked')) {
            $('#20').prop('checked', true);
            $('#14').prop('checked', true);
        }
    });
    $("#23").change(function(){
        if ($('#23').prop('checked')) {
            $('#20').prop('checked', true);
            $('#14').prop('checked', true);
        }
    });
    $("#24").change(function(){
        if ($('#24').prop('checked')) {
            $('#20').prop('checked', true);
            $('#14').prop('checked', true);
        }
    });
    $("#20").change(function(){
        if (!$('#20').prop('checked')) {
            $('#21').prop('checked', false);
            $('#22').prop('checked', false);
            $('#23').prop('checked', false);
            $('#24').prop('checked', false);
        }
        if(!$('#15').prop('checked')&&!$('#25').prop('checked')){
            $('#14').prop('checked', false);
        }
    });


    $("#26").change(function(){
        if ($('#26').prop('checked')) {
            $('#25').prop('checked', true);
            $('#14').prop('checked', true);
        }
    });
    $("#27").change(function(){
        if ($('#27').prop('checked')) {
            $('#25').prop('checked', true);
            $('#14').prop('checked', true);
        }
    });

    $("#25").change(function(){
        if (!$('#25').prop('checked')) {
            $('#26').prop('checked', false);
            $('#27').prop('checked', false);
        }
        if(!$('#15').prop('checked')&&!$('#20').prop('checked')){
            $('#14').prop('checked', false);
        }

    });


    $("#30").change(function(){
        if ($('#30').prop('checked')) {
            $('#29').prop('checked', true);
            $('#28').prop('checked', true);
        }
    });
    $("#31").change(function(){
        if ($('#31').prop('checked')) {
            $('#29').prop('checked', true);
            $('#28').prop('checked', true);
        }
    });
    $("#32").change(function(){
        if ($('#32').prop('checked')) {
            $('#29').prop('checked', true);
            $('#28').prop('checked', true);
        }
    });
    $("#29").change(function(){
        if (!$('#29').prop('checked')) {
            $('#30').prop('checked', false);
            $('#31').prop('checked', false);
            $('#32').prop('checked', false);
        }
        if(!$('#33').prop('checked')&&!$('#34').prop('checked')){
            $('#28').prop('checked', false);
        }
    });

    $("#33").change(function(){
        if (!$('#33').prop('checked')&&!$('#34').prop('checked')&&!$('#29').prop('checked')) {
            $('#28').prop('checked', false);
        }else{
            $('#28').prop('checked', true);
        }
    });
    $("#34").change(function(){
        if (!$('#33').prop('checked')&&!$('#34').prop('checked')&&!$('#29').prop('checked')) {
            $('#28').prop('checked', false);
        }else{
            $('#28').prop('checked', true);
        }
    });
</script> -->

<script>
    $("#Generar-Eliminar").change(function(){
        if ($('#Generar-Eliminar').prop('checked')) {
            $('#Generar-Acceso').prop('checked', true);
            $('#Alumnos-Acceso').prop('checked', true);
        }
    });
    $("#Generar-Exportar").change(function(){
        if ($('#Generar-Exportar').prop('checked')) {
            $('#Generar-Acceso').prop('checked', true);
            $('#Alumnos-Acceso').prop('checked', true);
        }
    });
    $("#Generar-Enviarafirma").change(function(){
        if ($('#Generar-Enviarafirma').prop('checked')) {
            $('#Generar-Acceso').prop('checked', true);
            $('#Alumnos-Acceso').prop('checked', true);
        }
    });
    $("#Generar-Acceso").change(function(){
        if (!$('#Generar-Acceso').prop('checked')) {
            $('#Generar-Eliminar').prop('checked', false);
            $('#Generar-Exportar').prop('checked', false);
            $('#Generar-Enviarafirma').prop('checked', false);
        }else{
            $('#Alumnos-Acceso').prop('checked', true);
        }
        if(!$('#Firmar-Acceso').prop('checked')&&!$('#Consultar-Acceso').prop('checked')){
            $('#Alumnos-Acceso').prop('checked', false);
        }
    });

    $("#Firmar-Eliminar").change(function(){
        if ($('#Firmar-Eliminar').prop('checked')) {
            $('#Firmar-Acceso').prop('checked', true);
            $('#Alumnos-Acceso').prop('checked', true);
        }
    });
    $("#Firmar-Exportar").change(function(){
        if ($('#Firmar-Exportar').prop('checked')) {
            $('#Firmar-Acceso').prop('checked', true);
            $('#Alumnos-Acceso').prop('checked', true);
        }
    });
    $("#Firmar-Firmar").change(function(){
        if ($('#Firmar-Firmar').prop('checked')) {
            $('#Firmar-Acceso').prop('checked', true);
            $('#Alumnos-Acceso').prop('checked', true);
        }
    });
    $("#Firmar-Acceso").change(function(){
        if (!$('#Firmar-Acceso').prop('checked')) {
            $('#Firmar-Eliminar').prop('checked', false);
            $('#Firmar-Exportar').prop('checked', false);
            $('#Firmar-Firmar').prop('checked', false);
        }else{
            $('#Alumnos-Acceso').prop('checked', true);
        }
        if(!$('#Generar-Acceso').prop('checked')&&!$('#Consultar-Acceso').prop('checked')){
            $('#Alumnos-Acceso').prop('checked', false);
        }
    });

    $("#Consultar-Descargar").change(function(){
        if ($('#Consultar-Descargar').prop('checked')) {
            $('#Consultar-Acceso').prop('checked', true);
            $('#Alumnos-Acceso').prop('checked', true);
        }
    });
    $("#Consultar-Exportar").change(function(){
        if ($('#Consultar-Exportar').prop('checked')) {
            $('#Consultar-Acceso').prop('checked', true);
            $('#Alumnos-Acceso').prop('checked', true);
        }
    });

    $("#Consultar-Acceso").change(function(){
        if (!$('#Consultar-Acceso').prop('checked')) {
            $('#Consultar-Descargar').prop('checked', false);
            $('#Consultar-Exportar').prop('checked', false);
        }else{
            $('#Alumnos-Acceso').prop('checked', true);
        }
        if(!$('#Firmar-Acceso').prop('checked')&&!$('#Generar-Acceso').prop('checked')){
            $('#Alumnos-Acceso').prop('checked', false);
        }

    });

    $("#Usuarios-Agregarusuario").change(function(){
        if ($('#Usuarios-Agregarusuario').prop('checked')) {
            $('#Usuarios-Acceso').prop('checked', true);
            $('#Usuariosyroles-Acceso').prop('checked', true);
        }
    });
    $("#Usuarios-Activarusuario").change(function(){
        if ($('#Usuarios-Activarusuario').prop('checked')) {
            $('#Usuarios-Acceso').prop('checked', true);
            $('#Usuariosyroles-Acceso').prop('checked', true);
        }
    });
    $("#Usuarios-Editarusuarios").change(function(){
        if ($('#Usuarios-Editarusuarios').prop('checked')) {
            $('#Usuarios-Acceso').prop('checked', true);
            $('#Usuariosyroles-Acceso').prop('checked', true);
        }
    });
    $("#Usuarios-Exportar").change(function(){
        if ($('#Usuarios-Exportar').prop('checked')) {
            $('#Usuarios-Acceso').prop('checked', true);
            $('#Usuariosyroles-Acceso').prop('checked', true);
        }
    });
    $("#Usuarios-Acceso").change(function(){
        if (!$('#Usuarios-Acceso').prop('checked')) {
            $('#Usuarios-Agregarusuario').prop('checked', false);
            $('#Usuarios-Activarusuario').prop('checked', false);
            $('#Usuarios-Editarusuarios').prop('checked', false);
            $('#Usuarios-Exportar').prop('checked', false);
        }
        if(!$('#Roles-Acceso').prop('checked')&&!$('#Campus-Acceso').prop('checked')){
            $('#Usuariosyroles-Acceso').prop('checked', false);
        }
    });

    $("#Roles-Agregarperfil").change(function(){
        if ($('#Roles-Agregarperfil').prop('checked')) {
            $('#Roles-Acceso').prop('checked', true);
            $('#Usuariosyroles-Acceso').prop('checked', true);
        }
    });
    $("#Roles-Activarperfil").change(function(){
        if ($('#Roles-Activarperfil').prop('checked')) {
            $('#Roles-Acceso').prop('checked', true);
            $('#Usuariosyroles-Acceso').prop('checked', true);
        }
    });
    $("#Roles-Editarperfil").change(function(){
        if ($('#Roles-Editarperfil').prop('checked')) {
            $('#Roles-Acceso').prop('checked', true);
            $('#Usuariosyroles-Acceso').prop('checked', true);
        }
    });
    $("#Roles-Exportar").change(function(){
        if ($('#Roles-Exportar').prop('checked')) {
            $('#Roles-Acceso').prop('checked', true);
            $('#Usuariosyroles-Acceso').prop('checked', true);
        }
    });
    $("#Roles-Acceso").change(function(){
        if (!$('#Roles-Acceso').prop('checked')) {
            $('#Roles-Agregarperfil').prop('checked', false);
            $('#Roles-Activarperfil').prop('checked', false);
            $('#Roles-Editarperfil').prop('checked', false);
            $('#Roles-Exportar').prop('checked', false);
        }
        if(!$('#Usuarios-Acceso').prop('checked')&&!$('#Campus-Acceso').prop('checked')){
            $('#Usuariosyroles-Acceso').prop('checked', false);
        }
    });


    $("#Campus-Agregarusuarios").change(function(){
        if ($('#Campus-Agregarusuarios').prop('checked')) {
            $('#Campus-Acceso').prop('checked', true);
            $('#Usuariosyroles-Acceso').prop('checked', true);
        }
    });
    $("#Campus-Eliminarusuarios").change(function(){
        if ($('#Campus-Eliminarusuarios').prop('checked')) {
            $('#Campus-Acceso').prop('checked', true);
            $('#Usuariosyroles-Acceso').prop('checked', true);
        }
    });

    $("#Campus-Acceso").change(function(){
        if (!$('#Campus-Acceso').prop('checked')) {
            $('#Campus-Agregarusuarios').prop('checked', false);
            $('#Campus-Eliminarusuarios').prop('checked', false);
        }
        if(!$('#Usuarios-Acceso').prop('checked')&&!$('#Roles-Acceso').prop('checked')){
            $('#Usuariosyroles-Acceso').prop('checked', false);
        }

    });


    $("#Sistema-Autenticación").change(function(){
        if ($('#Sistema-Autenticación').prop('checked')) {
            $('#Sistema-Acceso').prop('checked', true);
            $('#Configuración-Acceso').prop('checked', true);
        }else{
            if(!$('#Sistema-Fuente').prop('checked') && !$('#Sistema-Firma').prop('checked')){
                $('#Sistema-Acceso').prop('checked', false);
            }
        }
    });
    $("#Sistema-Fuente").change(function(){
        if ($('#Sistema-Fuente').prop('checked')) {
            $('#Sistema-Acceso').prop('checked', true);
            $('#Configuración-Acceso').prop('checked', true);
        }else{
            if(!$('#Sistema-Firma').prop('checked') && !$('#Sistema-Autenticación').prop('checked')){
                $('#Sistema-Acceso').prop('checked', false);
            }
        }
    });
    $("#Sistema-Firma").change(function(){
        if ($('#Sistema-Firma').prop('checked')) {
            $('#Sistema-Acceso').prop('checked', true);
            $('#Configuración-Acceso').prop('checked', true);
        }else{
            if(!$('#Sistema-Fuente').prop('checked') && !$('#Sistema-Autenticación').prop('checked')){
                $('#Sistema-Acceso').prop('checked', false);
            }
        }
    });
    $("#Sistema-Acceso").change(function(){
        if (!$('#Sistema-Acceso').prop('checked')) {
            $('#Sistema-Autenticación').prop('checked', false);
            $('#Sistema-Fuente').prop('checked', false);
            $('#Sistema-Firma').prop('checked', false);
        }
        if(!$('#Catalogos-Acceso').prop('checked')&&!$('#Alumnos-Acceso').prop('checked')){
            $('#Configuración-Acceso').prop('checked', false);
        }
    });

    $("#Catalogos-Acceso").change(function(){
        if (!$('#Catalogos-Acceso').prop('checked')&&!$('#Alumnos-Acceso').prop('checked')&&!$('#Sistema-Acceso').prop('checked')) {
            $('#Configuración-Acceso').prop('checked', false);
        }else{
            $('#Configuración-Acceso').prop('checked', true);
        }
    });
    $("#Alumnos-Acceso").change(function(){
        if (!$('#Catalogos-Acceso').prop('checked')&&!$('#Alumnos-Acceso').prop('checked')&&!$('#Sistema-Acceso').prop('checked')) {
            $('#Configuración-Acceso').prop('checked', false);
        }else{
            $('#Configuración-Acceso').prop('checked', true);
        }
    });
</script>