<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>

<h1>Cadastrar Tipos de Páginas</h1>

<?php
echo "<a href='" . URLADM . "list-types-pages/index'>Listar</a><br><br>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-add-types-pages">
    <?php 
        $type = "";
        if(isset($valorForm['type'])){
            $type = $valorForm['type'];
        }
    ?>
    <label>Tipo: <span style="color: #f00;">*</span></label>
    <input type="text" name="type" id="type" placeholder="Digite o tipo da página" value="<?php echo $type?>" required> <br><br>

    <?php
    $name = "";
    if (isset($valorForm['name'])) {
        $name = $valorForm['name'];
    }
    ?>
    <label>Nome:<span style="color: #f00;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome do tipo de página" value="<?php echo $name; ?>" required><br><br>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendAddTypesPages" value="Cadastrar">Cadastrar</button>
</form>