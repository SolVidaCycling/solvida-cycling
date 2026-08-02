<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contacto.html');
    exit;
}

if (!empty($_POST['web'] ?? '')) {
    header('Location: contacto.html?estado=enviado');
    exit;
}

$nombre = trim((string) ($_POST['nombre'] ?? ''));
$correo = filter_var(trim((string) ($_POST['correo'] ?? '')), FILTER_VALIDATE_EMAIL);
$asunto = trim((string) ($_POST['asunto'] ?? ''));
$mensaje = trim((string) ($_POST['mensaje'] ?? ''));

if ($nombre === '' || $correo === false || $mensaje === '' ||
    mb_strlen($nombre) > 100 || mb_strlen($asunto) > 150 || mb_strlen($mensaje) > 5000) {
    header('Location: contacto.html?estado=error');
    exit;
}

$limpiarCabecera = static fn(string $valor): string => str_replace(["\r", "\n"], ' ', $valor);
$nombre = $limpiarCabecera($nombre);
$asunto = $limpiarCabecera($asunto);
$asuntoCorreo = $asunto !== '' ? 'Web SolVida Cycling: ' . $asunto : 'Nuevo mensaje desde SolVida Cycling';
$cuerpo = "Nombre: {$nombre}\nCorreo: {$correo}\n\nMensaje:\n{$mensaje}\n";
$cabeceras = [
    'From: SolVida Cycling <info@solvidacycling.com>',
    'Reply-To: ' . $correo,
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: PHP/' . phpversion(),
];

$enviado = mail(
    'info@solvidacycling.com',
    mb_encode_mimeheader($asuntoCorreo, 'UTF-8'),
    $cuerpo,
    implode("\r\n", $cabeceras)
);

header('Location: contacto.html?estado=' . ($enviado ? 'enviado' : 'error'));
exit;
