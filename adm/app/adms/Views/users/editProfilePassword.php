<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}
?>

<h1>Editar Senha</h1>

<?php

echo "<a href='" . URLADM . "view-profile/index'>Perfil</a><br><br>";


if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-edit-prof-pass">

    <?php
    $password = "";
    if (isset($valorForm['password'])) {
        $password = $valorForm['password'];
    }
    ?>
    <label>Senha:<span style="color: #f00;">*</span> </label>
    <input type="password" name="password" id="password" placeholder="Digite a nova senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php echo $password; ?>" >
    <span id="msgViewStrength"><br><br></span>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendEditProfPass" value="Salvar">Salvar</button>
</form>