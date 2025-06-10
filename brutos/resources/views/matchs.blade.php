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

    h1 {
        color: var(--bg-blue);
        text-align: center;
        margin-bottom: 2rem;
    }

    .section {
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
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        height: 100px;
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
            width: 70px;
            height: 124.44px;
            border-radius: 5%;
        }
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-info strong {
        font-size: 1rem;
    }

    .user-info small {
        font-size: 0.85rem;
        color: #fff;
    }

    @media (max-width: 480px) {
        .user-card {
            flex: 1 1 100%;
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

<div class="container">
    <h1>Seus Matchs 💘</h1>
    <div class="section">
        <h2>3 Matchs 💖</h2>
        <div class="user-list">
            <div class="user-card">
                <img src="https://via.placeholder.com/64" alt="Foto de Ana Souza" class="user-photo" onclick="zoomNaFoto(this);">
                <div class="user-info">
                    <strong>Ana Souza</strong>
                    <small>Matrícula: 123456</small>
                    <small>Idade: 25 anos</small>
                </div>
            </div>
            <div class="user-card">
                <img src="https://via.placeholder.com/64" alt="Foto de Lucas Martins" class="user-photo" onclick="zoomNaFoto(this);">
                <div class="user-info">
                    <strong>Lucas Martins</strong>
                    <small>Matrícula: 789012</small>
                    <small>Idade: 22 anos</small>
                </div>
            </div>
            <div class="user-card">
                <img src="https://via.placeholder.com/64" alt="Foto de Juliana Lima" class="user-photo" onclick="zoomNaFoto(this);">
                <div class="user-info">
                    <strong>Juliana Lima</strong>
                    <small>Matrícula: 345678</small>
                    <small>Idade: 28 anos</small>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="section">
        <h2>2 Curtiram você</h2>
        <div class="user-list">
            <div class="user-card">Ana</div>
            <div class="user-card">Bruna</div>
        </div>
    </div>
    <hr>
    <div class="section">
        <h2>2 Curtidos por você</h2>
        <div class="user-list">
            <div class="user-card">Carlos</div>
            <div class="user-card">Daniela</div>
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

</script>

@endsection
