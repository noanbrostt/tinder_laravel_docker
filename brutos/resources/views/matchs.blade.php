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
    }

    .user-list {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
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
        cursor: pointer;

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

<!-- Meio 1 de barrar celulares -->
<script>
    // Detecta mobile antes de renderizar o conteúdo
    if (window.innerWidth <= 768) {
        $('body').remove();
        alert("Esta página não pode ser acessada por dispositivos móveis.");
        window.location.href = '/';
    }
</script>

<!-- Meio 2 de barrar celulares -->
@php
    $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod/i', request()->header('User-Agent'));
@endphp

@if ($isMobile)
    <script>
        $('body').remove();
        alert("Esta página não pode ser acessada por dispositivos móveis.");
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
    <div class="section" style="{{ $listarMatches->count() == 0 ? 'margin-bottom: -20px;' : '' }}">
        <h2>{{ $listarMatches->count() }} Matchs</h2>
        <div class="user-list">

            @foreach ($listarMatches as $match)
                @php
                    $nomes = explode(' ', strtolower($match->nome));
                    $primeiro = ucfirst($nomes[0]);
                    $ultimo = count($nomes) > 1 ? ucfirst(end($nomes)) : '';
                    $nomeFormatado = $primeiro . ($ultimo ? ' ' . $ultimo : '');
                @endphp

                <div class="user-card" onclick="zoomNaFoto(this.querySelector('img'));">
                    <div class="user-preview">
                        <img
                            src="storage/fotos/{{ $match->matricula }}.jpg?v=${new Date().getTime()}"
                            alt="Foto de {{ $nomeFormatado }}"
                            class="user-photo"
                        >
                        <div class="user-info">
                            <strong>{{ $nomeFormatado }}</strong>
                            <small>Matrícula: {{ $match->matricula }}</small>
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
    <div class="section" style="{{ $likesRecebidos->count() == 0 ? 'margin-bottom: -20px;' : '' }}">
        <h2>{{ $likesRecebidos->count() }} Curtiram você</h2>
        <div class="user-list">

            @foreach ($likesRecebidos as $likeRecebido)
                @php
                    $nomes = explode(' ', strtolower($likeRecebido->nome));
                    $primeiro = ucfirst($nomes[0]);
                    $ultimo = count($nomes) > 1 ? ucfirst(end($nomes)) : '';
                    $nomeFormatado = $primeiro . ($ultimo ? ' ' . $ultimo : '');
                @endphp

                <div class="user-card" onclick="zoomNaFoto(this.querySelector('img'));">
                    <div class="user-preview">
                        <img
                            src="storage/fotos/{{ $likeRecebido->matricula }}.jpg?v=${new Date().getTime()}"
                            alt="Foto de {{ $nomeFormatado }}"
                            class="user-photo"
                        >
                        <div class="user-info">
                            <strong>{{ $nomeFormatado }}</strong>
                            <small>Matrícula: {{ $likeRecebido->matricula }}</small>
                            <small>Idade: {{ $likeRecebido->idade }} anos</small>
                        </div>
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
    <div class="section" style="{{ $likesFeitos->count() == 0 ? 'margin-bottom: -20px;' : '' }}">
        <h2>{{ $likesFeitos->count() }} Curtidos por você</h2>
        <div class="user-list">

            @foreach ($likesFeitos as $likeFeito)
                @php
                    $nomes = explode(' ', strtolower($likeFeito->nome));
                    $primeiro = ucfirst($nomes[0]);
                    $ultimo = count($nomes) > 1 ? ucfirst(end($nomes)) : '';
                    $nomeFormatado = $primeiro . ($ultimo ? ' ' . $ultimo : '');
                @endphp

                <div class="user-card" onclick="zoomNaFoto(this.querySelector('img'));">
                    <div class="user-preview">
                        <img
                            src="storage/fotos/{{ $likeFeito->matricula }}.jpg?v=${new Date().getTime()}"
                            alt="Foto de {{ $nomeFormatado }}"
                            class="user-photo"
                        >
                        <div class="user-info">
                            <strong>{{ $nomeFormatado }}</strong>
                            <small>Matrícula: {{ $likeFeito->matricula }}</small>
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
    $(document).ready(function() {

        let feitos = @json($likesFeitos);
        console.log(feitos);
        
        let recebidos = @json($likesRecebidos);
        console.log(recebidos);
        
        let matchs = @json($likesFeitos);
        console.log(matchs);
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

</script>

@endsection
