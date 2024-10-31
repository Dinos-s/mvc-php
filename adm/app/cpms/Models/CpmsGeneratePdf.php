<?php 
    namespace App\cpms\Models;

    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    class CpmsGeneratePdf {
        /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
        private bool $result = false;

        /** @var array|null $resultBD Recebe os registros do banco de dados */
        private array|null $resultBD;

        /** @var int|string|null $id Recebe o id do registro */
        private int|string|null $id;

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

        public function viewUser(int $id): void
        {
            $this->id = $id;

            $viewUser = new \App\adms\Models\helper\AdmsRead();
            $viewUser->fullRead(
                "SELECT usr.id, usr.name AS name_usr, usr.nickname, usr.email, usr.user, usr.image, usr.created, usr.modificado,
                                sit.name AS name_sit,
                                col.color, lev.name AS name_lev
                                FROM adms_users AS usr
                                INNER JOIN adms_sits_users AS sit ON sit.id=usr.adms_sits_user_id
                                INNER JOIN adms_colors AS col ON col.id=sit.adms_color_id
                                INNER JOIN adms_access_levels AS lev ON lev.id=usr.adms_access_levels_id
                                WHERE usr.id=:id AND lev.order_levels >:order_levels
                                LIMIT :limit",
                "id={$this->id}&order_levels=". $_SESSION['order_levels'] ."&limit=1"
            );

            $this->resultBD = $viewUser->getResult();        
            if ($this->resultBD) {
                // $this->result = true;
                $this->gerarPdf();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                $this->result = false;
            }
        }

        private function gerarPdf() {
            $data_pdf = "<h1 style='color: #f00;'>Dados do Usuário</h1>";
            $data_pdf .= "ID do usuário: " . $this->resultBD[0]['id'] . "<br>";
            $data_pdf .= "Nome do usuário: " . $this->resultBD[0]['name_usr'] . "<br>";
            $data_pdf .= "Apelido do usuário: " . $this->resultBD[0]['nickname'] . "<br>";
            $data_pdf .= "E-mail do usuário: " . $this->resultBD[0]['email'] . "<br>";
            $data_pdf .= "Situação do usuário: " . $this->resultBD[0]['name_sit'] . "<br>";
            $data_pdf .= "Nível de acesso do usuário: " . $this->resultBD[0]['name_lev'] . "<br>";

            $GerarPdf = new \App\cpms\Models\helper\CpmsGeneratePdf();
            $GerarPdf->GeneratePdf($data_pdf);

            $this->result = true;
        }
    }
?>