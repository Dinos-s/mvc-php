<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>

<div class="container-login">
    <div class="wrapper-login">
        <div class="title">
            <span>Nova Senha</span>
        </div>
        
        <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <span id="msg"></span>

        <form method="POST" action="" id="form-update-pass" class="form-login">    

            <?php
            $password = "";
            if (isset($valorForm['password'])) {
                $password = $valorForm['password'];
            }
            ?>
            <!-- <label>Senha: </label> -->
            <div class="row">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Digite a nova senha"  onkeyup="passwordStrength()" autocomplete="on" value="<?php echo $password; ?>" required>
            </div>

            <span id="msgViewStrength"><br><br></span>

            <div class="row button">
                <button type="submit" name="SendUpPass" value="Salvar">Salvar</button>
            </div>

            <div class="signup-link">
                <a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar
            </div>
        </form>
    </div>
</div>