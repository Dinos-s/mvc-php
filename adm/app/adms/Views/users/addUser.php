<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>

<h1>Cadastrar Usuário</h1>

<?php
echo "<a href='" . URLADM . "list-users/index'>Listar</a><br><br>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-add-user">
    <?php
    $name = "";
    if (isset($valorForm['name'])) {
        $name = $valorForm['name'];
    }
    ?>
    <label>Nome:<span style="color: #f00;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php echo $name; ?>" required><br><br>

    <?php
    $email = "";
    if (isset($valorForm['email'])) {
        $email = $valorForm['email'];
    }
    ?>
    <label>E-mail:<span style="color: #f00;">*</span> </label>
    <input type="email" name="email" id="email" placeholder="Digite o seu melhor e-mail" value="<?php echo $email; ?>" required><br><br>

    <?php
    $user = "";
    if (isset($valorForm['user'])) {
        $user = $valorForm['user'];
    }
    ?>
    <label>Usuário:<span style="color: #f00;">*</span> </label>
    <input type="text" name="user" id="user" placeholder="Digite o usuário para acessar o administrativo" value="<?php echo $user; ?>" required><br><br>

    <label>Situação:<span style="color: #f00;">*</span> </label>
    <select name="adms_sits_user_id" id="adms_sits_user_id">
        <option value="">Selecione</option>
        <?php
        foreach($this->data['select']['sit'] as $sit){
            extract($sit);
            if((isset($valorForm['adms_sits_user_id'])) and ($valorForm['adms_sits_user_id'] == $id_sit)){
                echo "<option value='$id_sit' selected>$name_sit</option>";
            }else{
                echo "<option value='$id_sit'>$name_sit</option>";
            }
        }
        ?>
    </select><br><br>

    <?php
    $password = "";
    if (isset($valorForm['password'])) {
        $password = $valorForm['password'];
    }
    ?>
    <label>Senha:<span style="color: #f00;">*</span> </label>
    <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php echo $password; ?>" required>
    <span id="msgViewStrength"><br><br></span>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendAddUser" value="Cadastrar">Cadastrar</button>
</form>