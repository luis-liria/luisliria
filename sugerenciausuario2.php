<?php
function getConexion()
{
  $servidor = "localhost";
  $usuario = "luis";
  $password = "1234";
  $bd = "libros";

  $conexion = new mysqli($servidor, $usuario, $password, $bd);

  if ($conexion->connect_error) 
  {
    die("Connection failed: " . $conexion->connect_error);
  }
  else
  {
    $conexion->set_charset("utf8");
    return $conexion;
  }
}

function get_sugerencias($nombre)
{
	//$consulta = "SELECT AutorID, nombre, apellido FROM autor WHERE nombre LIKE '%$nombre%'";
	$consulta = "SELECT l.titulo, l.f_publicacion,a.nombre,l.LibroID, a.apellido, a.nacionalidad FROM Autor a join Libro l on (a.AutorID = l.AutorID) where a.nombre like '%$nombre%'";
	$conexion = getConexion();
	$resultado = $conexion->query($consulta);
	
	if ($resultado->num_rows > 0)
    {
		while($row = $resultado->fetch_assoc())
		{
			//Guardar datos en un array
			$listaNombres[] = $row;
			
		}
	}
	
	$conexion->close();
	return $listaNombres;
	
		
}


if (isset($_GET["nombre"]))
{
	//Obtener array con sugerencias para ese nombre
	$sugerencias = get_sugerencias($_GET["nombre"]);
	
	 //devolvemos un JSON a partir del array con los resultados
	exit(json_encode($sugerencias));
}
?>