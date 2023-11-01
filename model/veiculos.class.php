<?php

class Veiculos
{
    public function listarTodos()
    {
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM Veiculos ORDER BY id");
        $rs->execute();
        $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

        if ($obj) {
            echo json_encode(["dados" => $obj]);
        } else {
            echo json_encode(["dados" => 'Não existem dados para retornar']);
        }
    }
    
    public function adicionar()
    {
        $sql = "INSERT INTO Veiculos (";
        $contador = 1;
        foreach (array_keys($_POST) as $indice) {
            if (count($_POST) > $contador) {
                $sql .= "{$indice},";
            } else {
                $sql .= "{$indice}";
            }
            $contador++;
        }
        $sql .= ") VALUES (";
        $contador = 1;
        foreach (array_values($_POST) as $valor) {
            if (count($_POST) > $contador) {
                $sql .= "'{$valor}',";
            } else {
                $sql .= "'{$valor}'";
            }
            $contador++;
        }
        $sql .= ")";

        $db = DB::connect();
        $rs = $db->prepare($sql);
        $exec = $rs->execute();

        if ($exec) {
            echo json_encode(["dados" => 'Dados foram inseridos com sucesso.']);
        } else {
            echo json_encode(["dados" => 'Houve algum erro ao inserir os dados.']);
        }
    }

    public function deletar($param)
    {
        $db = DB::connect();
        $rs = $db->prepare("DELETE FROM Veiculos WHERE id={$param}");
        $exec = $rs->execute();

        if ($exec) {
            echo json_encode(["dados" => 'Dados foram excluidos com sucesso.']);
        } else {
            echo json_encode(["dados" => 'Houve algum erro ao excluir os dados.']);
        }
    }
}
