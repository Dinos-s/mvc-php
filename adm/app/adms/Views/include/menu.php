<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}
?>

<a href="<?php echo URLADM; ?>dashboard/index">Dashboard</a>
<a href="<?php echo URLADM; ?>list-users/index">Listar Usuários</a>
<a href="<?php echo URLADM; ?>list-pages/index">Listar Páginas</a>
<a href="<?php echo URLADM; ?>list-types-pages/index">Listar Tipos de Páginas</a>
<a href="<?php echo URLADM; ?>list-groups-pages/index">Listar os grupos de Páginas</a>
<a href="<?php echo URLADM; ?>list-sits-pages/index">Listar as situações de Páginas</a>
<a href="<?php echo URLADM; ?>list-access-levels/index">Listar Níveis de Acesso</a>
<a href="<?php echo URLADM; ?>view-profile/index">Meu Perfil</a>
<a href="<?php echo URLADM; ?>list-conf-emails/index">Listar Emails</a>
<a href="<?php echo URLADM; ?>list-sits-users/index">Listar Situação</a>
<a href="<?php echo URLADM; ?>list-colors/index">Listar Cores</a>
<a href="<?php echo URLADM; ?>logout/index">Sair</a><br>

<!-- Menu dinâmico pegando do  diretamente do banco-->
<!-- <?php 
    if((isset($this->data['menu'])) and ($this->data['menu'])){
        foreach($this->data['menu'] as $itemMenu){
            extract($itemMenu);
            // Coloca a classe de item ativo na sidebar
            // $active_item = "";
            // if ($sidebar_active == $menu_controler) {
            //     $active_item = "active";
            // }

            echo "<a href='". URLADM ."$menu_controller/$menu_metodo' class='sidebar-nav'><i class='icon $icon'></i><span></span>$name_page</a>"; 
        }
    }
?> -->