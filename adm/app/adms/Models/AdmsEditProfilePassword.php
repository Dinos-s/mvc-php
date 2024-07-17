<?php
    namespace App\adms\Models;

    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    class AdmsEditProfilePassword {
        private array|null $data;

        /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
        private bool $result = false;

        /** @var array|null $resultBD Recebe os registros do banco de dados */
        private array|null $resultBD;

        /**
         * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
         */
        function getResult(): bool
        {
            return $this->result;
        }

        /**
         * @return bool Retorna os detalhes do registro
         */
        function getResultBd(): array|null
        {
            return $this->resultBD;
        }

        public function viewProfile(): void
        {

            $viewUser = new \App\adms\Models\helper\AdmsRead();
            $viewUser->fullRead(
                "SELECT id
                                FROM adms_users
                                WHERE id=:id
                                LIMIT :limit",
                "id=" . $_SESSION['user_id'] . "&limit=1"
            );

            $this->resultBD = $viewUser->getResult();
            if ($this->resultBD) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00'>Erro: Perfil não encontrado!</p>";
                $this->result = false;
            }
        }

        public function update(array $data = null): void
        {
            $this->data = $data;

            $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
            $valEmptyField->valField($this->data);
            if ($valEmptyField->getResult()) {
                $this->valInput();
            } else {
                $this->result = false;
            }
        }

        private function valInput(): void
        {
            $valPassword = new \App\adms\Models\helper\AdmsValPassword();
            $valPassword->validatePassword($this->data['password']);

            if ($valPassword->getResult()) {
                $this->edit();
            } else {
                $this->result = false;
            }
        }

        private function edit(): void
        {
            $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
            $this->data['modificado'] = date("Y-m-d H:i:s");

            $upUser = new \App\adms\Models\helper\AdmsUpdate();
            $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id=" . $_SESSION['user_id']);

            if ($upUser->getResult()) {
                $_SESSION['msg'] = "<p style='color: green;'>Senha editada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Senha não editada com sucesso!</p>";
                $this->result = false;
            }
        }
    }
?>