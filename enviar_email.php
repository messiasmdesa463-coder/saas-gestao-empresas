<?php
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarEmail($destinatario, $assunto, $corpo) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // ajuste conforme seu provedor
        $mail->SMTPAuth = true;
        $mail->Username = 'seuemail@gmail.com'; // seu e-mail
        $mail->Password = 'sua_senha_de_app'; // senha de app (não a senha normal)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('seuemail@gmail.com', 'Sistema SaaS');
        $mail->addAddress($destinatario);

        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body = $corpo;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
