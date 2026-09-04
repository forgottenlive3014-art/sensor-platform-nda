<?php
require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

// Envio de correo via SMTP (Gmail por defecto), configurado desde .en
class Mailer {

    // Devuelve true si se pudo enviar, false si fallo (revisa error_log).
    // $embedLogo=true adjunta assets/media/img/logo-email.png como imagen
    // incrustada via Content-ID (cid:nda-logo), referenciada en el HTML
    // con <img src="cid:nda-logo">. A diferencia de un data:URI en base64
    // (que Gmail suele bloquear/no renderizar en correos recibidos), el
    // cid embebido si es soportado de forma consistente por Gmail y el
    // resto de clientes de correo.
    public static function send($toEmail, $toName, $subject, $bodyHtml, $embedLogo = false) {
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
            // Sin esto, si algo (firewall/antivirus/red) bloquea el trafico
            // SMTP dejando la conexion abierta pero sin datos, PHPMailer se
            // queda esperando hasta el Timeout por defecto (300s) — mucho
            // mas que el max_execution_time de PHP (120s en este server),
            // asi que el script muere con un fatal error no capturable en
            // vez de que el catch de abajo devuelva false con gracia.
            // $mail->Timeout solo aplica al fread() de SMTP::get_lines();
            // la espera real ocurre en un stream_select() que usa
            // SMTP::$Timelimit (300s por defecto, sin setter en PHPMailer),
            // por eso hay que tocarla directo en el objeto SMTP interno.
            $mail->Timeout = 15;
            $mail->SMTPKeepAlive = false;
            $smtp = $mail->getSMTPInstance();
            $smtp->Timelimit = 15;

            $mail->setFrom(env('MAIL_FROM', $username), env('MAIL_FROM_NAME', 'svNDA'));
            $mail->addAddress($toEmail, $toName);

            $mail->isHTML(true);
            if ($embedLogo) {
                $logoPath = __DIR__ . '/../assets/media/img/logo-email.png';
                if (is_file($logoPath)) {
                    $mail->addEmbeddedImage($logoPath, 'nda-logo', 'logo-email.png');
                }
            }
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

    // Plantilla compartida por los correos de verificacion: logo, titulo,
    // saludo, texto y el codigo en una pastilla, con una jerarquia de
    // tamanos de texto consistente (titulo > texto > codigo > pie).
    private static function verificationTemplate($title, $toName, $introText, $code, $minutes) {
        $logoHtml = '<img src="cid:nda-logo" width="72" height="76" alt="NDA" style="display:block;margin:0 auto 20px">';
        return '<div style="font-family:-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;max-width:480px;margin:0 auto;padding:36px 24px;text-align:center;background:#ffffff">'
              . $logoHtml
              . '<h1 style="margin:0 0 22px;font-size:26px;font-weight:800;color:#16213a">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</h1>'
              . '<p style="margin:0 0 6px;font-size:15px;color:#3c4657">Hola ' . htmlspecialchars($toName, ENT_QUOTES, 'UTF-8') . ',</p>'
              . '<p style="margin:0 0 26px;font-size:15px;color:#3c4657;line-height:1.5">' . $introText . '</p>'
              . '<div style="margin:0 0 26px">'
              . '<span style="display:inline-block;background:#c98a3d;color:#ffffff;font-size:26px;font-weight:800;letter-spacing:7px;padding:16px 30px;border-radius:50px">' . htmlspecialchars($code, ENT_QUOTES, 'UTF-8') . '</span>'
              . '</div>'
              . '<p style="margin:0 0 4px;font-size:13px;color:#8a93a3">El código vence en ' . (int) $minutes . ' minutos.</p>'
              . '<p style="margin:0;font-size:13px;color:#8a93a3">Si no solicitaste esto, puedes ignorar este correo.</p>'
              . '</div>';
    }

    // Correo de verificacion institucional (codigo de 6 digitos).
    public static function sendVerificationCode($toEmail, $toName, $code) {
        $subject = 'Verifica el correo de tu institucion · svNDA';
        $intro = 'Usa este código para confirmar que este correo pertenece a tu institución en svNDA.';
        $body = self::verificationTemplate('Verifica tu institución', $toName, $intro, $code, 3);
        return self::send($toEmail, $toName, $subject, $body, true);
    }

    // Correo de verificacion de cuenta personal (codigo de 6 digitos), usado
    // al registrarse (cuenta general o institucional no-director) para
    // confirmar que el correo ingresado es real y le pertenece a quien se
    // registro, antes de dejarlo entrar.
    public static function sendAccountVerificationCode($toEmail, $toName, $code) {
        $subject = 'Verifica tu correo · svNDA';
        $intro = 'Usa este código para confirmar tu cuenta en svNDA.';
        $body = self::verificationTemplate('Verifica tu correo', $toName, $intro, $code, 3);
        return self::send($toEmail, $toName, $subject, $body, true);
    }
}
