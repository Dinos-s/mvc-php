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

<h1>Editar Tipo de Página</h1>

<?php
    echo "<a href='" . URLADM . "list-types-pages/index'>Listar</a><br>";
    if (isset($valorForm['id'])) {
        echo "<a href='" . URLADM . "view-types-pages/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
    }

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
?>
<span id="msg"></span>

<form method="POST" action="" id="form-edit-types-pages">
    <?php
    $id = "";
    if (isset($valorForm['id'])) {
        $id = $valorForm['id'];
    }
    ?>
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

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

    <button type="submit" name="SendEditTypesPages" value="Salvar">Salvar</button>
</form>