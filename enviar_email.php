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
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'suportesaasgestao@gmail.com';
        $mail->Password = 'idycgbrndvscasap';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('suportesaasgestao@gmail.com', 'Sistema SaaS Gestão');
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
