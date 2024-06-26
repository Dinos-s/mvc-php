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

<h1>Editar Usuário</h1>

<?php
    echo "<a href='" . URLADM . "list-conf-emails/index'>Listar</a><br>";
    if (isset($valorForm['id'])) {
        echo "<a href='" . URLADM . "view-conf-emails/index/" . $valorForm['id'] . "'>Visualizar</a><br>";
        echo "<a href='" . URLADM . "edit-conf-emails-password/index/" . $valorForm['id'] . "'>Editar Senha</a><br>";
        echo "<a href='" . URLADM . "delete-conf-emails/index/" . $valorForm['id'] . "' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br><br>";
    }

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
?>
<span id="msg"></span>

<form method="POST" action="" id="form-edit-conf-emails">
    <?php
    $id = "";
    if (isset($valorForm['id'])) {
        $id = $valorForm['id'];
    }
    ?>
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
    
    <?php
        $title = "";
        if (isset($valorForm['title'])) {
            $title = $valorForm['title'];
        }
    ?>
    <label>Título:<span style="color: #f00;">*</span> </label>
    <input type="text" name="title" id="title" placeholder="Título para indentificar o e-mail" value="<?php echo $title; ?>" required><br><br>

    <?php
    $name = "";
    if (isset($valorForm['name'])) {
        $name = $valorForm['name'];
    }
    ?>
    <label>Nome:<span style="color: #f00;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Nome que será apresentado no remetente" value="<?php echo $name; ?>" required><br><br>
    
    <?php
        $email = "";
        if (isset($valorForm['email'])) {
            $email = $valorForm['email'];
        }
    ?>
    <label>E-mail:<span style="color: #f00;">*</span> </label>
    <input type="email" name="email" id="email" placeholder="E-mail que será apresentado no remetente" value="<?php echo $email; ?>" required><br><br>

    <?php 
        $host = "";
        if (isset($valorForm['host'])) {
            $host = $valorForm['host'];
        }
    ?>
    <label>Endereço Host <span style="color: #f00;">*</span></label>
    <input type="text" name="host" id="host" placeholder="Servidor utilizado para enviar o e-mail" value="<?php echo $host?>" required> <br><br>

    <?php
    $username = "";
    if (isset($valorForm['username'])) {
        $username = $valorForm['username'];
    }
    ?>
    <label>Username: <span style="color: #f00;">*</span></label>
    <input type="text" name="username" id="username" placeholder="Usuário do e-mail, na maioria das vezes é o próprio e-mail" value="<?php echo $username; ?>" ><br><br>

    <?php 
        $smtpsecure = "";
        if (isset($valorForm['smtpsecure'])) {
            $smtpsecure = $valorForm['smtpsecure'];
        }
    ?>
    <label>Servidor SMTP: <span style="color: #f00;">*</span></label>
    <input type="text" name="smtpsecure" id="smtpsecure" placeholder="Servidor SMTP" value="<?php echo $smtpsecure?>" required> <br><br>

    <?php 
        $port = "";
        if(isset($valorForm['port'])){
            $port = $valorForm['port'];
        }
    ?>
    <label>Prota:<span style="color: #f00;">*</span> </label>
    <input type="text" name="port" id="port" placeholder="Porta do servidor" value="<?php echo $port; ?>" required> <br><br>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendEditConfEmail" value="Salvar">Salvar</button>
</form>