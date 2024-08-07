<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Detalhes da Página</h2>";

echo "<a href='" . URLADM . "list-pages/index'>Listar</a><br>";
if (!empty($this->data['viewPage'])) {
    echo "<a href='" . URLADM . "edit-pages/index/" . $this->data['viewPage'][0]['id'] . "'>Editar</a><br>";
    echo "<a href='" . URLADM . "edit-pages-password/index/" . $this->data['viewPage'][0]['id'] . "'>Editar Senha</a><br>";
    echo "<a href='" . URLADM . "edit-pages-image/index/" . $this->data['viewPage'][0]['id'] . "'>Editar Imagem</a><br>";
    echo "<a href='" . URLADM . "delete-pages/index/" . $this->data['viewPage'][0]['id'] . "' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewPages'])) {
    //var_dump($this->data['viewPages'][0]);
    extract($this->data['viewPages'][0]);
    // var_dump($this->data['viewPages']);

    echo "ID: $id <br>";
    echo "Contoller: $contoller <br>";
    echo "Metodo: $metodo <br>";
    echo "Menu Controller: $menu_controller <br>";
    echo "Menu Metodo: $menu_metodo <br>";
    echo "Nome da página: $name_page <br>";
    echo "Apelido:" ;
    if ($publish == 2) {
        echo "Sim";
    } else {
        echo "Não";
    } 
    echo "<br>";
    echo "Ícone: $icon <br>";
    echo "Observação: $obs <br>";
    echo "Situação da Página: <span style='color: $color;'>$name_sit</span><br>";
    echo "Tipo de página: $type_tpg <br>";
    echo "Grupo de Página: $name_grpg <br>";
    echo "Cadastrado: " . date('d/m/Y H:i:s', strtotime($created)) . " <br>";
    echo "Editado: ";

    if (!empty($modificado)) {
        echo date('d/m/Y H:i:s', strtotime($modificado));
    }
    echo "<br>";
}
