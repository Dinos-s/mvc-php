<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Listar Niveis de Acesso</h2>";

if($this->data['button']['add_access_levels']){
    echo "<a href='" . URLADM . "add-access-levels/index'>Cadastrar</a> ";
}

if ($this->data['button']['sync_pages_levels']) {
    echo "<a href='" . URLADM . "sync-pages-levels/index'>Sincronizar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach ($this->data['listAccessLevels'] as $user) {
    // var_dump($user);
    extract($user);
    //echo "ID: " . $user['id'] . "<br>";
    echo "ID: $id <br>";
    echo "Nome: $name <br>";
    echo "Ordem de acesso: $orderLev <br>";

    if($this->data['button']['order_access_levels']){
        echo "<a href='" . URLADM . "order-access-levels/index/$id?pag=". $this->data['pag'] ."'>Ordem</a><br>";
    }
    
    if ($this->data['button']['list_permission']) {
        echo "<a href='" . URLADM . "list-permission/index?level=$id'>Permissão</a><br>";
    }
    
    if ($this->data['button']['view_access_levels']) {
        echo "<a href='" . URLADM . "view-access-levels/index/$id'>Visualizar</a><br>";
    }

    if ($this->data['button']['edit_access_levels']) {
        echo "<a href='" . URLADM . "edit-access-levels/index/$id'>Editar</a><br>";
    }
    
    if ($this->data['button']['delete_access_levels']) {
        echo "<a href='" . URLADM . "delete-access-levels/index/$id' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br>";
    }
    echo "<hr>";
}

echo $this->data['pagination'];