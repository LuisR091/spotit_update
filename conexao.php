<?php
// Configurações de conexão à base de dados
$hostname = "sql108.infinityfree.com"; // Servidor da base de dados
$database = "if0_39135925_spotit";    // Nome da base de dados
$user = "if0_39135925";          // Utilizador da base de dados
$key = "9QKujeHKQU";               // Palavra-passe da base de dados (vazia neste caso)

// Cria uma nova conexão MySQLi
$mysqli = new mysqli($hostname, $user, $key, $database);

// Verifica se houve erro na conexão
if ($mysqli->connect_errno) {
    // Mostra mensagem de erro se a conexão falhar
    echo "falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_errno;
} else {
    // Conexão bem sucedida (string vazia)
    echo "";
}
?>