<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Solicitar novo link para confirmar o e-mail
 *
 * @author GMR
 */
class AdmsNewConfEmail 
{

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBD Recebe os registros do banco de dados */
    private array|null $resultBD;

    /** @var string $firstName Recebe o primeiro nome do usuário */
    private string $firstName;
    private string $fromEmail;

    /** @var array $emailData Recebe dados do conteúdo do e-mail */
    private array $emailData;

    private array $dataSave;

    private string $url;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * 
     * @return void
     */
    public function newConfEmail(array $data = null): void
    {
        $this->data = $data;
        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if($valEmptyField->getResult()){
            $this->valUser();
        }else{
            $this->result = false;
        }
    }

    private function valUser(): void
    {
        $newConfEmail = new \App\adms\Models\helper\AdmsRead();
        $newConfEmail->fullRead("SELECT id, name, email, conf_email 
                                FROM adms_users
                                WHERE email=:email
                                LIMIT :limit",
            "email={$this->data['email']}&limit=1"
        );
        $this->resultBD = $newConfEmail->getResult();
        if ($this->resultBD) {
            $this->valConfEmail();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail não cadastrado!</p>";
            $this->result = false;
        }
    }

    private function valConfEmail(): void
    {
        if ((empty($this->resultBD[0]['conf_email'])) or ($this->resultBD[0]['conf_email'] == NULL)) {
            $this->dataSave['conf_email'] = password_hash(date("Y-m-d H:i:s") . $this->resultBD[0]['id'], PASSWORD_DEFAULT);            
            $this->dataSave['modificado'] = date("Y-m-d H:i:s");

            $upNewConfEmail = new \App\adms\Models\helper\AdmsUpdate();
            $upNewConfEmail->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBD[0]['id']}");

            if($upNewConfEmail->getResult()){
                $this->resultBD[0]['conf_email'] = $this->dataSave['conf_email'];
                $this->sendEmail();
            }else{
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link não enviado, tente novamente!</p>";
                $this->result = false;
            }
        } else {
            $this->sendEmail();
        }
    }

    private function sendEmail(): void
    {
        $sendEmail = new \App\adms\Models\helper\AdmsSendEmail();
        $this->emailHTML();
        $this->emailText();
        $sendEmail->sendEmail($this->emailData, 1);
        if ($sendEmail->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Novo link enviado com sucesso. Acesse a sua caixa de e-mail para confimar o e-mail!</p>";
            $this->result = true;
        } else {
            $this->fromEmail = $sendEmail->getFromEmail();
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link não enviado, tente novamente ou entre em contato com o e-mail {$this->fromEmail}!</p>";
            $this->result = false;
        }
    }

    private function emailHTML(): void
    {
        $name = explode(" ", $this->resultBD[0]['name']);
        $this->firstName = $name[0];

        $this->emailData['toEmail'] = $this->data['email'];
        $this->emailData['toName'] = $this->resultBD[0]['name'];
        $this->emailData['subject'] = "Confirma sua conta";
        $this->url = URLADM . "conf-email/index?key=" . $this->resultBD[0]['conf_email'];

        $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
        $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastro em nosso site!<br><br>";
        $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='{$this->url}'>{$this->url}</a><br>";
    }

    private function emailText(): void
    {
        $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
        $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastro em nosso site!\n\n";
        $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: \n\n";
        $this->emailData['contentText'] .=  $this->url . "\n";
    }
}
