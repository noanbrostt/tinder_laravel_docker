@extends('main')

@section('title', 'Inscrição Tinder')

@section('conteudo')

<style>
    body {
        background: linear-gradient(191.42deg, var(--bg-orange) 5.12%, var(--bg-blue) 107.11%);
        font-family: "Segoe UI", sans-serif;
        margin: 0;
        padding: 20px;
        height: fit-content;
        height: -moz-fit-content;
        min-height: 100vh;
    }

    .container {
        max-width: 500px;
        margin: auto;
        background: white;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);

        h2 {
            margin-block: -40px;

            span {
                margin-inline: -5px -35px;

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
        }
    }

    h2 {
        text-align: center;
        color: var(--bg-blue);
        font-weight: bolder;
    }

    label {
        display: block;
        margin-block: 20px 6px;
        margin-left: 2px;
        font-weight: 600;
    }

    input[type="file"] {
        display: none;
    }

    .upload-area {
        position: relative;
        width: 100%;
        aspect-ratio: 9/16;
        background-color: #f0f0f0;
        border: 2px dashed #ccc;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .upload-area img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .upload-text {
        color: #888;
        text-align: center;
    }

    select,
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 15px;
        resize: none;
    }

    .char-count {
        text-align: right;
        font-size: 13px;
        color: #666;
        margin-top: -8px;
    }

    button {
        width: 100%;
        background-color: var(--bg-blue-light);
        color: white;
        padding: 12px;
        border: none;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s;
    }

    button:hover {
        background-color: var(--bg-blue);
    }

    #status-aprovacao {
        text-align: center;
        margin-block: 40px;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 12px;
        max-width: 90%;
        max-height: 100%;
        overflow: auto;
    }

    .modal-content h3 {
        margin-top: 0;
        text-align: center;
        color: var(--bg-blue-light);
    }

    .cropper-container {
        max-width: 100%;
    }

    #cropImage {
        max-width: 100%;
        max-height: 70vh;
        width: auto;
        height: auto;
    }

    .modal-buttons {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .modal-buttons button {
        flex: 1;
    }

    .cropper-crop-box {
        height: 100% !important;
    }

    @media (max-width: 500px) {
        h2 {
            font-size: 22px;
        }
    }

    /* Checkbox */

    /* From Uiverse.io by PriyanshuGupta28 */
    .checkbox-wrapper input[type="checkbox"] {
        visibility: hidden;
        display: none;
    }

    .checkbox-wrapper *,
    .checkbox-wrapper ::after,
    .checkbox-wrapper ::before {
        box-sizing: border-box;
        user-select: none;
    }

    .checkbox-wrapper {
        position: relative;
        display: block;
        overflow: hidden;
    }

    .checkbox-wrapper .label {
        cursor: pointer;
        margin-block: -5px 5px;
        font-size: 13px;
    }

    .checkbox-wrapper .check {
        width: 50px;
        height: 50px;
        position: absolute;
        opacity: 0;
    }

    .checkbox-wrapper .label svg {
        vertical-align: middle;
    }

    .checkbox-wrapper .path1 {
        stroke-dasharray: 400;
        stroke-dashoffset: 400;
        transition: .5s stroke-dashoffset;
        opacity: 0;
    }

    .checkbox-wrapper .check:checked+label svg g path {
        stroke-dashoffset: 0;
        opacity: 1;
    }

</style>

@php

@endphp

<div class="container">
    <h2>Inscrição no Tinder</h2>

    <!-- Inscrição já feita -->
    <div class="status-box" {{ !$possuiCadastro ? 'style=display:none;' : '' }}>
        <h3 id="status-aprovacao"></h3>

        <button id="editar">Editar/Visualizar inscrição</button>
    </div>

    <form id="formInscricao" {{ $possuiCadastro ? 'style=display:none;' : '' }}>
        <!-- Upload Foto -->
        <label for="fotoInput">Foto em pé <small>(9:16)</small></label>
        <div class="upload-area" id="uploadArea">
            <span class="upload-text">Clique para enviar foto</span>
            <input type="file" id="fotoInput" accept="image/*" />
        </div>

        <!-- Intenção -->
        <label for="intencao">Intenção</label>
        <select id="intencao">
            <option value="">Selecione</option>
            <option value="1">Amizade</option>
            <option value="2">Namoro</option>
            <option value="3">Outros ( ͡° ͜ʖ ͡°)</option>
        </select>

        <!-- sobre -->
        <label for="sobre">Sobre você <small>(máx. 240)</small></label>
        <textarea id="sobre" rows="4" maxlength="240" placeholder="Digite algo sobre você..."></textarea>
        <div class="char-count"><span id="contador">0</span>/240</div>

        <div class="checkbox-wrapper">
            <input type="checkbox" class="check" id="check1-61">
            <label for="check1-61" class="label">
                <svg width="32" height="32" viewBox="0 0 95 95">
                    <rect x="25" y="20" width="50" height="50" stroke="black" fill="none"></rect>
                    <g transform="translate(0,-952.36222)">
                        <path d="m 56,963 c -102,122 6,9 7,9 17,-5 -66,69 -38,52 122,-77 -7,14 18,4 29,-11 45,-43 23,-4"
                            stroke="black" stroke-width="3" fill="none" class="path1"></path>
                    </g>
                </svg>
                <span>
                    <span>
                        Eu concordo com os
                        <a href="/storage/TERMO-ACEITE-CONDICOES-TINDER-PLANSUL.pdf" target="_blank">
                            Termos, Condições e a Política de Privacidade
                        </a>
                        .
                    </span>
                </span>
            </label>
        </div>
        <button type="submit">Enviar Inscrição</button>
    </form>
</div>

<!-- Modal -->
<div class="modal" id="modalCrop">
    <div class="modal-content">
        <h3>Recorte sua foto</h3>
        <div>
            <img id="cropImage" style="max-width: 100%; display: block" />
        </div>
        <div class="modal-buttons">
            <button id="cancelCrop">Cancelar</button>
            <button id="confirmCrop">Recortar</button>
        </div>
    </div>
</div>

<script>
    // Recupera os dados do sessionStorage
    const possuiCadastro = @json($possuiCadastro);
    const cadastro = @json($cadastro);
    const dados = @json($dados);

    // Exemplo de uso:
    console.log('Possui Cadastro:', possuiCadastro);
    console.log('Cadastro:', cadastro);
    console.log('Dados:', dados);

    const primeiroNome = dados.nome.split(' ')[0].toLowerCase();
    const nomeFormatado = primeiroNome.charAt(0).toUpperCase() + primeiroNome.slice(1);
    $('.container > h2').html(
        `Inscrição no 
        <span> 
            <img src="{{ asset('img/logo-plansul.png')}}" alt="Logo" />
            <img src="{{ asset('img/logo-tinder-white.png') }}" alt="Logo" />
        </span>, ` + nomeFormatado);

    if (possuiCadastro) {

        console.log(cadastro.id_status_usuario);

        switch (cadastro.id_status_usuario) {
            case 1:
                $('#status-aprovacao').addClass('text-warning').html(
                    `Aguardando aprovação 
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 384 512"
                        width="32"
                        height="32"
                        fill="currentColor"
                        style="margin-bottom: -6px;"
                    >
                        <path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64l0 11c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437l0 11c-17.7 0-32 14.3-32 32s14.3 32 32 32l32 0 256 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-11c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1l0-11c17.7 0 32-14.3 32-32s-14.3-32-32-32L320 0 64 0 32 0zM96 75l0-11 192 0 0 11c0 19-5.6 37.4-16 53L112 128c-10.3-15.6-16-34-16-53zm16 309c3.5-5.3 7.6-10.3 12.1-14.9L192 301.3l67.9 67.9c4.6 4.6 8.6 9.6 12.1 14.9L112 384z"/>
                    </svg>
                `);
            break;

            case 2:
                $('#status-aprovacao').addClass('text-success').html(
                    `Aprovada 
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                        width="32"
                        height="32"
                        fill="currentColor"
                        style="margin-bottom: -6px;"
                    >
                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                    </svg>
                `);
                break;

            case 3:
                let obs_recusa;
                if (cadastro.de_observacao_recusa) {
                    obs_recusa = '<br><br> <span style="color:black; font-size:19px; font-weight:300;";>Motivo: ' +
                        cadastro.de_observacao_recusa + '</span>';
                }

                $('#status-aprovacao').addClass('text-danger').html(`
                    Recusada: `
                    + cadastro.no_motivo_recusa +
                    `<svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                        width="32"
                        height="32"
                        fill="currentColor"
                        style="margin-bottom: -6px; margin-left: 10px;"
                    >
                        <path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z"/>
                    </svg>`
                    + obs_recusa
                );
                break;

            default:
                break;
        }

        // Preencher intenção
        $('#intencao').val(cadastro.id_tipo_intencao);

        // Preencher sobre você
        $('#sobre').val(cadastro.de_sobre);
        $('#contador').text(cadastro.de_sobre.length);

        // Preencher foto
        const fotoUrl = `storage/fotos/${cadastro.matricula}.jpg?v=${new Date().getTime()}`;
        preencherFotoDireto(fotoUrl);

    }

    $('#editar').on('click', function () {
        $('.status-box').hide();
        $('#formInscricao').show();
    });

    async function preencherFotoDireto(urlImagem) {
        try {
            const response = await fetch(urlImagem);
            if (!response.ok) throw new Error('Imagem não encontrada');

            const blob = await response.blob();
            const url = URL.createObjectURL(blob);

            uploadArea.innerHTML = `<img src="${url}" alt="Foto"/>`;
            croppedBlob = blob; // já define o blob da foto recortada
            uploadArea.classList.remove("input-error");
        } catch (error) {
            console.log('Foto não encontrada:', error);
        }
    }

</script>

<script>
    const fotoInput = document.getElementById("fotoInput");
    const uploadArea = document.getElementById("uploadArea");
    const sobre = document.getElementById("sobre");
    const contador = document.getElementById("contador");

    const modalCrop = document.getElementById("modalCrop");
    const cropImage = document.getElementById("cropImage");
    const cancelCrop = document.getElementById("cancelCrop");
    const confirmCrop = document.getElementById("confirmCrop");

    let cropper = null;
    let croppedBlob = null;

    uploadArea.addEventListener("click", () => {
        fotoInput.click();
    });

    fotoInput.addEventListener("change", (event) => {
        const file = event.target.files[0];
        if (file) {
            const url = URL.createObjectURL(file);
            cropImage.src = url;
            modalCrop.style.display = "flex";

            if (cropper) {
                cropper.destroy();
            }

            cropImage.onload = () => {
                cropper = new Cropper(cropImage, {
                    aspectRatio: 9 / 16,
                    viewMode: 1, // viewMode 1 garante que a grade nunca saia do contêiner
                    dragMode: "move", // <--- DESCOMENTE E USE ISSO!
                    cropBoxMovable: false, // <--- Adicione ou garanta que isso seja false
                    cropBoxResizable: false, // <--- Adicione ou garanta que isso seja false
                    toggleDragModeOnDblclick: false, // Opcional: para evitar que mude o dragMode
                    background: false,
                    autoCropArea: 1, // Isso garante que a área de corte ocupe todo o espaço disponível inicialmente
                });
            };

            fotoInput.value = "";
        }
    });

    cancelCrop.addEventListener("click", () => {
        modalCrop.style.display = "none";
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        fotoInput.value = "";
    });

    confirmCrop.addEventListener("click", () => {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 720,
                height: 1280,
            });

            compressImage(canvas, 2000, (blob) => {
                // 2000 = tamanho máximo em KB
                croppedBlob = blob;

                const url = URL.createObjectURL(blob);
                uploadArea.innerHTML = `<img src="${url}" alt="Foto Recortada"/>`;

                modalCrop.style.display = "none";
                cropper.destroy();
                cropper = null;

                uploadArea.classList.remove("input-error");
            });
        }
    });

    sobre.addEventListener("input", () => {
        contador.textContent = sobre.value.length;
    });

    document
        .getElementById("formInscricao")
        .addEventListener("submit", (e) => {
            e.preventDefault();

            const intencao = document.getElementById("intencao").value;
            const sobreTexto = sobre.value.trim();

            const campos = [{
                    element: $("#intencao"),
                    type: "required",
                    minLength: 1,
                    message: "Selecione uma intenção.",
                },
                {
                    element: $("#sobre"),
                    type: "required",
                    minLength: 1,
                    message: "Escreva algo sobre você.",
                },
                {
                    element: $("#uploadArea"),
                    type: "custom",
                    isValid: !!croppedBlob,
                    message: "Envie uma foto.",
                },
            ];

            if (!validarCampos(campos)) {
                return;
            }

            if (!$('#check1-61').is(':checked')) {
                Toast.fire({
                    icon: "error",
                    title: "Aceite os termos e condições",
                });
                return;
            }

            const fotoCortada = new File([croppedBlob], "foto.jpg", {
                type: "image/jpeg",
            });

            const formData = new FormData();
            formData.append("foto", fotoCortada);
            formData.append("intencao", intencao);
            formData.append("sobre", sobreTexto);

            $.ajax({
                // url: "/seu-endpoint", // 🔥 Seu endpoint
                url: "{{ route('inscricao.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    Swal.fire({
                        title: "Enviando...",
                        text: "Por favor, aguarde",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });
                },
                success: function (response) {
                    $('button[type="submit"]').prop('disabled', true);
                    Swal.close(); // 🔥 Fecha o loading
                    console.log(response);
                    Toast.fire({
                        icon: "success",
                        title: "Enviado com sucesso!",
                        timer: 0
                    });

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                },
                error: function (xhr, status, error) {
                    Swal.close(); // 🔥 Fecha o loading mesmo se der erro

                    Toast.fire({
                        icon: "error",
                        title: "Ocorreu um erro ao enviar!",
                    });
                },
            });

        });

    function compressImage(canvas, maxSizeKB, callback, quality = 0.9) {
        canvas.toBlob(
            (blob) => {
                const sizeKB = blob.size / 1024;

                if (sizeKB > maxSizeKB && quality > 0.1) {
                    // Reduz qualidade e tenta novamente
                    compressImage(
                        canvas,
                        maxSizeKB,
                        callback,
                        quality - 0.05
                    );
                } else {
                    callback(blob);
                }
            },
            "image/jpeg",
            quality
        );
    }

</script>

@endsection
