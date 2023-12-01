<?php

namespace App\Service;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailService
{
	public function sendMail(string $senderEmail, string $senderName, string $destinataire, string $sujet, string $message): void
	{
		$mail = new PHPMailer(true);

		try {
			// Configuration serveur
			$mail->SMTPDebug = SMTP::DEBUG_OFF;
			$mail->isSMTP();
			$mail->Host = $_ENV['SMTP_HOST'];
			$mail->SMTPAuth = true;
			$mail->Username = $_ENV['SMTP_USERNAME'];
			$mail->Password = $_ENV['SMTP_PASSWORD'];
			$mail->CharSet = 'UTF-8';
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port = $_ENV['SMTP_PORT'];

			// Expéditeur
			$mail->setFrom($senderEmail, $senderName);

			// Destinataires
			$mail->addAddress($destinataire);

			// Message
			$mail->isHTML(true);
			$mail->Subject = $sujet;
			$mail->Body = $message;

			$mail->send();

		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}