<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Listar Grupos de Páginas</h2>";

if ($this->data['button']['add_groups_pages']) {
    echo "<a href='" . URLADM . "add-groups-pages/index'>Cadastrar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach ($this->data['listGroupsPages'] as $groupsPages) {
    // var_dump($groupsPages);
    extract($groupsPages);
    //echo "ID: " . $groupsPages['id'] . "<br>";
    echo "ID: $id <br>";
    echo "Nome da página: $name <br>";
    echo "Tipo de página: $order_group_pg <br>";

    if ($this->data['button']['order_groups_pages']) {
        echo "<a href='" . URLADM . "order-groups-pages/index/$id?pag=". $this->data['pag'] ."'>Ordem</a><br>";
    }
   
    if ($this->data['button']['view_groups_pages']) {
        echo "<a href='" . URLADM . "view-groups-pages/index/$id'>Visualizar</a><br>";
    }
    
    if ($this->data['button']['edit_groups_pages']) {
        echo "<a href='" . URLADM . "edit-groups-pages/index/$id'>Editar</a><br>";
    }
    
    if ($this->data['button']['delete_groups_pages']) {
        echo "<a href='" . URLADM . "delete-groups-pages/index/$id' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br>";
    }
    
    echo "<hr>";
}

echo $this->data['pagination'];