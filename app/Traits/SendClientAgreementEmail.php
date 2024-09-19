<?php

namespace App\Traits;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

trait SendClientAgreementEmail
{
    public function sendAgreementEmail($data, $files = [])
    {

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->SMTPDebug =false; // Enable verbose debug output
            $mail->Host = 'mail.fujtrade.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'info@fujtrade.com';
            $mail->Password = 'n7iiPGEY-~Kl';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('info@fujtrade.com', 'FujTrade');
            $mail->addAddress($data["email"], $data["client_name"] ?? '');

            // Attachments
            foreach ($files as $file) {
                $mail->addAttachment($file);
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = $data["title"];
            $mail->Body = view('mail.contract_mail', $data)->render();

            $mail->send();
            Log::info('Message has been sent to: ' . $data["email"]);
        } catch (Exception $e) {
            Log::error('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }
    }
}
