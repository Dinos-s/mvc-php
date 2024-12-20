<?php
    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    echo "<h2>Listar Situação das Páginas
    </h2>";

    if ($this->data['button']['add_sits_pages']) {
        echo "<a href='" . URLADM . "add-sits-pages/index'>Cadastrar Situação</a><br><br>";
    }

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

    foreach ($this->data['listSitsPages'] as $sitPg) {
        //var_dump($user);
        extract($sitPg);
        echo "ID: $id <br>";
        echo "Nome: <span style='color: $color'>$name</span> <br>";

        if ($this->data['button']['view_sits_pages']) {
            echo "<a href='" . URLADM . "view-sits-pages/index/$id'>Visualizar</a><br>";
        }
        
        if ($this->data['button']['edit_sits_pages']) {
            echo "<a href='" . URLADM . "edit-sits-pages/index/$id'>Editar</a><br>";
        }
        
        if ($this->data['button']['delete_sits_pages']) {
            echo "<a href='" . URLADM . "delete-sits-pages/index/$id' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br>";
        }
        
        echo "<hr>";
    }

    echo $this->data['pagination'];
?>