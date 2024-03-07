<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PhpParser\Node\Expr\Cast\String_;

class EmailService
{
    private string $smtpServer;
    private int $smtpPort;
    private string $smtpAccount;
    private string $smtpPwd;
    private PHPMailer $mail;

    public function __construct(
        string $smtpServer,
        int $smtpPort,
        string $smtpAccount,
        string $smtpPwd
    ) {
        $this->smtpServer = $smtpServer;
        $this->smtpPort = $smtpPort;
        $this->smtpAccount = $smtpAccount;
        $this->smtpPwd = $smtpPwd;
        $this->mail = new PHPMailer(true);
    }

    public function sendEmail(string $recevier, string $subject, string $body) : String
    {
        try {
            $this->configEmail();
            $this->mail->setFrom($this->smtpAccount, 'Mailer');
            $this->mail->addAddress($recevier);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->send();
            return 'Le mail a été envoyé';
        } 
        catch (Exception $e) {
           return "Le mail n'a pas été envoyé. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

    public function configEmail() 
    {
        //Server settings
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();
        $this->mail->Host       = $this->smtpServer; 
        $this->mail->SMTPAuth   = true; 
        $this->mail->Username   = $this->smtpAccount;
        $this->mail->Password   = $this->smtpPwd;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port       = $this->smtpPort; 
    }
}
