function listarTodos() {
    fetch('/veiculos/listar')
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Erro na resposta da API');
            }
        })
        .then(data => {
            if (Array.isArray(data.dados)) {
                const recordList = document.getElementById('recordList');
                recordList.innerHTML = '';

                data.dados.forEach(record => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${record.id}</td>
                        <td>${record.marca}</td>
                        <td>${record.modelo}</td>
                        <td>${record.ano}</td>
                        <td>${record.cor}</td>
                        <td>${record.placa}</td>
                        <td>${record.preco}</td>
                        <td>${record.data_fabricacao}</td>
                        <td>${record.data_compra}</td>
                        <td>${record.descricao}</td>
                        <td>
                            <button class="delete" onclick="deletarVeiculo(${record.id})">Excluir</button>
                        </td>
                    `;
                    recordList.appendChild(row);
                });
            } else {
                throw new Error('Formato de resposta inválido');
            }
        })
        .catch(error => {
            console.error(error);
        });
}

function adicionarVeiculo() {
    const formData = new FormData(document.getElementById("veiculoForm"));

    const url = '/veiculos/adicionar';
    const options = {
        method: 'POST',
        body: formData,
    };

    fetch(url, options)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            listarTodos();
        })
        .catch(error => {
            console.error(error);
        });
}

function deletarVeiculo(id) {
    fetch(`/veiculos/deletar/${id}`, {
        method: 'DELETE',
    })
        .then(response => response.json())
        .then(data => {
            document.getElementById('result').textContent = data.message;
            listarTodos();
        }
        );
}

listarTodos();

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('veiculoForm').addEventListener('submit', function (e) {
        e.preventDefault();
        adicionarVeiculo();
    });
});