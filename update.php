<?php
require_once("conexao.php");

// Token simples baseado em ID alfanumérico
function generateToken($spotit_id) {
    return "TOKEN" . $spotit_id;
}

// Verifica se os parâmetros foram fornecidos
if (!isset($_GET["token"]) || !isset($_GET["spotit_id"]) || !isset($_GET["latitude"]) || !isset($_GET["longitude"])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Parâmetros ausentes."]);
    exit();
}

$token = $_GET["token"];
$spotit_id = $_GET["spotit_id"];
$latitude = $_GET["latitude"];
$longitude = $_GET["longitude"];

// Verifica se latitude e longitude são válidos
if (!is_numeric($latitude) || !is_numeric($longitude)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Coordenadas inválidas."]);
    exit();
}

// Validação do token
if ($token !== generateToken($spotit_id)) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Token inválido."]);
    exit();
}

// Atualiza a localização com ID alfanumérico
$update_query = "UPDATE spotit SET current_latitude = ?, current_longitude = ? WHERE id = ?";
$stmt = $mysqli->prepare($update_query);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Erro na preparação da query: " . $mysqli->error]);
    exit();
}

// id agora é string (s), não inteiro (i)
$stmt->bind_param("dds", $latitude, $longitude, $spotit_id);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(["status" => "success", "message" => "Coordenadas do Spotit atualizadas com sucesso."]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Erro ao atualizar coordenadas: " . $stmt->error]);
}

$stmt->close();
$mysqli->close();
?>
