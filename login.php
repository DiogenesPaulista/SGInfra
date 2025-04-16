<?php
include 'conexao.php';

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

// Configurações do Active Directory
$ldap_host = "ldap://"; // ou IP do AD
$ldap_dn = "";
$ldap_user = $usuario . "@educacao.elv.intranet"; // login@dominio

$ldap_con = ldap_connect($ldap_host);
ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);

if (@ldap_bind($ldap_con, $ldap_user, $senha)) {
    // Autenticado com sucesso

    // Opcional: buscar nome completo do usuário no AD
    $filter = "(sAMAccountName=$usuario)";
    $result = ldap_search($ldap_con, $ldap_dn, $filter);
    $entries = ldap_get_entries($ldap_con, $result);
    $nome_completo = $entries[0]["cn"][0] ?? $usuario;

    // Grava ou atualiza no MySQL
    $stmt = $conn->prepare("INSERT INTO usuarios (login, nome) VALUES (?, ?) ON DUPLICATE KEY UPDATE nome = VALUES(nome)");
    $stmt->bind_param("ss", $usuario, $nome_completo);
    $stmt->execute();

    echo "Login bem-sucedido. Bem-vindo, $nome_completo!";
} else {
    echo "Usuário ou senha inválidos.";
}
?>
