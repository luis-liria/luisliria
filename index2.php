<!DOCTYPE html>
<html>
	<head>
		<title>Aplicaciones web hibridas</title>
		<link rel="stylesheet" type="text/css" href="estilo.css"/>  
		<script type="text/javascript">
		
			/**
				Recibe una cadena y hace una llamada ajax que recupera los titulos
				de los libros cuyos autores tengan nombres o apellidos coincidentes con la cadena
			*/
			function procesar(cadena)
			{
				//si la cadena está vacía, limpiamos el campo de resultados
				if(cadena.length == 0)
				{
					document.getElementById("sugerencias").innerHTML = "";
					return;
				}
				else //hacemos la petición
				{
					var asyncRequest = new XMLHttpRequest();
					//asignamos a la propiedad la función que se llamará cuando el estado de la petición cambie				
					asyncRequest.open("GET", "http://localhost/tarea8/sugerenciausuario/sugerenciausuario2.php?nombre=" + cadena, true);
					asyncRequest.onreadystatechange = stateChange; 					
					asyncRequest.send(null);
				}

				/**
					Gestiona el resultado de la petición
				*/
				function stateChange()
				{ 
					if(asyncRequest.readyState == 4 && asyncRequest.status == 200)
					{
						//limpiamos por si había algo antes
						document.getElementById("sugerencias").innerHTML = "";

						//puesto que hemos mandado la petición en formato JSON, la convertimos a un array
						var resultado = window.JSON.parse(asyncRequest.responseText);
						//para cada elemento del array, llamamos a mostrarSugerencias,
						//el forEach automaticamente pasa el elemento como parámetro
						resultado.forEach(mostrarSugerencias);
					}

					/**
						Recibe una cadena y la añade al campo sugerencias, con un salto de línea
					*/
					function mostrarSugerencias(contacto)
					{
						//document.getElementById("sugerencias").innerHTML += contacto.titulo + " | " + contacto.f_publicacion + " | " + " Autor: " +  contacto.nombre + " | " + contacto.apellido + "<br />";
						//document.getElementById("sugerencias").innerHTML += titulo.id_autor + "</br>";
						document.getElementById("sugerencias").innerHTML += "<tr><td><strong>Libro:&nbsp&nbsp</strong>" + contacto.titulo + "</td><td>" + contacto.f_publicacion + "</td><td>&nbsp<strong>Autor:</strong>&nbsp&nbsp" + contacto.nombre + "</td><td>" + contacto.apellido + "</td><br/></tr>";
																			
																			
																			
																			
																			
																			
																			
					}
				}

			}

		</script>

	</head>
	<body style="font-family: Arial, Helvetica, sans-serif;">

		<div id="formulario">

			<fieldset>

				<legend>Búsqueda de usuarios</legend>

				<form id="formulariodatos">

					<label for="autor">Nombre</label><br />
					<!--El evento onkeyup llama al método procesar, pasándole el valor del input-->
					<input type="text" id="autor" name="autor" onkeyup="procesar(this.value)"><br />

				</form>

			</fieldset>

			<br>

			<span id="sugerencias" style="color: #0080FF;"></span>

		</div>
		
	</body>
</html>