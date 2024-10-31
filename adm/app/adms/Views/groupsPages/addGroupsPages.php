<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>

<h1>Cadastrar Páginas</h1>

<?php
echo "<a href='" . URLADM . "list-groups-pages/index'>Listar</a><br><br>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-add-groups-pages">
    <?php
    $name = "";
    if (isset($valorForm['name'])) {
        $name = $valorForm['name'];
    }
    ?>
    <label>Nome do Grupo<span style="color: #f00;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Nome do grupo" value="<?php echo $name; ?>" required><br><br>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendAddGroupsPages" value="Cadastrar">Cadastrar</button>
</form>