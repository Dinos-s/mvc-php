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

<h1>Editar Imagem</h1>

<?php
    echo "<a href='" . URLADM . "view-profile/index'>Perfil</a><br><br>";

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
?>
<span id="msg"></span>

<form method="POST" action="" id="form-edit-prof-img" enctype="multipart/form-data">

    <label>Imagem:<span style="color: #f00;">*</span> 300x300 </label>
    <input type="file" name="new_image" id="new_image" onchange="inputFileValImg()" required><br><br>

    <?php
        if ((!empty($valorForm['image'])) and (file_exists("app/adms/assets/image/users/" . $_SESSION['user_id'] . "/" . $valorForm['image']))) {
            $old_image = URLADM . "app/adms/assets/image/users/" . $_SESSION['user_id'] . "/" . $valorForm['image'];
        } else {
            $old_image = URLADM . "app/adms/assets/image/users/images.png";
        }
    ?>
    <span id="preview-img">
        <img src="<?php echo $old_image; ?>" alt="Imagem" style="width: 100px; height: 100px;">
    </span><br><br>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendEditProfImage" value="Salvar">Salvar</button>
</form>