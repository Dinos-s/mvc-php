<?php
    namespace App\adms\Models;

    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    /**
     * Solicitar novo link para cadastrar nova senha
     *
     * @author Celke
     */
    class AdmsRecoverPassword {
        private array|null $data;
        private bool $result;
        private array|null $resultBD;
        private string $firstName;
        private string $url;
        private string $fromEmail;
        private array $emailData;
        private array $dataSave;

        /**
         * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
         */
        function getResult(): bool
        {
            return $this->result;
        }

        public function recoverPassword(array $data = null): void
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
            $newConfEmail->fullRead("SELECT id, name, email FROM adms_users WHERE email=:email LIMIT :limit","email={$this->data['email']}&limit=1");
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
                $this->dataSave['recover_password'] = password_hash(date("Y-m-d H:i:s") . $this->resultBD[0]['id'], PASSWORD_DEFAULT);            
                $this->dataSave['modificado'] = date("Y-m-d H:i:s");

                $upNewConfEmail = new \App\adms\Models\helper\AdmsUpdate();
                $upNewConfEmail->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBD[0]['id']}");

                if($upNewConfEmail->getResult()){
                    $this->resultBD[0]['recover_password'] = $this->dataSave['recover_password'];
                    $this->sendEmail();
                }else{
                    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link não enviado, tente novamente!</p>";
                    $this->result = false;
                }

        }

        private function sendEmail(): void
        {
            $sendEmail = new \App\adms\Models\helper\AdmsSendEmail();
            $this->emailHTML();
            $this->emailText();
            $sendEmail->sendEmail($this->emailData, 1);
            if ($sendEmail->getResult()) {
                $_SESSION['msg'] = "<p style='color: green;'>Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!</p>";
                $this->result = true;
            } else {
                $this->fromEmail = $sendEmail->getFromEmail();
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail com as intruções para recuperar a senha não enviado, tente novamente ou entre em contato com o e-mail {$this->fromEmail}!</p>";
                $this->result = false;
            }
        }

        private function emailHTML():void {
            $name = explode(" ", $this->resultBD[0]['nome']);
            $this->firstName = $name[0];

            $this->emailData['toEmail'] = $this->data['email'];
            $this->emailData['toName'] = $this->resultBD[0]['nome'];
            $this->emailData['subject'] = "Recuperar Senha";
            $this->url = URLADM . "update-password/index?key=" . $this->resultBD[0]['recover_password'];

            $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
            $this->emailData['contentHtml'] .= "Sua solicitação da recuperação de senha foi recebida!<br><br>";
            $this->emailData['contentHtml'] .= "Para continuar o processo de recuperação de senha, clique no link abaixo: <br><br>";
            $this->emailData['contentHtml'] .= "<a href='{$this->url}'>{$this->url}</a><br><br>";
        }

        private function emailText():void {
            $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
            $this->emailData['contentText'] .= "Sua solicitação da recuperação de senha foi recebida!\n\n";
            $this->emailData['contentText'] .= "Para continuar o processo de recuperação de senha, clique no link abaixo: \n\n";
            $this->emailData['contentText'] .= $this->url;
        }
    }
?>