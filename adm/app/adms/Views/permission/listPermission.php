<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Listar Permissão do Nível de Acesso: </h2>";

echo "<a href='" . URLADM . "list-access-levels/index' class='btn-info'>Listar Nível de Acesso</a><br><br>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach ($this->data['listPermission'] as $permission) {
    // var_dump($permission);
    extract($permission);
    //echo "ID: " . $permission['id'] . "<br>";
    echo "ID: $id <br>";
    echo "Página: $name_page <br>";
    echo "Ordem: $order_level_page <br>";
    if ($permission == 1) {
        echo "Permissão: <a href='". URLADM ."edit-permission/index/$id?&level=$adms_access_level_id&pag=". $this->data['pag'] ."'><span style='color: green'>Liberado</span></a>";
    } else {
        echo "Permissão: <a href='". URLADM ."edit-permission/index/$id?&level=$adms_access_level_id&pag=". $this->data['pag'] ."'><span style='color: #f00'>Negado</span></a>";
    }
    // echo "Permissão: $permission <br>";
    echo "<hr>";
}

echo $this->data['pagination'];