<?php
header('Content-Type: application/json');

require("conexion.php");

$conexion = regresarConexion();

switch ($_GET['accion']) {

  case 'listar':
    $datos = mysqli_query($conexion, "SELECT id,titulo,horainicio,horafin,colortexto,colorfondo FROM eventospredefinidos");
    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode($resultado);
  break;

  case 'agregar':
    $respuesta = mysqli_query($conexion, "INSERT INTO eventospredefinidos (titulo,horainicio,horafin,colortexto,colorfondo) VALUES ('$_POST[titulo]','$_POST[horainicio]','$_POST[horafin]','$_POST[colortexto]','$_POST[colorfondo]')");
    echo json_encode($respuesta);
  break;

  case 'modificar':
    $respuesta = mysqli_query($conexion, "UPDATE eventospredefinidos SET titulo='$_POST[titulo]', horainicio='$_POST[horainicio]', horafin='$_POST[horafin]', colortexto='$_POST[colortexto]', colorfondo='$_POST[colorfondo]' where id = $_GET[id]");
    echo json_encode($respuesta);
    break;

  /* NO SE MODIFIVAN LAS FECHAS EN LOS EVENTOS */
  case 'modificarRel':
    $respuesta = mysqli_query($conexion, "UPDATE eventos AS a1  INNER JOIN eventospredefinidos AS a2 ON a1.titulo='$_GET[oldtitle]' SET a1.titulo='$_POST[titulo]', a1.inicio=CONCAT(SUBSTRING(inicio,1,11),'$_POST[horainicio]',':00'), a1.fin=CONCAT(SUBSTRING(fin,1,11),'$_POST[horafin]',':00'), a1.colortexto='$_POST[colortexto]', a1.colorfondo='$_POST[colorfondo]', a2.titulo='$_POST[titulo]', a2.horainicio=CONCAT('$_POST[horainicio]',':00'), a2.horafin=CONCAT('$_POST[horafin]',':00'), a2.colortexto='$_POST[colortexto]', a2.colorfondo='$_POST[colorfondo]' WHERE a2.titulo='$_GET[oldtitle]'");
    echo json_encode($respuesta);
    break;
  /* NO SE MODIFIVAN LAS FECHAS EN LOS EVENTOS */

  case 'borrar':
    $respuesta = mysqli_query($conexion, "delete from eventospredefinidos where id=$_POST[id]");
    echo json_encode($respuesta);
    break;

  /* */
  case 'borrarRel':
    $respuesta = mysqli_query($conexion, "DELETE a1, a2 FROM eventos AS a1 INNER JOIN eventospredefinidos AS a2 WHERE a1.titulo='$_GET[titulo]' AND a2.id=$_POST[id]");
    echo json_encode($respuesta);
    break;
  

  case 'consultar':
    $datos = mysqli_query($conexion, "SELECT * FROM eventospredefinidos WHERE id=$_GET[id]");
    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode($resultado);
    break;


}

?>
