<?php

if(!defined('C8L6K7E')){
    // header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Detalhes da Configuração de E-mail</h2>";

if ($this->data['button']['list_conf_emails']) {
    echo "<a href='" . URLADM . "list-conf-emails/index'>Listar</a><br>";
}

if (!empty($this->data['viewConfEmails'])) {
    if ($this->data['button']['edit_conf_emails']) {
        echo "<a href='" . URLADM . "edit-conf-emails/index/" . $this->data['viewConfEmails'][0]['id'] . "'>Editar</a><br>";
    }
    
    if ($this->data['button']['edit_conf_emails_password']){
        echo "<a href='" . URLADM . "edit-conf-emails-password/index/" . $this->data['viewConfEmails'][0]['id'] . "'>Editar Senha</a><br>";
    }
    
    if ($this->data['button']['delete_conf_emails']) {
        echo "<a href='" . URLADM . "delete-conf-emails/index/" . $this->data['viewConfEmails'][0]['id'] . "' onclick='return confirm(\"Tem certeza que desaja apagar este registro?\")'>Apagar</a><br><br>";
    }
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewConfEmails'])) {
    // var_dump($this->data['viewConfEmails'][0]);
    extract($this->data['viewConfEmails'][0]);
    // var_dump($this->data['viewConfEmails']);

    echo "ID: $id <br>";
    echo "Título: $title <br>";
    echo "Nome: $name <br>";
    echo "E-mail: $email <br>";
    echo "Endereço Host: $host <br>";
    echo "Usuário do servidor: $username <br>";
    echo "Servidor SMTP: $smtpsecure <br>";
    echo "Prota: $port <br>";
    echo "Cadastrado: " . date('d/m/Y H:i:s', strtotime($created)) . " <br>";
    echo "Editado: ";

    if (!empty($modificado)) {
        echo date('d/m/Y H:i:s', strtotime($modificado));
    }
    echo "<br>";
}
