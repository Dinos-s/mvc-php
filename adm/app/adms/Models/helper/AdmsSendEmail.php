<?php

namespace App\adms\Models\helper;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Classe genérica para enviar e-mail
 *
 * @author GMR
 */
class AdmsSendEmail
{
    /** @var array $data Receber as informações do conteúdo do e-mail */
    private array $data;

    /** @var array $dataInfoEmail Receber as credenciais do e-mail */
    private array $dataInfoEmail;

    /** @var array|null $resultBD Recebe os registros do banco de dados */
    private array|null $resultBD;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var string $fromEmail Recebe o e-mail do remetente */
    private string $fromEmail = EMAILADM;

    /** @var int $optionConfEmail Recebe o id do e-mail que será utilizado para enviar e-mail */
    private int $optionConfEmail;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return string Retorna o e-mail do remetente
     */
    function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    public function sendEmail(array $data, int $optionConfEmail): void
    {
        $this->optionConfEmail = $optionConfEmail;
        $this->data = $data;

        $this->infoPhpMailer();
    }

    private function infoPhpMailer(): void
    {
        $confEmail = new \App\adms\Models\helper\AdmsRead();
        $confEmail->fullRead("SELECT name, email, host, username, password, smtpsecure, port FROM adms_confs_emails WHERE id =:id LIMIT :limit", "id={$this->optionConfEmail}&limit=1");
        $this->resultBD = $confEmail->getResult();
        if ($this->resultBD) {
            $this->dataInfoEmail['host'] = $this->resultBD[0]['host'];
            $this->dataInfoEmail['fromEmail'] = $this->resultBD[0]['email'];
            $this->fromEmail = $this->dataInfoEmail['fromEmail'];
            $this->dataInfoEmail['fromName'] = $this->resultBD[0]['name'];
            $this->dataInfoEmail['username'] = $this->resultBD[0]['username'];
            $this->dataInfoEmail['password'] = $this->resultBD[0]['password'];
            $this->dataInfoEmail['smtpsecure'] = $this->resultBD[0]['smtpsecure'];
            $this->dataInfoEmail['port'] = $this->resultBD[0]['port'];

            $this->sendEmailPhpMailer();
        } else {
            $this->result = false;
        }
    }

    private function sendEmailPhpMailer(): void
    {
        $mail = new PHPMailer(true);

        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host       = $this->dataInfoEmail['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->dataInfoEmail['username'];
            $mail->Password   = $this->dataInfoEmail['password'];
            $mail->SMTPSecure = $this->dataInfoEmail['smtpsecure'];
            $mail->Port       = $this->dataInfoEmail['port'];

            $mail->setFrom($this->dataInfoEmail['fromEmail'], $this->dataInfoEmail['fromName']);
            $mail->addAddress($this->data['toEmail'], $this->data['toName']);

            $mail->isHTML(true);
            $mail->Subject = $this->data['subject'];
            $mail->Body    = $this->data['contentHtml'];
            $mail->AltBody = $this->data['contentText'];

            $mail->send();

            $this->result = true;
        } catch (Exception $e) {
            $this->result = false;
        }
    }
}
