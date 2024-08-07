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

<h1>Editar Páginas</h1>

<?php
    echo "<a href='" . URLADM . "list-groups-pages/index'>Listar</a><br>";
    if (isset($valorForm['id'])) {
        echo "<a href='" . URLADM . "view-groups-pages/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
    }

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
?>
<span id="msg"></span>

<form method="POST" action="" id="form-edit-groups-pages">
    <?php
    $id = "";
    if (isset($valorForm['id'])) {
        $id = $valorForm['id'];
    }
    ?>
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

    <?php
    $name = "";
    if (isset($valorForm['name'])) {
        $name = $valorForm['name'];
    }
    ?>
    <label>Nome da Página:<span style="color: #f00;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome do grupo de página" value="<?php echo $name; ?>" required><br><br>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendEditGroupsPages" value="Salvar">Salvar</button>
</form>