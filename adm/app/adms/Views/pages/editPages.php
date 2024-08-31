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
    echo "<a href='" . URLADM . "list-pages/index'>Listar</a><br>";
    if (isset($valorForm['id'])) {
        echo "<a href='" . URLADM . "view-pages/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
    }

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
?>
<span id="msg"></span>

<form method="POST" action="" id="form-edit-pages">
    <?php
    $id = "";
    if (isset($valorForm['id'])) {
        $id = $valorForm['id'];
    }
    ?>
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

    <?php
    $name_page = "";
    if (isset($valorForm['name_page'])) {
        $name_page = $valorForm['name_page'];
    }
    ?>
    <label>Nome da Página:<span style="color: #f00;">*</span> </label>
    <input type="text" name="name_page" id="name_page" placeholder="Nome da Página a ser apresentado no menu" value="<?php echo $name_page; ?>" required><br><br>

    <?php
    $controller = "";
    if (isset($valorForm['controller'])) {
        $controller = $valorForm['controller'];
    }
    ?>
    <label>Classe:<span style="color: #f00;">*</span> </label>
    <input type="text" name="controller" id="controller" placeholder="Nome da Classe" value="<?php echo $controller; ?>" required><br><br>

    <?php
    $metodo = "";
    if (isset($valorForm['metodo'])) {
        $metodo = $valorForm['metodo'];
    }
    ?>
    <label>Método:<span style="color: #f00">*</span></label>
    <input type="text" name="metodo" id="metodo" placeholder="Nome do Método" value="<?php echo $metodo; ?>" required><br><br>

    <?php
    $menu_controller = "";
    if (isset($valorForm['menu_controller'])) {
        $menu_controller = $valorForm['menu_controller'];
    }
    ?>
    <label>Classe:<span style="color: #f00;">*</span> </label>
    <input type="text" name="menu_controller" id="menu_controller" placeholder="Nome da Classe no menu" value="<?php echo $menu_controller; ?>" required><br><br>

    <?php
    $menu_metodo = "";
    if (isset($valorForm['menu_metodo'])) {
        $menu_metodo = $valorForm['menu_metodo'];
    }
    ?>
    <label>Método:<span style="color: #f00">*</span></label>
    <input type="text" name="menu_metodo" id="menu_metodo" placeholder="Nome do Método no menu" value="<?php echo $menu_metodo; ?>" required><br><br>

    <?php
    $icon = "";
    if (isset($valorForm['icon'])) {
        $icon = $valorForm['icon'];
    }
    ?>
    <label>Icon:<span style="color: #f00">*</span></label>
    <input type="text" name="icon" id="icon" class="input-adm" placeholder="Ícone a ser apresentado no menu" value="<?php echo $icon; ?>"> <br><br>

    <label>Página Pública:<span style="color: #f00;">*</span> </label>
    <select name="publish" id="publish" required>
        <option value="">Selecione</option>
        <?php
            if (isset($valorForm['publish']) and $valorForm['publish'] == 1) {
                echo "<option value=''>Selecione</option>";
                echo "<option value='1' selected>Sim</option>";
                echo "<option value='2'>Não</option>";
            } elseif (isset($valorForm['publish']) and $valorForm['publish'] == 2) {
                echo "<option value=''>Selecione</option>";
                echo "<option value='1'>Sim</option>";
                echo "<option value='2' selected>Não</option>";
            } else {
                echo "<option value='' selected>Selecione</option>";
                echo "<option value='1'>Sim</option>";
                echo "<option value='2'>Não</option>";
            }
        ?>
    </select><br><br>

    <label>Situação da Página:<span style="color: #f00;">*</span> </label>
    <select name="adms_sits_pgs_id" id="adms_sits_pgs_id">
        <option value="">Selecione</option>
        <?php
        foreach($this->data['select']['sit_pg'] as $sit){
            extract($sit);
            if ((isset($valorForm['adms_sits_pgs_id'])) and ($valorForm['adms_sits_pgs_id'] == $id_sit)){ 
                echo "<option value='$id_sit' selected>$name_sit</option>";
            } else {
                echo "<option value='$id_sit'>$name_sit</option>";
            }
        }
        ?>
    </select><br><br>

    <label>Grupo da Página:<span style="color: #f00;">*</span> </label>
    <select name="adms_groups_pgs_id" id="adms_groups_pgs_id">
        <option value="">Selecione</option>
        <?php
        foreach($this->data['select']['group_pg'] as $group_pg){
            extract($group_pg);
            if ((isset($valorForm['adms_groups_pgs_id'])) and ($valorForm['adms_groups_pgs_id'] == $id_group)){ 
                echo "<option value='$id_group' selected>$name_group</option>";
            } else {
                echo "<option value='$id_group'>$name_group</option>";
            }
        }
        ?>
    </select><br><br>

    <label>Tipo de Página:<span style="color: #f00;">*</span> </label>
    <select name="adms_types_pgs_id" id="adms_types_pgs_id" required>
        <option value="">Selecione</option>
        <?php 
            foreach ($this->data['select']['type_pg'] as $type_pg) {
                extract($type_pg);
                if ((isset($valorForm['adms_types_pgs_id'])) and ($valorForm['adms_types_pgs_id'] == $id_type)) {
                    echo "<option value='$id_type' selected>$name_type</option>";
                } else {
                    echo "<option value='$id_type'>$type - $name_type</option>";
                }
            }
        ?>
    </select>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendEditPages" value="Salvar">Salvar</button>
</form>