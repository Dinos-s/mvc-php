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

<h1>ÁREA DA IMAGEM DO USUÁRIO</h1>

<?php 
    echo "<a href='" . URLADM . "list-users/index'>Listar Usuários</a><br>";
    if (isset($valorForm['id'])) {
        echo "<a href='" . URLADM . "view-users/index/" . $valorForm['id'] ."'>Visualizar Usuário</a><br><br>";
    }

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset( $_SESSION['msg']);
    }
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-user-img" enctype="multipart/form-data">
    <?php
        $id = "";
        if (isset($valorForm['id'])) {
            $id = $valorForm['id'];
        }
    ?>
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
    
    <label>Imagem: 300x300 </label>
    <input type="file" name="new_image" id="new_image" onchange="inputFileValImg()" required><br><br>

    <?php
        if ((!empty($valorForm['image'])) and (file_exists("app/adms/assets/image/users/" . $valorForm['id'] . "/" . $valorForm['image']))) {
            $old_image = URLADM . "app/adms/assets/image/users/" . $valorForm['id'] . "/" . $valorForm['image'];
        } else {
            $old_image = URLADM . "app/adms/assets/image/users/images.png";
        }
    ?>
    <span id="preview-img">
        <img src="<?php echo $old_image; ?>" alt="Imagem" style="width: 100px; height: 100px;">
    </span><br><br>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendEditUserImage" value="Salvar">Salvar</button>
</form>