@extends('main')

@section('title', 'Validar Inscrições')

@section('conteudo')


<style>
    body {
        background: #f9f9f9;
        margin: 40px;
    }

    h1 {
        font-size: 32px;
        margin-bottom: 32px;
    }

    /* Layout dos filtros */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: inline-flex;
        align-items: center;
    }

    .dataTables_wrapper .dataTables_length {
        margin-right: 30px;
    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
    }

    .paging_simple_numbers {
        display: flex;
        gap: 10px;
    }

    /* Modal */
    .swal2-popup {
        width: 800px !important;
        max-width: 95vw;
        border-radius: 16px !important;
        padding: 30px 20px !important;
    }

    .swal2-title {
        color: var(--bg-blue);
        padding: 8px;
    }

    .swal2-close {
        padding-bottom: 2px;

        &:focus {
            background: unset;
        }
    }

    .modal-content {
        display: flex;
        gap: 24px;
        flex-direction: row;
        border: none;
    }

    .modal-info {
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: 15px;
        padding-top: 15px;
    }

    .foto-candidato {
        width: 270px;
        height: 480px;
        object-fit: cover;
        border-radius: 12px;
        border: 3px solid var(--bg-blue-light);
    }

    .modal-info h3 {
        margin: 0;
        font-size: 20px;
        color: var(--bg-blue);
    }

    .modal-info p {
        margin: 8px 0 0 0;
        font-size: 19px;
        color: black;
    }

    .modal-sobre {
        margin-top: 16px;
        background: #f6f6f6;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 15px;
    }

    .modal-select {
        margin-top: 24px;
        width: 100%;
    }

    .modal-select label {
        display: block;
        margin-bottom: 6px;
        color: var(--bg-blue);
        font-weight: bold;
    }

    .modal-select select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    /* Tabela */
    table.dataTable {
        border-collapse: collapse;
        width: 100%;
        background: white;
    }

    table.dataTable thead {
        background-color: var(--bg-blue);
        color: white;
    }

    table.dataTable thead th {
        position: relative;
        cursor: pointer;
        padding-right: 24px;
    }

    table.dataTable thead th:hover {
        background-color: var(--bg-blue-light);
    }

    /* Setinhas */
    table.dataTable th.sorting:after,
    table.dataTable th.sorting_asc:after,
    table.dataTable th.sorting_desc:after {
        content: '';
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        border: 6px solid transparent;
    }

    table.dataTable th.sorting:after {
        border-top-color: white;
        top: 55%;
    }

    table.dataTable th.sorting_asc:after {
        border-bottom-color: white;
        top: 45%;
    }

    table.dataTable th.sorting_desc:after {
        border-top-color: white;
        top: 55%;
    }

    table.dataTable th,
    table.dataTable td {
        padding: 14px 20px;
        text-align: left;
    }

    table.dataTable tr:nth-child(even) {
        background-color: #f6f6f6;
    }

    table.dataTable tbody tr:hover {
        background-color: #ece7ff;
    }

    /* Botão visualizar */
    .btn-visualizar {
        background-color: var(--bg-blue);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn-visualizar:hover {
        background-color: var(--bg-blue-light);
    }

    /* Loader container */
    .loader-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        /* Fundo semitransparente */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    /* Spinner */
    .spinner {
        width: 50px;
        height: 50px;
        border: 6px solid #ddd;
        border-top-color: var(--bg-blue);
        /* Cor principal (ajuste como quiser) */
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    /* Animação de rotação */
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Texto */
    .loader-container p {
        margin-top: 10px;
        font-size: 16px;
        color: #333;
        font-weight: 500;
    }

    #tabela_filter label {
        margin-bottom: -42px;
    }
</style>

<h1>Validação de Candidatos</h1>

<div id="loader" class="loader-container">
    <div class="spinner"></div>
    <p>Carregando dados...</p>
</div>

<table id="tabela">
    <thead>
        <tr>
            <th>Matrícula</th>
            <th>Nome</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <!-- Os dados serão preenchidos via DataTables -->
    </tbody>
</table>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script>

    const usuario = @json(session('dados'));

    if (usuario) {
       console.log("Nome:", usuario?.nome);
       console.log("Matrícula:", usuario?.matricula);
       console.log("✅ Dados carregados da sessão:", usuario);
    } else {
        console.warn("⚠️ Nenhum dado encontrado na sessão.");
    }

    $(document).ready(function() {
        var tabela = $('#tabela').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa-solid fa-file-excel""></i>', // Ícone do FontAwesome
                titleAttr: 'Exportar para Excel',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclui a última coluna
                }
            }],
            language: {
                lengthMenu: "Exibir _MENU_ por página",
                zeroRecords: "Nenhum registro encontrado",
                info: "Exibindo _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Nenhum registro disponível",
                infoFiltered: "(filtrado de _MAX_ registros totais)",
                search: "Pesquisar:",
                paginate: {
                    first: "Primeiro",
                    last: "Último",
                    next: "Próximo",
                    previous: "Anterior"
                }
            },
            ajax: {
                url: "{{ route('validar.listar') }}",
                dataSrc: '',
                complete: function(xhr) {
                    $('#loader').hide();
            
                    if (xhr && xhr.responseJSON) {
                        const resposta = xhr.responseJSON;
            
                        if (resposta.status === 'erro') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: resposta.mensagem,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/login'; // 🔁 redireciona para tela de login
                            });
                        }
                    }
                },
                error: function(xhr) {
                    $('#loader').hide();
            
                    if (xhr.status === 401 || xhr.status === 403) {
                        const mensagem = xhr.responseJSON?.mensagem || 'Acesso negado.';
                        Swal.fire({
                            icon: 'warning',
                            title: 'Acesso Restrito',
                            text: mensagem,
                            confirmButtonText: 'Ir para Login'
                        }).then(() => {
                            window.location.href = '/login';
                        });
                    }
                }
            },
            columns: [{
                    data: 'matricula'
                },
                {
                    data: 'nome'
                },
                {
                    data: 'intencao'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <button class="btn-visualizar"
                                data-matricula="${encodeURIComponent(row.matricula)}"
                                data-nome="${encodeURIComponent(row.nome)}"
                                data-intencao="${encodeURIComponent(row.intencao)}"
                                data-sobre="${encodeURIComponent(row.sobre)}">
                                Visualizar
                            </button>
                        `;
                    }


                }
            ]
        });
    });


    $(document).on('click', '.btn-visualizar', function() {
        matricula = decodeURIComponent($(this).data('matricula'));
        nome = decodeURIComponent($(this).data('nome'));
        intencao = decodeURIComponent($(this).data('intencao'));
        sobre = decodeURIComponent($(this).data('sobre'));
        
        Swal.fire({
            title: nome,
            html: `
            <div class="modal-content">
                <img src="storage/fotos/${matricula}.jpg" class="foto-candidato" alt="Foto de ${nome}">
                <div class="modal-info">
                    <h3>Intenção: <span>${intencao}</span></h3>
                    <div class="modal-sobre">
                        <strong>Sobre:</strong>
                        <p>${sobre}</p>
                    </div>
                </div>
            </div>
            <div class="modal-select">
                <label for="motivo">Classificação:</label>
                <select id="motivo">
                    <option value="">Selecione</option>
                    <option value="aprovado">Aprovado(a)</option>
                    <option value="1">Foto imprópria</option>
                    <option value="2">Texto impróprio</option>
                    <option value="3">Foto e texto impróprios</option>
                </select>
            </div>
            `,
            showCancelButton: true,
            showCloseButton: true,
            focusConfirm: false,
            cancelButtonText: 'Fechar',
            confirmButtonText: 'Enviar Avaliação',
            confirmButtonColor: 'var(--bg-blue)',
            preConfirm: () => {
                const motivo = Swal.getPopup().querySelector('#motivo').value;
                if (!motivo) {
                    Swal.showValidationMessage('Selecione um motivo ou feche');
                    return false;
                }
                return motivo;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const motivoSelecionado = result.value;
                Swal.fire({
                    icon: 'success',
                    title: 'Avaliação enviada!',
                    text: `Motivo selecionado: ${motivoSelecionado}`,
                    timer: 2500,
                    showConfirmButton: false
                });

               $.ajax({
                   url: "{{ route('validar.atualizar') }}",
                   method: "POST",
                   data: {
                       matricula: matricula,
                       classificacao: motivoSelecionado, 
                       matricula_recusa: usuario?.matricula
                   },
                   success: function(res) {
                       console.log("✅ RESPOSTA:", res);
                   },
                   error: function(err) {
                       console.error("❌ ERRO:", err.responseJSON);
                   }
               });
            }
        });
    });
</script>

@endsection