@extends('main')

@section('title', 'Validar Inscrições')

@section('conteudo')


<style>
    body {
        background: #f9f9f9;
        margin: 40px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;

        h3 {
            font-size: 32px;
        }

        button {
            background-color: var(--bg-blue-light);
            color: white;
            padding: 10px 12px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;

            &:hover {
                background-color: var(--bg-blue) !important;
                border-color: var(--bg-blue-light) !important;
            }
        }
    }

    /* Estilo para expandir linha */
    #tabela {
        width: calc(100vw - 80px);
    }

    #tabela tbody tr {
        transition: all 0.3s ease;
    }

    #tabela tbody tr:hover {
        height: auto !important;
        background-color: #f9286d26;
    }

    .info-resumida {
        max-height: 50px;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        transition: all 0.3s ease;
    }

    tr:hover .info-resumida {
        white-space: normal;
        max-height: 500px;
    }

    .foto-mini {
        width: 40px;
        height: 71.11px;
        object-fit: cover;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    tr:hover .foto-mini {
        width: 200px;
        height: 355.56px;
    }

    /* Estilo da imagem em tela cheia */
    .fullscreen-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        cursor: zoom-out;
    }

    .fullscreen-overlay img {
        max-width: 90%;
        max-height: 90%;
        box-shadow: 0 0 20px rgba(0,0,0,0.7);
        border-radius: 10px;
    }


    td.acoes {
        text-align: center !important;
        vertical-align: middle;

        i {
            cursor: pointer;
            margin: 0 5px;
            font-size: 28px;
            transition: color 0.2s;

            &:first-child {
                margin-bottom: 14px;
            }

            &:hover {
                color: #007bff;
            }
        }
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

    .swal2-textarea {
        margin: 0;
        width: 100%;
    }

    .swal2-close {
        padding-bottom: 2px;

        &:focus {
            background: unset;
        }
    }

    div:where(.swal2-container) button:where(.swal2-styled):where(.swal2-confirm) {
        background-color: var(--bg-blue-light) !important;

        &:hover {
            background-color: var(--bg-blue) !important;
            border-color: var(--bg-blue-light) !important;
        }

        &:active {
            background-color: var(--bg-orange-dark) !important;
            border-color: var(--bg-orange) !important;
            box-shadow: inset 0 0 0 2px var(--bg-orange) !important;
        }

        &:focus {
            background-color: var(--bg-blue-light) !important;
            border-color: var(--bg-blue) !important;
            box-shadow: none !important;
            outline: none !important;
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

    .modal-select{
        margin-top: 24px;
        width: 100%;
    }

    .modal-select label{
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

    span#logo {
        width: 164.5px;
        gap: 10px;
        display: flex;
        flex-direction: row;
        align-items: center;

        img {
            filter: invert(56%) sepia(81%) saturate(3411%) hue-rotate(325deg) brightness(100%) contrast(96%);
            width: 140px;
        }

        img:first-child {
            width: 40px;
            height: 40px;
            margin-right: -35px;
            margin-top: -10px;
        }

    }

    .redirect {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        justify-content: space-between;

        &:not(:first-child) {
            margin-top: 10px;
        }
    }

    @media screen and (max-width: 640px) {
        div.dt-buttons {
            display: contents;
        }

        /* li.acoes {
            width: calc(100vw - 80px);
        }
        span.spanAcoes {
            width: 100%;
            justify-content: center;
            gap: 10px;
        } */
    }

    #contador {
        font-weight: bolder;
        font-size: 20px;
        display: flex;
        justify-content: space-around;
        margin-block: -20px 20px;
        padding-inline: 10%;
    }
</style>

<div class="header">
    <span id="logo">
        <img src="{{ asset('img/logo-plansul.png')}}" alt="Logo" />
        <img src="{{ asset('img/logo-tinder-white.png') }}" alt="Logo" />
    </span>
    <h1 style="text-align: center;">Validação de Candidatos</h1>
    <span>
        <button class="redirect" onClick="window.location.href = '/inscricao';">
            Tela de Inscrição
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 448 512"
                width="22"
                height="22"
                fill="currentColor"
            >
                <path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/>
            </svg>
        </button>

        <button class="redirect" onClick="window.location.href = '/tinder';">
            Tela do Tinder
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 448 512"
                width="22"
                height="22"
                fill="currentColor"
            >
                <path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/>
            </svg>
        </button>
    </span>
</div>

<div id="contador"></div>

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
            <th>Informações</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>


<!-- CSS -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<!-- <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script> -->

<script>
    $(document).ready(function() {

      fazerChamadaAjaxTotaisUsuarios();

        $.fn.dataTable.ext.order['custom-status'] = function(settings, col) {
            return this.api().column(col, {order: 'index'}).nodes().map(function(td, i) {
                const status = $(td).text().toLowerCase();
                return status === 'recusado' ? 1 : 0; // Recusado = 1 (vem depois), outros = 0 (vem antes)
            });
        };

        const tabela = $('#tabela').DataTable({
            dom: 'Bfrtip',
            // responsive: true,
            order: [[2, 'asc']], // Coluna de status (índice começa em 0)
            columnDefs: [
                { width: "10%", targets: 0 }, // matrícula
                { width: "20%", targets: 1 }, // nome
                { width: "15%", targets: 2 }, // status
                { width: "45%", targets: 3 }, // informações (dá mais espaço aqui)
                { width: "10%", targets: 4 }, // ações
                {
                    targets: 2, // coluna status
                    orderDataType: "dom-text",
                    render: function(data, type, row) {
                        return data.toLowerCase() === 'recusado' ? 'zzz' : data;
                    }
                }
            ],
            autoWidth: false, // Importante para permitir que o width funcione
            buttons: [{
                extend: 'excelHtml5',
                text: `
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 384 512"
                        width="22"
                        height="22"
                        fill="currentColor"
                        style="margin: -5px;"
                    >
                        <path d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM155.7 250.2L192 302.1l36.3-51.9c7.6-10.9 22.6-13.5 33.4-5.9s13.5 22.6 5.9 33.4L221.3 344l46.4 66.2c7.6 10.9 5 25.8-5.9 33.4s-25.8 5-33.4-5.9L192 385.8l-36.3 51.9c-7.6 10.9-22.6 13.5-33.4 5.9s-13.5-22.6-5.9-33.4L162.7 344l-46.4-66.2c-7.6-10.9-5-25.8 5.9-33.4s25.8-5 33.4 5.9z"/>
                    </svg>
                `,
                titleAttr: 'Exportar para Excel',
                exportOptions: {
                    columns: ':not(:last-child)'
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
                                showConfirmButton: false
                            }).then(() => {
                                setTimeout(() => {
                                    window.location.href = '/login'; // 🔁 redireciona para tela de login
                                }, 2000);
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
                            showConfirmButton: false
                        }).then(() => {
                            setTimeout(() => {
                                window.location.href = '/login';
                            }, 2000);
                        });
                    }
                }
            },
            columns: [
                { data: 'matricula' },
                { data: 'nome' },
                {
                    data: 'status_usr',
                    render: function(data, type, row) {
                        return `
                            <div style="text-align:center;">
                                ${data}
                            </div>
                        `;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <div style="display: flex; align-items: center; gap: 10px;">
                              <img src="storage/fotos/${row.matricula}.jpg?v=${new Date().getTime()}" class="foto-mini" alt="Foto de ${row.nome}" onclick="zoomNaFoto(this);">
                            <div>
                                    <div><strong>Intenção:</strong> ${row.intencao}</div>
                                    <div class="info-resumida">
                                        <strong>Sobre:</strong> ${row.sobre}
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: null,
                    className: 'acoes',
                    orderable: false,
                    render: function(data, type, row) {
                        const isRecusado = row.status_usr.toLowerCase() === 'recusado';
                        const disableClass = isRecusado ? 'disabled' : '';
                        const colorAprovar = isRecusado ? 'text-secondary' : 'text-success';
                        const colorRecusar = isRecusado ? 'text-secondary' : 'text-danger';
                        const pointerEvents = isRecusado ? 'pointer-events: none; opacity: 0.5;' : '';

                        return `
                            <span style="display: flex; scale: 1.5; ${pointerEvents}" class="spanAcoes">
                            <!-- Ícone de Aprovar (Check Circle) -->
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="btn-aprovar ${colorAprovar} ${disableClass}" 
                                title="Aprovar" 
                                data-matricula="${row.matricula}" 
                                data-classificacao="aprovado" 
                                data-explicacao="null"
                                width="28" height="28" fill="currentColor" viewBox="0 0 28 28"
                                style="cursor: pointer;">
                                <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1.293-6.293 5-5a1 1 0 0 0-1.414-1.414L11 13.586l-1.293-1.293a1 1 0 1 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0z"/>
                            </svg>

                            <!-- Ícone de Recusar (X Circle) -->
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="btn-recusar ${colorRecusar} ${disableClass}" 
                                title="Recusar" 
                                data-matricula="${row.matricula}" 
                                width="28" height="28" fill="currentColor" viewBox="0 0 28 28"
                                style="cursor: pointer;">
                                <path d="M12 2C6.477 2 2 6.478 2 12s4.477 10 10 10 10-4.478 10-10S17.523 2 12 2zm3.536 13.536a1 1 0 0 1-1.414 1.414L12 13.414l-2.122 2.122a1 1 0 0 1-1.414-1.414L10.586 12 8.464 9.879a1 1 0 1 1 1.414-1.414L12 10.586l2.122-2.121a1 1 0 1 1 1.414 1.414L13.414 12l2.122 2.122z"/>
                            </svg>
                            </span>
                        `;
                    }
                }
            ]
        });

        // ✅ Aprovar
        $(document).on('click', '.btn-aprovar', function() {
            const matricula = $(this).data('matricula');
            const matriculaRecusa = @json($matricula);

            Swal.fire({
                title: 'Confirma Aprovação?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sim, aprovar',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('validar.atualizar') }}",
                        method: "POST",
                        data: {
                            matricula: matricula,
                            classificacao: 'aprovado',
                            explicacao: null,
                            matricula_recusa: matriculaRecusa
                        },
                        success: function(res) {
                            tabela.ajax.reload();
                            Swal.fire('Aprovado!', '', 'success');
                        },
                        error: function(err) {
                            Swal.fire('Erro!', 'Não foi possível aprovar.', 'error');
                        }
                    });
                }
            });
        });

        // ❌ Recusar
        $(document).on('click', '.btn-recusar', function() {
            const matricula = $(this).data('matricula');
            const matriculaRecusa = @json($matricula);
            
            Swal.fire({
                title: 'Recusar Candidato',
                html: `
                    <div id="recusa-modal">
                        <div class="modal-select">
                            <label for="motivo">Motivo <b>*</b>:</label>
                            <select id="motivo">
                                <option value="">Selecione</option>
                                <option value="1">Foto imprópria</option>
                                <option value="2">Texto impróprio</option>
                                <option value="3">Foto e texto impróprios</option>
                            </select>

                            <br>

                            <label for="explicacao" style="margin-top: 30px;">Descrição (opcional):</label>
                            <textarea id="explicacao" class="swal2-textarea" placeholder="Descreva o motivo..."></textarea>
                        </div>
                    </div>
                `,
            showCancelButton: true,
            showCloseButton: true,
            focusConfirm: false,
            cancelButtonText: 'Fechar',
            confirmButtonText: 'Recusar',
            confirmButtonColor: 'var(--bg-blue)',
                preConfirm: () => {
                    const motivo = Swal.getPopup().querySelector('#motivo').value;
                    const explicacao = Swal.getPopup().querySelector('#explicacao').value;
                    if (!motivo) {
                        Swal.showValidationMessage('Selecione um motivo');
                        return false;
                    }
                    return { motivo, explicacao };
                },
            }).then(result => {
                if (result.isConfirmed) {
                    
                    $.ajax({
                        url: "{{ route('validar.atualizar') }}",
                        method: "POST",
                        data: {
                            matricula: matricula,
                            classificacao: motivo.value.trim(),
                            explicacao: explicacao.value.trim() ?? null,
                            matricula_recusa: matriculaRecusa
                        },
                        success: function(res) {
                            tabela.ajax.reload();
                            Swal.fire('Recusado!', '', 'success');
                        },
                        error: function(err) {
                            Swal.fire('Erro!', 'Não foi possível recusar.', 'error');
                        }
                    });
                }
            });
        });
    });

    function zoomNaFoto(img) {
         // Cria a div de fundo escuro
        const overlay = document.createElement('div');
        overlay.classList.add('fullscreen-overlay');

        // Clona a imagem clicada
        const fullImg = document.createElement('img');
        fullImg.src = img.src;
        fullImg.alt = img.alt;

        // Adiciona a imagem na overlay
        overlay.appendChild(fullImg);

        // Quando clicar na overlay, ela some
        overlay.addEventListener('click', () => {
            overlay.remove();
        });

        // Adiciona a overlay no body
        document.body.appendChild(overlay);
    }


    function fazerChamadaAjaxTotaisUsuarios() {
        $.ajax({
            url: "{{ route('validar.contarUsuariosPorStatus') }}", // Usa a URL definida no Blade 
            type: 'GET', // Método HTTP GET
            dataType: 'json', // Espera uma resposta JSON
            success: function(data) {
                $('#contador').append(`<span class="text-success">Aprovados: ${data.aprovados}</span>`);
                $('#contador').append(`<span class="text-warning">Em revisão: ${data.pendentes}</span>`);
                $('#contador').append(`<span class="text-danger">Recusados: ${data.recusados}</span>`);
            },
            error: function(xhr, status, error) {
                // Ocorreu um erro na requisição
                console.error('Erro na requisição AJAX para totais de usuários:', status, error);
                console.error('Resposta de erro:', xhr.responseText);
            }
        });
    }

</script>

@endsection