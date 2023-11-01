<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json; charset=UTF-8');

date_default_timezone_set("America/Sao_Paulo");

# Autoload

include_once "model/autoload.class.php";
new Autoload();

# Rotas

$rota = new Rotas();
$rota->add('GET', '/veiculos/listar', 'Veiculos::listarTodos', true);
$rota->add('POST', '/veiculos/adicionar', 'Veiculos::adicionar', true);
$rota->add('DELETE', '/veiculos/deletar/[PARAM]', 'Veiculos::deletar', true);

if (isset($_GET['path'])) {
    $rota->ir($_GET['path']);
} else {
    echo json_encode(['error' => 'Rota não especificada']);
}


