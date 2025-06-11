@extends('main')

@section('title', 'Matchs Tinder')

@section('conteudo') 

<style>
    body {
        background: linear-gradient(to bottom, var(--bg-orange), var(--bg-blue));
        color: var(--contrast-primary);
        padding: 2rem 1rem;
        height: 100%;
        min-height: 100vh;
    }

    .container {
        max-width: 700px;
        margin: 0 auto;
        background: var(--contrast-secondary);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .seta-esquerda {
        cursor: pointer;
        transition: .3s;

        &:hover {
            transform: scale(1.2);
        }
    }

    h1 {
        color: var(--bg-blue);
        margin-bottom: 2rem;
        display: flex;
        justify-content: center;
        align-items: center;
        justify-content: space-between;
    }

    .section:not(:last-child) {
        margin-bottom: 2.5rem;
    }

    .section h2 {
        font-size: 1.3rem;
        color: var(--bg-blue-light);
        margin-bottom: 1rem;
        cursor: pointer;
        padding: 6px 32px;
        margin-inline: -32px;
        position: sticky;
        top: 0px;
        background-color: white;
        z-index: 2;

        &:hover {
            background-color: #f9286d40;
        }
    }

    .section-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        font-size: 1.2rem;
        margin: 0;
    }

    .section-title .chevron {
        transition: transform 0.3s ease;
    }

    .section.open .section-title .chevron {
        transform: rotate(180deg);
    }


    .user-list {
        max-height: 0;
        overflow: hidden;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        transition: all 0.5s ease;
    }

    .section.open .user-list {
        max-height: fit-content; 
        max-height: -moz-fit-content; 
    }

    .user-card {
        background: var(--bg-orange);
        color: var(--contrast-secondary);
        padding: 1rem;
        border-radius: 10px;
        flex: 1 1 45%;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        max-height: 115px;
        transition: .3s ease;
        overflow: hidden;
        position: relative;

        &:hover {
            max-height: 500px;
        }
    }

    .user-photo {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        background: #eee;
        transition: .3s;
        cursor: pointer;

        &:hover {
            transform: scale(1.4);
            width: 61px;
            height: 108.44px;
            border-radius: 5%;
        }
    }

    .user-info {
        display: flex;
        flex-direction: column;
        margin-top: 10px;
    }

    .user-info strong {
        font-size: 1rem;
    }

    .user-info small {
        font-size: 0.85rem;
        color: #fff;
    }

    .user-extra {
        margin-top: 10px;
        opacity: 0;
        transition: all 0.3s ease;
        max-height: 0;
        overflow: hidden;
    }

    .user-card:hover .user-extra {
        opacity: 1;
        max-height: fit-content;
        max-height: -moz-fit-content;
        align-self: start;
    }

    .user-preview {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
        gap: 20px;
    }

    .irParaPessoa {
        transition: .3s ease;
        cursor: pointer;

        &:hover {
            transform: scale(1.2);
        }
    }

    @media (max-width: 480px) {
        .user-card {
            flex: 1 1 100%;
        }

        h1 .espaco {
            width: 0 !important;
        }
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

</style>

<!-- Meio 1 de barrar celulares (JS + URL contendo "plansul") -->
<script>
    const isMobile = window.innerWidth <= 768;
    const urlContemPlansul = window.location.href.includes('plansul');

    if (isMobile || urlContemPlansul) {
        $('body').remove();
        alert("Esta página não pode ser acessada por dispositivos móveis ou com o endereço contendo 'plansul'.");
        window.location.href = '/';
    }
</script>

<!-- Meio 2 de barrar no backend (PHP + URL) -->
@php
    $userAgent = request()->header('User-Agent');
    $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod/i', $userAgent);
    $urlContemPlansul = str_contains(request()->fullUrl(), 'plansul');
@endphp

@if ($isMobile || $urlContemPlansul)
    <script>
        $('body').remove();
        alert("Esta página não pode ser acessada por dispositivos móveis ou com o endereço contendo 'plansul'.");
        window.location.href = "{{ url('/') }}";
    </script>
@endif


<div class="container">
    <h1>
        <svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 448 512"
            width="32"
            heigth="32"
            fill="currentColor"
            class="seta-esquerda"
            onclick="window.location.href = '/tinder';"
        >
            <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
        </svg>
        Seus Matchs 💘
        <span class="espaco" style="width: 32px;"></span>
    </h1>
    <div class="section" style="{{ $listarMatches->count() == 0 ? 'margin-bottom: -10px;' : '' }}">
        <h2 class="section-title" onclick="toggleSection(this)">
            {{ $listarMatches->count() }} Matchs
            <svg class="chevron" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 448 512"
                width="22" height="22" fill="currentColor">
                <path d="M207.029 381.476l-184-184c-9.373-9.373-9.373-24.569 0-33.941l22.627-22.627c9.357-9.357 24.522-9.375 33.901-.04L224 284.118l144.443-143.25c9.379-9.335 24.544-9.317 33.901.04l22.627 22.627c9.373 9.373 9.373 24.569 0 33.941l-184 184c-9.373 9.372-24.569 9.372-33.942 0z"/>
            </svg>
        </h2>
        <div class="user-list">
            @foreach ($listarMatches as $match)
                @php
                    $nomes = explode(' ', strtolower($match->nome));
                    $primeiro = ucfirst($nomes[0]);
                    $ultimo = count($nomes) > 1 ? ucfirst(end($nomes)) : '';
                    $nomeFormatado = $primeiro . ($ultimo ? ' ' . $ultimo : '');
                @endphp

                <div class="user-card">
                    <div class="user-preview">
                        <img
                            src="storage/fotos/{{ $match->matricula }}.jpg?v=${new Date().getTime()}"
                            alt="Foto de {{ $nomeFormatado }}"
                            class="user-photo"
                            onclick="zoomNaFoto(this);"
                        >
                        <div class="user-info">
                            <strong>{{ $nomeFormatado }}</strong>
                            <small>Matrícula: {{ $match->login }}</small>
                            <small>Idade: {{ $match->idade }} anos</small>
                        </div>
                    </div>
                    <div class="user-extra">
                        <p><strong>Intenção:</strong> {{ $match->intencao }}</p>
                        <p><strong>Sobre:</strong> {{ $match->de_sobre }}</p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <hr>
    <div class="section" style="{{ $likesRecebidos->count() == 0 ? 'margin-bottom: -10px;' : '' }}">
        <h2 class="section-title" onclick="toggleSection(this)">
            {{ $likesRecebidos->count() }} Curtiram você
            <svg class="chevron" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 448 512"
                width="22" height="22" fill="currentColor">
                <path d="M207.029 381.476l-184-184c-9.373-9.373-9.373-24.569 0-33.941l22.627-22.627c9.357-9.357 24.522-9.375 33.901-.04L224 284.118l144.443-143.25c9.379-9.335 24.544-9.317 33.901.04l22.627 22.627c9.373 9.373 9.373 24.569 0 33.941l-184 184c-9.373 9.372-24.569 9.372-33.942 0z"/>
            </svg>
        </h2>
        <div class="user-list">

            @foreach ($likesRecebidos as $likeRecebido)
                @php
                    $nomes = explode(' ', strtolower($likeRecebido->nome));
                    $primeiro = ucfirst($nomes[0]);
                    $ultimo = count($nomes) > 1 ? ucfirst(end($nomes)) : '';
                    $nomeFormatado = $primeiro . ($ultimo ? ' ' . $ultimo : '');
                @endphp

                <div class="user-card">
                    <div class="user-preview">
                        <img
                            src="storage/fotos/{{ $likeRecebido->matricula }}.jpg?v=${new Date().getTime()}"
                            alt="Foto de {{ $nomeFormatado }}"
                            class="user-photo"
                            onclick="zoomNaFoto(this);"
                        >
                        <div class="user-info">
                            <strong>{{ $nomeFormatado }}</strong>
                            <small>Matrícula: {{ $likeRecebido->login }}</small>
                            <small>Idade: {{ $likeRecebido->idade }} anos</small>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"
                            width="32"
                            height="32"
                            fill="currentColor"
                            class="irParaPessoa"
                            onclick="irParaPessoa('{{ $likeRecebido->matricula }}');"
                        >
                            <path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/>
                        </svg>
                    </div>
                    <div class="user-extra">
                        <p><strong>Intenção:</strong> {{ $likeRecebido->intencao }}</p>
                        <p><strong>Sobre:</strong> {{ $likeRecebido->de_sobre }}</p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <hr>
    <div class="section" style="{{ $likesFeitos->count() == 0 ? 'margin-bottom: -10px;' : '' }}">
        <h2 class="section-title" onclick="toggleSection(this)">
            {{ $likesFeitos->count() }} Curtidos por você
            <svg class="chevron" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 448 512"
                width="22" height="22" fill="currentColor">
                <path d="M207.029 381.476l-184-184c-9.373-9.373-9.373-24.569 0-33.941l22.627-22.627c9.357-9.357 24.522-9.375 33.901-.04L224 284.118l144.443-143.25c9.379-9.335 24.544-9.317 33.901.04l22.627 22.627c9.373 9.373 9.373 24.569 0 33.941l-184 184c-9.373 9.372-24.569 9.372-33.942 0z"/>
            </svg>
        </h2>
        <div class="user-list">

            @foreach ($likesFeitos as $likeFeito)
                @php
                    $nomes = explode(' ', strtolower($likeFeito->nome));
                    $primeiro = ucfirst($nomes[0]);
                    $ultimo = count($nomes) > 1 ? ucfirst(end($nomes)) : '';
                    $nomeFormatado = $primeiro . ($ultimo ? ' ' . $ultimo : '');
                @endphp

                <div class="user-card">
                    <div class="user-preview">
                        <img
                            src="storage/fotos/{{ $likeFeito->matricula }}.jpg?v=${new Date().getTime()}"
                            alt="Foto de {{ $nomeFormatado }}"
                            class="user-photo"
                            onclick="zoomNaFoto(this);"
                        >
                        <div class="user-info">
                            <strong>{{ $nomeFormatado }}</strong>
                            <small>Matrícula: {{ $likeFeito->login }}</small>
                            <small>Idade: {{ $likeFeito->idade }} anos</small>
                        </div>
                    </div>
                    <div class="user-extra">
                        <p><strong>Intenção:</strong> {{ $likeFeito->intencao }}</p>
                        <p><strong>Sobre:</strong> {{ $likeFeito->de_sobre }}</p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

<script>
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

    function irParaPessoa(matricula) {
        sessionStorage.setItem('matricula_alvo', matricula);
        window.location.href = '/tinder';
    }

    function toggleSection(clickedTitle) {
        const section = clickedTitle.closest('.section');
        const allSections = document.querySelectorAll('.section');

        allSections.forEach(s => {
        if (s !== section) s.classList.remove('open');
        });

        section.classList.toggle('open');
    }

</script>

@endsection
