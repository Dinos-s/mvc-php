<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>

<h1>Cadastrar Situação</h1>

<?php
echo "<a href='" . URLADM . "list-sits-users/index'>Listar</a><br><br>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-add-sit-user">
    <?php
    $name = "";
    if (isset($valorForm['name'])) {
        $name = $valorForm['name'];
    }
    ?>
    <label>Nome:<span style="color: #f00;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php echo $name; ?>" required><br><br>

    <label>Cor:<span style="color: #f00;">*</span> </label>
    <select name="adms_color_id" id="adms_color_id">
        <option value="">Selecione</option>
        <?php
        foreach($this->data['select']['col'] as $col){
            extract($col);
            if((isset($valorForm['adms_color_id'])) and ($valorForm['adms_color_id'] == $id_col)){
                echo "<option value='$id_col' selected>$name_col</option>";
            }else{
                echo "<option value='$id_col'>$name_col</option>";
            }
        }
        ?>
    </select><br><br>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendAddSitUser" value="Cadastrar">Cadastrar</button>
</form>