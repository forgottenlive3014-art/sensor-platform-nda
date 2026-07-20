<?php
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Envia el codigo de verificacion de una institucion nueva por SMTP
// (Gmail, ver .env: MAIL_HOST/MAIL_PORT/MAIL_USER/MAIL_APP_PASSWORD).
// Devuelve true si el correo se envio, false si fallo (no lanza excepcion
// hacia el llamador, para que el flujo de registro pueda mostrar un error
// amigable en vez de un 500).
function sendVerificationEmail($to, $nombreInstitucion, $codigo) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USER');
        $mail->Password = env('MAIL_APP_PASSWORD');
        $mail->SMTPSecure = 'tls';
        $mail->Port = (int) env('MAIL_PORT', 587);
        $mail->CharSet = 'UTF-8';

        $mail->setFrom(env('MAIL_USER'), 'Natural Disaster Alert');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = 'Código de verificación - ' . $nombreInstitucion;
        $mail->Body = '<p>Hola,</p>'
            . '<p>Tu código de verificación para registrar <strong>' . htmlspecialchars($nombreInstitucion, ENT_QUOTES, 'UTF-8') . '</strong> en Natural Disaster Alert (NDA) es:</p>'
            . '<p style="font-size:28px;font-weight:bold;letter-spacing:4px;">' . htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8') . '</p>'
            . '<p>Este código expira en 15 minutos. Si tú no solicitaste este registro, puedes ignorar este correo.</p>';
        $mail->AltBody = "Tu código de verificación es: $codigo (expira en 15 minutos)";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('sendVerificationEmail failed: ' . $mail->ErrorInfo);
        return false;
    }
}
