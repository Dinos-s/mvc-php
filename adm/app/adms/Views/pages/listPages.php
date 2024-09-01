<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Listar Páginas</h2>";

echo "<a href='" . URLADM . "add-pages/index'>Cadastrar</a> ";
echo "<a href='" . URLADM . "sync-pages-levels/index'>Sincronizar</a><br><br>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach ($this->data['listPages'] as $page) {
    // var_dump($page);
    extract($page);
    //echo "ID: " . $page['id'] . "<br>";
    echo "ID: $id <br>";
    echo "Nome da página: $name_page <br>";
    echo "Tipo de página: $type_pg <br>";
    echo "Situção: <span style='color: $color'>$name_sit</span> <br>";
    echo "<a href='" . URLADM . "view-pages/index/$id'>Visualizar</a><br>";
    echo "<a href='" . URLADM . "edit-pages/index/$id'>Editar</a><br>";
    echo "<a href='" . URLADM . "delete-pages/index/$id' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br>";
    echo "<hr>";
}

echo $this->data['pagination'];