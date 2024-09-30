<?php
    if(!defined('C8L6K7E')){
        // header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

    echo "<h2>Listar Tipos de Páginas
    </h2>";

    if ($this->data['button']['add_types_pages']) {
        echo "<a href='" . URLADM . "add-types-pages/index'>Cadastrar Tipos de Páginas</a><br><br>";
    }
    
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

    foreach ($this->data['listTypesPages'] as $typePg) {
        //var_dump($user);
        extract($typePg);
        echo "ID: $id <br>";
        echo "Nome: <span style='color: $color'>$name</span> <br>";

        if ($this->data['button']['order_types_pages']) {
            echo "<a href='" . URLADM . "order-types-pages/index/$id?pag=". $this->data['pag'] ."'>Ordem</a><br>";
        }
        
        if ($this->data['button']['view_types_pages']) {
            echo "<a href='" . URLADM . "view-types-pages/index/$id'>Visualizar</a><br>";
        }
        
        if ($this->data['button']['edit_types_pages']) {
            echo "<a href='" . URLADM . "edit-types-pages/index/$id'>Editar</a><br>";
        }
        
        if ($this->data['button']['delete_types_pages']) {
            echo "<a href='" . URLADM . "delete-types-pages/index/$id' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br>";
        }
        
        echo "<hr>";
    }

    echo $this->data['pagination'];
?>