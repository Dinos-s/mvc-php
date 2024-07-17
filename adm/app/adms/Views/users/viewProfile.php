<?php
    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    echo "<h2>Perfil: ". $this->data['viewProfile'][0]['name'] ."</h2>";

    if (!empty($this->data['viewProfile'])) {
        echo "<a href='" . URLADM . "edit-profile/index'>Editar</a><br>";
        echo "<a href='" . URLADM . "edit-profile-password/index'>Editar Senha</a><br>";
        echo "<a href='" . URLADM . "edit-profile-image/index'>Editar Imagem</a><br><br>";
    }

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

    if (!empty($this->data['viewProfile'])) {
        extract($this->data['viewProfile'][0]);
        $id_user = $_SESSION['user_id'];

        if ((!empty($image)) and (file_exists("app/adms/assets/image/users/$id_user/$image"))) {
            echo "<img src='" . URLADM . "app/adms/assets/image/users/$id_user/$image' width='100' height='100'> <br>";
        }else{
            echo "<img src='" . URLADM . "app/adms/assets/image/users/images.png' width='100' height='100'> <br>";
        }
        echo "Nome: $name <br>";
        echo "Apelido: $nickname <br>";
        echo "E-mail: $email <br>";
    }
?>