<?php
// Validar teléfono: 9 dígitos, con o sin espacios
function validarTelefono($telefono) {
    $telefono = str_replace(' ', '', $telefono); // quitar espacios
    return preg_match('/^[0-9]{9}$/', $telefono);
}

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


// Validar matrícula: admitimos formatos comunes (España y genéricos alfanuméricos)
function validarMatricula($matricula) {
    $matricula = strtoupper(str_replace(' ', '', $matricula)); // quitar espacios y pasar a mayúsculas

    // Ej: 1234ABC (España), ABC1234, AB-123-CD (Francia), etc.
    return preg_match('/^[A-Z0-9\- ]{5,12}$/i', $matricula);
}

function validarAnioVehiculo($anio) {
    return is_numeric($anio) && strlen($anio) === 4 && $anio >= 1900 && $anio <= date("Y") + 1;
}

function validarFechaFutura($fecha) {
    return strtotime($fecha) >= time();
}
?>