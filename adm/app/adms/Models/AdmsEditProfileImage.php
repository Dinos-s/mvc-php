<?php
    namespace App\adms\Models;

    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    /**
     * Editar a imagem do perfil do usuario
    */
    class AdmsEditProfileImage {
        // Para evitar erros, devemos incializar a variável
        private bool $result = false;
        private array|null $resultBD;
        private int|string|null $id;
        private array|null $data;

        // Irá receber os dados relacinados a imagem
        private array|null $dataImage;

        // Recebe o caminho para armazenar a imagem, para ser usado posteriomente
        private string $directory;

        // recebe o caminho para excluir a imagem antiga
        private string $delImg;

        // recebe o slug da imagem já convertido
        private string $nameImg;

        function getResult(): bool {
            return $this->result;
        }

        function getResultBd(): array|null {
            return $this->resultBD;
        }

        public function viewProfile(): bool {
            $viewUser = new \App\adms\Models\helper\AdmsRead();
            $viewUser->fullRead(
                "SELECT id, image 
                FROM adms_users
                WHERE id=:id",
                "id=" . $_SESSION['user_id']);

            $this->resultBD = $viewUser->getResult();
            if ($this->resultBD) {
                $this->result = true;
                return true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00'>Erro: Perfil não encontrado!</p>";
                $this->result = false;
                return false;
            }
        }

        /** 
         * Recebe os dados enviados pela imagem e verifica se todos os campos foram preenchidos corretamente;
         * Caso sim, instancia a função valInput();
         * Caso não, retorna um erro para o usuário;
        */
        public function update(array $data = null): void {
            $this->data = $data;

            $this->dataImage = $this->data['new_image'];
            unset($this->data['new_image']);

            $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
            $valEmptyField->valField($this->data);
            if ($valEmptyField->getResult()) {
                if (!empty($this->dataImage['name'])) {
                    $this->valInput();
                } else {
                    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem!</p>";
                    $this->result = false;
                }
            } else {
                $this->result = false;
            }
        }

        /**
         * Verifica a extensão da imagem a ser enviada;
         * Verifica se o id informado existe no banco;
         * Se o usuário existir e o resultado da extensão for verdadeiro, realiza o upload da imagem do usuário;
         * Se ambos os resiltados forem false, retorna uma mensagem de erro;
        */
        private function valInput(): void {
            $valExtImg = new \App\adms\Models\helper\AdmsValExtImg();
            $valExtImg->validateExtImg($this->dataImage['type']);
            if (($this->viewProfile()) and ($valExtImg->getResult())) {
                $this->upload();
            } else {
                $this->result = false;
            }
        }

        /**
         * Instância a converção do nome da imagem;
         * Cria um diretório/pasta para colocar as imagem de perfil do usuário;
         * Cada diretório/pasta é indentificada por cada id do usuário, armazenando a imagem do usuário
         * Se esse diretório/pasta, a um usuário dedicado, não existir ela é criada;
         * Se o resultado da transferencia do local temporário para o local de destino for true, o edit() é executado;
        */
        private function upload(): void {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->nameImg = $slugImg->slug($this->dataImage['name']);

            $this->directory = "app/adms/assets/image/users/" . $_SESSION['user_id'] . "/";

            $uploadImgRes = new \App\adms\Models\helper\AdmsUploadImgRes();
            $uploadImgRes->upload($this->dataImage, $this->directory, $this->nameImg, 300, 300);        

            if($uploadImgRes->getResult()){
                $this->edit();
            }else{
                $this->result = false;
            }
        }

        private function edit(): void {
            $this->data['image'] = $this->nameImg;
            $this->data['modificado'] = date("Y-m-d H:i:s");

            $upUser = new \App\adms\Models\helper\AdmsUpdate();
            $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id=" . $_SESSION['user_id']);

            if ($upUser->getResult()) {
                $_SESSION['user_image'] = $this->nameImg;
                $this->deleteImage();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Imagem não editada com sucesso!</p>";
                $this->result = false;
            }
        }

        /**
         * Verifica se existe uma imagem armazenada no diretário, se existir ela é excluída
         * Se a imagem do banco não for vazio ou diferente de nulo e,a imagem armazenada no banco for diferente do imagem que será armazenada 
         * execute o comando de excluir a imagem;
        */
        private function deleteImage(): void {
            if (((!empty($this->resultBD[0]['image'])) or ($this->resultBD[0]['image'] != null)) and ($this->resultBD[0]['image'] != $this->nameImg)) {
                
                $this->delImg = "app/adms/assets/image/users/" . $_SESSION['user_id'] . "/" . $this->resultBD[0]['image'];

                if (file_exists($this->delImg)) {
                    unlink($this->delImg);
                }
            }

            $_SESSION['msg'] = "<p style='color: green;'>Imagem editada com sucesso!</p>";
            $this->result = true;
        }
    }
?>