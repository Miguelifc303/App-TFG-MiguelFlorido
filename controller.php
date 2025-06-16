<?php


function delById($tabla,$id){
    include("db.php");
    $sql="DELETE FROM `".$tabla."` WHERE `id`='".$id."'";


    if($mysqli->query($sql))return 1;
    else return 0;
}

//Funcion creada para eliminar citas tengan solicitud o no
//Funcion utilizada en modulo_citas_delete.php
function delByIdCampo($tabla, $campo_id, $id){
    include("db.php");
    $sql = "DELETE FROM `" . $tabla . "` WHERE `" . $campo_id . "` = '" . $id . "'";
    if($mysqli->query($sql)){
        return 1;
    } else {
        return 0;
    }
}

//Funcion utilizada en modulo_usuarios_update
function conseguirValor($tabla, $campo, $id)
{
    include("db.php");
    $fila = "";
    $sql = "SELECT `" . $campo . "` FROM `" . $tabla . "` WHERE `id`=" . $id;
    $query = $mysqli->query($sql);
    if ($query->num_rows > 0) {
        $fila = $query->fetch_assoc();
    }
    return $fila[$campo];
}


//actualiza los datos del registro de una tabla por ID
//$datos: vector asociativo con los datos que queremos actualizar
// el nombre de los campos son los indices del vector ($k)
// el valor son el contenido de las posiciones del vector ($v)
//Funcion utilizada en modulo_usuarios_update
function updateById($tabla, $datos, $id)
{
    include("db.php");
    $sql = "UPDATE `" . $tabla . "` SET  ";
    $aux = 0;
    foreach ($datos as $k => $v) {
        if ($aux == 0) {
            $sql .= "`" . $k . "`='" . $v . "'";
            $aux++;
        } else {
            $sql .= ",`" . $k . "`='" . $v . "'";
        }
    }
    $sql .= " WHERE `id`='" . $id . "'";

    if ($mysqli->query($sql)) return 1;
    else return 0;
}

// Función para obtener el nombre del mecánico por ID
function obtenerMecanicoPorId($id) {
    include("db.php");
    $sql = "SELECT nombre FROM mecanicos WHERE id = '$id'";
    $resultado = $mysqli->query($sql);
    return $resultado->fetch_assoc();
}



function VerificarUsuario($username, $passMd5) {
    include("db.php");
    
    $sql = "SELECT `id`, `nombre`, `email`, `password`, `telefono`, `id_rol` FROM `usuarios` WHERE nombre = ? AND password = ?";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $username, $passMd5);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return 0;
    }
}

//FUNCION USADA DENTRO DE modulo_citas_list.php
function getAllCitas() {
    include("db.php"); 
    $resultado = array();

    $sql = "
    SELECT * FROM (
        SELECT 
            NULL AS cita_id,
            sc.fecha_solicitada AS fecha,
            NULL AS estado_cita,
            sc.descripcion_cliente,
            NULL AS id_mecanico,
            NULL AS veredicto_mecanico,
            NULL AS mecanico,
            sc.id AS id_solicitud,

            c.nombre AS cliente,
            c.email,
            c.telefono,

            v.marca,
            v.modelo,
            v.matricula,

            sc.id,
            sc.id_cliente,
            sc.id_vehiculo,
            sc.fecha_solicitada,
            sc.estado_solicitud,
            sc.solicitante_nombre
        FROM solicitudes_cita sc
        LEFT JOIN citas ci ON sc.id = ci.id_solicitud
        LEFT JOIN clientes c ON sc.id_cliente = c.id
        LEFT JOIN vehiculos v ON sc.id_vehiculo = v.id
        WHERE ci.id IS NULL

        UNION ALL

        SELECT 
            ci.id AS cita_id,
            ci.fecha,
            ci.estado_cita,
            CASE
                WHEN ci.descripcion_cliente IS NOT NULL AND ci.descripcion_cliente <> '' THEN ci.descripcion_cliente
                ELSE sc.descripcion_cliente
            END AS descripcion_cliente,

            ci.id_mecanico,
            ci.veredicto_mecanico,
            u.nombre AS mecanico,
            ci.id_solicitud,

            c.nombre AS cliente,
            c.email,
            c.telefono,
            v.marca,
            v.modelo,
            v.matricula,

            sc.id,
            sc.id_cliente,
            sc.id_vehiculo,
            sc.fecha_solicitada,
            sc.estado_solicitud,
            sc.solicitante_nombre
        FROM citas ci
        LEFT JOIN solicitudes_cita sc ON ci.id_solicitud = sc.id
        LEFT JOIN clientes c ON ci.id_cliente = c.id
        LEFT JOIN vehiculos v ON ci.id_vehiculo = v.id
        LEFT JOIN usuarios u ON ci.id_mecanico = u.id
    ) AS resultado_de_union
    ORDER BY resultado_de_union.fecha DESC;
    ";

    $query = $mysqli->query($sql);

    if ($query && $query->num_rows > 0) {
        while ($fila = $query->fetch_assoc()) {
            $resultado[] = $fila;
        }
    }

    return $resultado;
}






function getClienteById($id_cliente) {
    include("db.php");
    $query = "SELECT * FROM clientes WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();  // Devuelve los datos del cliente si existe
    } else {
        return null;  // No se encontró el cliente
    }
}

function getCitaById($id_solicitud) {
    include("db.php");

    // Verificar si ya existe una cita para la solicitud
    $query = "SELECT * FROM citas WHERE id_solicitud = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id_solicitud);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si ya existe una cita, devolverla
        return $result->fetch_assoc();
    } else {
        // Si no existe la cita, devolver null
        return null;
    }
}

function getCitaBySolicitudId($solicitud_id) {
    include("db.php");
    $query = "SELECT * FROM citas WHERE id_solicitud = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $solicitud_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();  // Devuelve los datos de la cita si existe
    } else {
        return null;  // No hay cita asociada
    }
}

function getVehiculoById($id_vehiculo) {
    include("db.php");
    $query = "SELECT * FROM vehiculos WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id_vehiculo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verifica si existe el vehículo
    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Devuelve los datos del vehículo
    } else {
        return null; // Si no existe el vehículo
    }
}

//Funcion utilizada en modulo_citas_edit.php
function getSolicitudById($solicitud_id) {
    include("db.php");

    // Consulta SQL para obtener la información completa
    $sql = "SELECT 
                c.nombre AS cliente_nombre, 
                v.marca AS vehiculo_marca, 
                v.modelo AS vehiculo_modelo, 
                v.matricula AS vehiculo_matricula, 
                s.fecha_solicitada AS fecha, 
                s.descripcion_cliente AS descripcion_cliente,
                s.estado_solicitud   AS estado
            FROM solicitudes_cita s
            JOIN clientes c ON s.id_cliente = c.id
            JOIN vehiculos v ON s.id_vehiculo = v.id
            WHERE s.id = ?";

    // Preparar y ejecutar la consulta
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $solicitud_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $solicitud = $result->fetch_assoc();

    return $solicitud;
}
//ESTA ES PARA ASIGNAR MECANICO A LA SOLICITUD
function getSolicitudByIdMecanico($solicitud_id) {
    include("db.php");
    $sql = "SELECT id_cliente, id_vehiculo, fecha_solicitada, descripcion_cliente, solicitante_nombre 
            FROM solicitudes_cita WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $solicitud_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $solicitud = $result->fetch_assoc();


    return $solicitud;
}

//Funcion para obtener citas por mecanico
//Usa COALESCE para que se muestren los valores de 1solicitudes o 2citas siempre
function getCitasAsignadas($id_usuario) {
    include("db.php");

    $resultado = [];

    // Validación básica
    $id_usuario = intval($id_usuario);

    $stmt = $mysqli->prepare("
        SELECT 
            c.id_solicitud,
            c.id AS cita_id,
            COALESCE(sc.fecha_solicitada, c.fecha) AS fecha_cita,
            COALESCE(sc.descripcion_cliente, c.descripcion_cliente) AS descripcion_cita,
            c.estado_cita,
            cl.nombre AS cliente,
            v.marca,
            v.modelo,
            v.matricula,
            sc.estado_solicitud
        FROM citas c
        LEFT JOIN solicitudes_cita sc ON c.id_solicitud = sc.id
        LEFT JOIN clientes cl ON c.id_cliente = cl.id
        LEFT JOIN vehiculos v ON c.id_vehiculo = v.id
        WHERE c.id_mecanico = ?
        ORDER BY fecha_cita DESC
    ");

    if (!$stmt) {
        error_log("Error en la consulta SQL: " . $mysqli->error);
        return [];
    }

    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $resultado_sql = $stmt->get_result();

    while ($fila = $resultado_sql->fetch_assoc()) {
        $resultado[] = $fila;
    }

    return $resultado;
}








function asignarMecanico($solicitud_id, $mecanico_id) {
    include("db.php");  

    // SQL para asignar el mecánico en la solicitud de cita
    $sql = "UPDATE solicitudes_cita SET id_mecanico = ? WHERE id = ?";

    // Preparamos y ejecutamos la consulta
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $mecanico_id, $solicitud_id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

//Funcion utilizada en modulo_citas_new.php
function getMecanicos() {
    include("db.php"); 

    $resultado = array();

    // SQL para obtener todos los mecánicos
    $sql = "SELECT id, nombre FROM usuarios WHERE id_rol = 3";  // Suponiendo que el rol 3 es para mecánicos

    $query = $mysqli->query($sql);

    if ($query->num_rows > 0) {
        while ($fila = $query->fetch_assoc()) {
            array_push($resultado, $fila);  // Agregamos cada fila al array resultado
        }
    }

    return $resultado;
}

//Funcion utilizada en modulo_citas_new.php
function getClientes() {
    include("db.php"); 

    $resultado = array();

    // SQL para obtener todos los clientes desde la tabla clientes
    $sql = "SELECT id, nombre, email FROM clientes";

    $query = $mysqli->query($sql);

    if ($query->num_rows > 0) {
        while ($fila = $query->fetch_assoc()) {
            array_push($resultado, $fila);  // Agregamos cada fila al array resultado
        }
    }

    return $resultado;
}


// Actualiza el estado de la solicitud de cita a 'confirmada'
function actualizarEstadoSolicitud($solicitud_id, $estado) {
    include("db.php"); 
    $query = "UPDATE solicitudes_cita SET estado = ? WHERE id = ?"; 
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('si', $estado, $solicitud_id); 
    return $stmt->execute();
}


function crearCita($solicitud_id, $mecanico_id, $fecha) {
    include("db.php");

    // Obtener los detalles de la solicitud de cita
    $query_solicitud = "SELECT id_cliente, id_vehiculo, descripcion_cliente FROM solicitudes_cita WHERE id = $solicitud_id";
    $result_solicitud = $mysqli->query($query_solicitud);

    if ($result_solicitud->num_rows > 0) {
        // Obtener los datos de la solicitud de cita
        $solicitud = $result_solicitud->fetch_assoc();
        $id_cliente = $solicitud['id_cliente'];
        $id_vehiculo = $solicitud['id_vehiculo'];
        $descripcion_cliente = $solicitud['descripcion_cliente'];

        // Insertar la cita en la tabla 'citas'
        $query_insertar = "INSERT INTO citas (id_solicitud, id_mecanico, id_cliente, id_vehiculo, descripcion, fecha, estado_cita) 
                           VALUES ($solicitud_id, $mecanico_id, $id_cliente, $id_vehiculo, '$descripcion_cliente', '$fecha', 'En revision')";
        
        return $mysqli->query($query_insertar);
    }

    return false;  // Si no se encuentra la solicitud
}

function actualizarEstadoCita($cita_id, $nuevo_estado) {
    include("db.php");

    // Verificar que el nuevo estado sea "En revision" o "Finalizada"
    if ($nuevo_estado != 'En revision' && $nuevo_estado != 'Finalizada') {
        return false;
    }

    // Actualizar el estado de la cita
    $sql = "UPDATE citas SET estado_cita = '$nuevo_estado' WHERE id = $cita_id";
    
    return $mysqli->query($sql);
}

// Obtiene la fecha de la solicitud de cita
function obtenerFechaSolicitud($solicitud_id) {
    include("db.php"); 
    
    echo "Buscando fecha para la solicitud ID: $solicitud_id <br>";

    $query = "SELECT fecha_solicitada FROM solicitudes_cita WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $solicitud_id);
    $stmt->execute();
    $stmt->bind_result($fecha);
    $stmt->fetch();
    
    echo "Fecha obtenida: " . ($fecha ?: "NULL") . "<br>";

    return $fecha;
}

//Funcion usada en modulo_clientes_list.php
function getAllClientesyVehiculos($tabla) {
    include("db.php");
    $resultado = [];

    // Consulta para obtener clientes con sus vehículos a través de la tabla intermedia
    $sql = "SELECT c.id, c.nombre, c.email, c.telefono, 
                   v.id AS vehiculo_id, v.marca, v.modelo, v.matricula
            FROM $tabla c
            LEFT JOIN clientes_vehiculos cv ON c.id = cv.id_cliente
            LEFT JOIN vehiculos v ON cv.id_vehiculo = v.id
            ORDER BY c.id";

    $query = $mysqli->query($sql);

    if ($query->num_rows > 0) {
        while ($fila = $query->fetch_assoc()) {
            $cliente_id = $fila['id'];

            if (!isset($resultado[$cliente_id])) {
                $resultado[$cliente_id] = [
                    'id' => $fila['id'],
                    'nombre' => $fila['nombre'],
                    'email' => $fila['email'],
                    'telefono' => $fila['telefono'],
                    'vehiculos' => []
                ];
            }

            // Si el cliente tiene un vehículo, agregarlo al array de vehículos
            if (!empty($fila['vehiculo_id'])) {
                $resultado[$cliente_id]['vehiculos'][] = [
                    'id' => $fila['vehiculo_id'],
                    'marca' => $fila['marca'],
                    'modelo' => $fila['modelo'],
                    'matricula' => $fila['matricula']
                ];
            }
        }
    }
    return array_values($resultado); // Convertir a array indexado
}



function getSolicitantesByCliente($id_cliente) {
    include("db.php");
    $solicitantes = array();

    $sql = "SELECT solicitante_nombre FROM solicitudes_cita WHERE id_cliente = $id_cliente";
    $query = $mysqli->query($sql);

    if ($query->num_rows > 0) {
        while ($fila = $query->fetch_assoc()) {
            array_push($solicitantes, $fila['solicitante_nombre']);
        }
    }

    return $solicitantes;
}


//Funcion utilizada para obtener roles en modulo_roles_list.php

function getAllV($tabla){
    include("db.php");
   $resultado=array();
   $sql="SELECT * FROM `".$tabla."` WHERE 1";
  $query=$mysqli->query($sql);    
  if($query->num_rows>0){
       while($fila=$query->fetch_assoc()){
        array_push($resultado,$fila);   
       }
      
  }
   return $resultado;
}

//Funcion utilizada para mostrar los roles enm un  select a la hora de crear nuevos usuarios
//Funcion utilizada en modulo_usuarios_new.php
function SelectOptions($tabla, $value, $mostrar)
{
    include("db.php");
    $options = "";
    $sql = "SELECT `" . $value . "`, `" . $mostrar . "` FROM `" . $tabla . "`";
    $query = $mysqli->query($sql);
    if ($query->num_rows > 0) {
        while ($fila = $query->fetch_assoc()) {

            $options .= '<option value="' . $fila[$value] . '">' . $fila[$mostrar] . '</option>';
        }
    }
    return $options;
}


//Funcion utilizada en modulo_vehiculos_list.php
function getAllVehiculosConClientesYCitas() {
    include("db.php");
    $resultado = array();
    $sql = "SELECT v.id as id_vehiculo, c.nombre as nombre_cliente, c.telefono, v.marca, v.modelo, v.año, v.matricula,
                   COUNT(ci.id) as total_citas
            FROM vehiculos v
            INNER JOIN clientes_vehiculos cv ON v.id = cv.id_vehiculo
            INNER JOIN clientes c ON cv.id_cliente = c.id
            LEFT JOIN citas ci ON v.id = ci.id_vehiculo
            GROUP BY v.id, c.nombre, v.marca, v.modelo, v.año, v.matricula
            ORDER BY v.id";
    $query = $mysqli->query($sql);
    if ($query->num_rows > 0) {
        while ($fila = $query->fetch_assoc()) {
            $resultado[] = $fila;
        }
    }
    return $resultado;
}


// Esta función es la que maenja la asignación de mecánico a la cita
function asignarMecanicoACita($id_solicitud, $mecanico_id) {
    include("db.php");

    // 🔹 Actualizar la solicitud a "confirmada"
    $query = "UPDATE solicitudes_cita SET estado_solicitud = 'confirmada' WHERE id = $id_solicitud";
    $resultado = mysqli_query($mysqli, $query);

    if ($resultado) {
        // 🔹 Obtener id_cliente e id_vehiculo de la solicitud
        $query_datos = "SELECT id_cliente, id_vehiculo, descripcion_cliente, fecha_solicitada FROM solicitudes_cita WHERE id = $id_solicitud";
        $resultado_datos = mysqli_query($mysqli, $query_datos);

        if ($resultado_datos && mysqli_num_rows($resultado_datos) > 0) {
            $datos = mysqli_fetch_assoc($resultado_datos);
            $id_cliente = $datos['id_cliente'];
            $id_vehiculo = $datos['id_vehiculo'];
            $descripcion_cliente = $datos['descripcion_cliente'];
            $fecha_solicitada = $datos['fecha_solicitada'];

            // 🔹 Insertar la cita con estado "En revisión"
            $query_cita = "INSERT INTO citas (id_solicitud, id_mecanico, id_cliente, id_vehiculo, descripcion_cliente, fecha, estado_cita) 
                           VALUES (?, ?, ?, ?, ?, ?, 'En revisión')";
            $stmt = mysqli_prepare($mysqli, $query_cita);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "iiiiss", $id_solicitud, $mecanico_id, $id_cliente, $id_vehiculo, $descripcion_cliente, $fecha_solicitada);

                $resultado_cita = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                return $resultado_cita;
            }
        }
    }

    return false;
}

function getAllVInner($tabla1,$tabla2,$id1,$id2){
     include("db.php");
    $resultado=array();
    $sql="SELECT `".$tabla1."`.*,`".$tabla2."`.*, `".$tabla1."`.id as id1 FROM `".$tabla1."` ";
    $sql.=" INNER JOIN `".$tabla2."` ON `".$tabla1."`.`".$id1."`=`".$tabla2."`.`".$id2."`";
    
   $query=$mysqli->query($sql);    
   if($query->num_rows>0){
        while($fila=$query->fetch_assoc()){
         array_push($resultado,$fila);   
        }
       
   }
    return $resultado;
}


function getAllVInner2($tabla1,$tabla2,$tabla3,$tabla_1_id_tabla_2,$tabla_1_id_tabla_3,$id_tabla2,$id_tabla3){
     include("db.php");
    $resultado=array();
    $sql="SELECT `".$tabla1."`.*,`".$tabla2."`.*,`".$tabla3."`.*, `".$tabla1."`.id as id1 FROM `".$tabla1."` ";
    $sql.=" LEFT JOIN `".$tabla2."` ON `".$tabla1."`.`".$tabla_1_id_tabla_2."`=`".$tabla2."`.`".$id_tabla2."`";
    
    $sql.=" LEFT JOIN `".$tabla3."` ON `".$tabla1."`.`".$tabla_1_id_tabla_3."`=`".$tabla3."`.`".$id_tabla3."`";
    
   $query=$mysqli->query($sql);    
   if($query->num_rows>0){
        while($fila=$query->fetch_assoc()){
         array_push($resultado,$fila);  
        }
       
   }
    return $resultado;
}

function getById($tabla,$id){
    include("db.php");
    $fila=array();
   $sql="SELECT * FROM `".$tabla."` WHERE `id`=".$id;
    $query=$mysqli->query($sql);    
    if($query->num_rows>0){
        $fila=$query->fetch_assoc();
    
    }
    return $fila;
}


//Funcion utilizada en modulo_citas_insert.php
function saveV($tabla, $datos)
{

    include("db.php");
    $sql = "INSERT INTO `" . $tabla . "`(";

    $aux = 0;
    foreach ($datos as $k => $v) {
        if ($aux == 0) {
            $sql .= "`" . $k . "`";
            $aux++;
        } else {
            $sql .= ",`" . $k . "`";
        }
    }
    $sql .= ")";
    $sql .= "VALUES (";
    $aux = 0;
    foreach ($datos as $k => $v) {
        if ($aux == 0) {
            $sql .= "'" . $v . "'";
            $aux++;
        } else {
            $sql .= ",'" . $v . "'";
        }
    }
    $sql .= ")";

    if ($mysqli->query($sql)) return $mysqli->insert_id;
    else return 0;
}

//FUNCION PARA OBTENER TODA LA INFORMACION Y REDACTAR PDF (imprimir_cita.php)
function getCitaForPDF($id, $tipo = 'solicitud') {
    include("db.php");
    $resultado = array();

    // Validar id
    $id = is_numeric($id) ? (int)$id : 0;
    if ($id <= 0) return $resultado;

    if ($tipo === 'solicitud') {
        // Busca la info por solicitud
        $sql = "
            SELECT
              s.id                   AS solicitud_id,
              s.solicitante_nombre   AS solicitante_nombre,
              cl.nombre              AS cliente,
              cl.email               AS cliente_email,
              cl.telefono            AS cliente_telefono,
              v.marca                AS vehiculo_marca,
              v.modelo               AS vehiculo_modelo,
              v.año                  AS vehiculo_anio,
              v.matricula            AS vehiculo_matricula,
              s.fecha_solicitada     AS fecha_solicitada,
              ci.id                  AS id,
              ci.fecha               AS fecha_atencion,
              s.descripcion_cliente  AS descripcion_solicitud,
              ci.descripcion_cliente AS descripcion_cita,
              s.estado_solicitud     AS estado_solicitud,
              ci.estado_cita         AS estado_cita,
              ci.veredicto_mecanico  AS veredicto_mecanico,
              u.nombre               AS mecanico_nombre
            FROM solicitudes_cita s
            JOIN clientes cl       ON cl.id = s.id_cliente
            JOIN vehiculos v       ON v.id = s.id_vehiculo
            LEFT JOIN citas ci     ON ci.id_solicitud = s.id
            LEFT JOIN usuarios u   ON u.id = ci.id_mecanico
            WHERE s.id = $id
        ";
    } else {
        // Busca la info por cita directa (sin solicitud)
        $sql = "
            SELECT
              ci.id                  AS id,
              NULL                   AS solicitud_id,
              NULL                   AS solicitante_nombre,
              cl.nombre              AS cliente,
              cl.email               AS cliente_email,
              cl.telefono            AS cliente_telefono,
              v.marca                AS vehiculo_marca,
              v.modelo               AS vehiculo_modelo,
              v.año                  AS vehiculo_anio,
              v.matricula            AS vehiculo_matricula,
              NULL                   AS fecha_solicitada,
              ci.fecha               AS fecha_atencion,
              NULL                   AS descripcion_solicitud,
              ci.descripcion_cliente AS descripcion_cita,
              NULL                   AS estado_solicitud,
              ci.estado_cita         AS estado_cita,
              ci.veredicto_mecanico  AS veredicto_mecanico,
              u.nombre               AS mecanico_nombre
            FROM citas ci
            JOIN clientes cl       ON cl.id = ci.id_cliente
            JOIN vehiculos v       ON v.id = ci.id_vehiculo
            LEFT JOIN usuarios u   ON u.id = ci.id_mecanico
            WHERE ci.id = $id
        ";
    }

    $query = $mysqli->query($sql);
    if ($query && $query->num_rows > 0) {
        return $query->fetch_assoc();
    }
    return $resultado;
}





?>