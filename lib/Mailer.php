<?php
require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

// Envio de correo via SMTP (Gmail por defecto), configurado desde .env.
// Sin Composer: PHPMailer vive copiado a mano en lib/PHPMailer/ (solo los
// 3 archivos que hacen falta para SMTP, sin OAuth/POP3).
class Mailer {

    // Devuelve true si se pudo enviar, false si fallo (revisa error_log).
    public static function send($toEmail, $toName, $subject, $bodyHtml) {
        $host = env('MAIL_HOST', '');
        $username = env('MAIL_USERNAME', '');
        $password = env('MAIL_PASSWORD', '');

        if (empty($host) || empty($username) || empty($password)) {
            error_log('Mailer: MAIL_HOST/MAIL_USERNAME/MAIL_PASSWORD no configurados en .env, no se envio "' . $subject . '" a ' . $toEmail);
            return false;
        }

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $host;
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
            $mail->Port = (int) env('MAIL_PORT', 587);
            $mail->CharSet = 'UTF-8';

            $mail->setFrom(env('MAIL_FROM', $username), env('MAIL_FROM_NAME', 'svNDA'));
            $mail->addAddress($toEmail, $toName);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $bodyHtml;
            $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $bodyHtml));

            $mail->send();
            return true;
        } catch (PHPMailerException $e) {
            error_log('Mailer: fallo el envio a ' . $toEmail . ' - ' . $mail->ErrorInfo);
            return false;
        }
    }

    // Correo de verificacion institucional (codigo de 6 digitos).
    public static function sendVerificationCode($toEmail, $toName, $code) {
        $subject = 'Verifica el correo de tu institucion · svNDA';
        $body = '<div style="font-family:sans-serif;max-width:480px;margin:0 auto">'
              . '<h2 style="color:#021526">Verifica tu institucion</h2>'
              . '<p>Hola ' . htmlspecialchars($toName, ENT_QUOTES, 'UTF-8') . ',</p>'
              . '<p>Usa este codigo para confirmar que este correo pertenece a tu institucion en svNDA:</p>'
              . '<p style="font-size:32px;font-weight:700;letter-spacing:6px;color:#c98a3d;text-align:center;margin:24px 0">' . htmlspecialchars($code, ENT_QUOTES, 'UTF-8') . '</p>'
              . '<p>El codigo vence en 15 minutos. Si tu no solicitaste esto, puedes ignorar este correo.</p>'
              . '</div>';
        return self::send($toEmail, $toName, $subject, $body);
    }
}
