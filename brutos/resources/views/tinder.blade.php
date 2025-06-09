@extends('main')

@section('title', 'Login')

@section('conteudo')

<style>
    body {
        background: linear-gradient(191.42deg, var(--bg-orange) 5.12%, var(--bg-blue) 107.11%);
        height: 100vh;
        width: 100vw;
        font-family: "Roboto", sans-serif;
        overflow: hidden;
        display: flex;
        align-content: center;
    }

    #conteudo {
        display: flex;
    }

    p {
        margin-bottom: 0;
    }

    .smartphone {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        margin: auto;
        border-radius: 15px;
        width: clamp(290px, 49vh, 360px);
        height: clamp(580px, 98vh, 720px);
        border: 8px solid black;
    }

    .screen {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        width: 100%;
        height: 100%;
        background: rgb(255, 250, 250);
        border: 2px solid rgba(0, 0, 0, 0.15);
        border-radius: 7px;
    }

    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 101.5%;
        padding: 2px 2%;
        position: relative;
        top: -2px;
        height: 20px;
        background: #838383;
        color: white;
        font-size: 15px;
        border-radius: 7px 7px 0 0;
        font-family: monospace;
    }

    .topbar-left {
        display: flex;
        align-items: center;
    }

    .topbar-middle {
        margin-left: 9px;
    }

    .topbar-middle::before {
        content: "";
        background: black;
        width: 10px;
        height: 50px;
        top: 248px;
        right: -11px;
        border-radius: 5px;
        position: absolute;
    }

    .clock {
        padding-right: 9px;
    }

    .camera {
        background: black;
        width: 54px;
        height: 10.2px;
        position: relative;
        top: 6.3px;
        border-radius: 0 0 20px 20px;
    }

    .camera::before {
        content: "";
        position: absolute;
        width: 31.7px;
        height: 16px;
        border-radius: 43%;
        top: 3.7px;
        left: -13.7px;
        background: #838383;
    }

    .camera::after {
        content: "";
        position: absolute;
        width: 31.7px;
        height: 16px;
        border-radius: 43%;
        top: 3.7px;
        left: 42.9px;
        background: #838383;
    }

    .camera-lens {
        background: black;
        width: 25px;
        height: 25px;
        top: -7px;
        left: 18px;
        border-radius: 50%;
        position: relative;
    }

    .camera-lens::before {
        content: "";
        position: absolute;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        top: 7px;
        left: 6px;
        background: #2c3c3c;
    }

    .camera-lens::after {
        content: "";
        position: absolute;
        width: 3px;
        height: 12px;
        transform: rotate(45deg);
        top: 9.9px;
        left: 13.2px;
        background: #4056569e;
        border-radius: 0 20px 20px 0;
    }

    .inner-lens {
        position: relative;
        width: 5px;
        height: 5px;
        background: #565555a8;
        border-radius: 50%;
        top: -20.8px;
        left: 28px;
    }

    .inner-lens::after {
        content: "";
        position: absolute;
        width: 1.8px;
        height: 1.8px;
        transform: rotate(45deg);
        top: 1.6px;
        left: 1.6px;
        background: #00000085;
        border-radius: 50%;
    }

    .topbar-right {
        font-family: monospace;
    }

    .topbar-right::before {
        content: "";
        background: black;
        width: 10px;
        height: 140px;
        top: 80px;
        right: -11px;
        border-radius: 5px;
        position: absolute;
    }

    .topbar-right::after {
        content: "";
        background: #fc5952;
        width: 10px;
        height: 12px;
        top: 149px;
        right: -19.3px;
        border-radius: 5px;
        position: absolute;
    }

    .screen footer {
        display: flex;
        align-items: center;
        justify-content: space-around;
        width: 102%;
        padding: 8px;
        margin-bottom: -2px;
        height: 25px;
        background: black;
        color: white;
        font-size: 15px;
    }

    .navbar {
        display: flex;
        justify-content: space-around;
        align-items: baseline;
        padding: 10px 0;
        width: 100%;
        height: 45px;

        img {
            width: 140px;
            margin-top: -5px;
        }
    }

    .person {
        width: 99%;
        height: 100%;
        background: #d6d5d5;
        border-radius: 10px;
    }

    .photo {
        margin: auto;
        height: 100%;
        border-radius: 10px;
        display: flex;
        align-items: flex-end;
        color: #eee;
        box-shadow: 0 2px 7px 0 rgba(136, 136, 136, 0.7);
        cursor: grab;
        transition: 300ms;
    }

    .photo.moving {
        transition: none;
        cursor: grabbing;
    }

    .photo.nope::after {
        content: "PASS";
        color: #f7e707;
        border: 6px solid #f7e707;
        border-radius: 8px;
        font-family: "Roboto", sans-serif;
        font-weight: 500;
        font-size: 3rem;
        padding: 0.2rem 0.4rem;
        position: absolute;
        top: 8%;
        right: 8%;
        transform: rotate(15deg);
    }

    .photo.like::after {
        content: "LIKE";
        color: #1be4a1;
        border: 6px solid #1be4a1;
        border-radius: 8px;
        font-family: "Roboto", sans-serif;
        font-weight: 500;
        font-size: 3rem;
        padding: 0.2rem 0.4rem;
        position: absolute;
        top: 8%;
        left: 8%;
        transform: rotate(-15deg);
    }

    .personal {
        padding: 10px;
        width: 100%;
        background: linear-gradient(180deg,
                rgba(0, 0, 0, 0) 0%,
                rgba(0, 0, 0, 0.5) 24%);
        border-radius: 10px;
        transition-duration: .5s;

        p {
            font-size: 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 60px;
            transition: max-height .6s ease;
        }
    }

    .name-age {
        display: flex;
        align-items: baseline;
        margin-bottom: 6px;
    }

    .name {
        font-size: 2rem;
        font-weight: 500;
    }

    .age {
        font-size: 1.6rem;
        margin-left: 10px;
        font-weight: 400;
    }

    /* Ao passar o mouse na div.person */
    .person:hover .personal,
    .person:has(+ .commands .command:hover) .personal {
        background: linear-gradient(180deg,
                rgba(0, 0, 0, 0) 0%,
                rgba(0, 0, 0, 0.8) 24%);

        .data p {
            max-height: 600px;
        }
    }


    .about {
        display: flex;
    }

    .about-icon,
    .about-text {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
    }

    .about-icon {
        align-items: center;
    }

    .about-text {
        align-items: flex-start;
        margin-left: 6px;
    }

    .about-icon i,
    .about-text p {
        padding: 4px 0;
    }

    /* Actions */
    .commands {
        width: 100%;
        display: flex;
        justify-content: space-around;
        align-items: center;
        height: 100px;
    }

    .command {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        height: 60px;
        width: 60px;
        border-radius: 50%;
        font-size: 2rem;
        box-shadow: 0 2px 6px 0 rgba(112, 125, 134, 0.14);
        transition: 500ms ease;
        cursor: pointer;
    }

    .command i {
        transition: 500ms ease;
    }

    .command:hover {
        transform: scale(1.1);
        color: #fff;
        box-shadow: 0 2px 6px 0 rgba(112, 125, 134, 0.33);
    }

    .command:hover i {
        transform: scale(1.15);
    }

    .events-none {
        pointer-events: none;
    }

    /* icon size and colors */
    .fa-fire-flame-curved {
        font-size: 13px;
    }

    .fa-circle-info {
        cursor: pointer;
        transition: 500ms ease;
    }

    .fa-circle-info:hover {
        transform: scale(1.1);
        color: #fff;
    }

    .fa-forward {
        color: #f7e707;
    }

    .fa-heart {
        color: #1be4a1;
    }

    .fa-question-circle {
        font-size: 19px;
        position: absolute;
        right: 7px;
        top: 9px;
        cursor: pointer;
        padding: 5px;
        transition: 0.3s;

        &:hover {
            transform: scale(1.2);
        }
    }

    @keyframes flutuar {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }

        33% {
            transform: translate(-140px, 40px) rotate(-8deg);
        }

        66% {
            transform: translate(140px, -40px) rotate(8deg);
        }

        100% {
            transform: translate(0, 0) rotate(0deg);
        }
    }

    .flutuar {
        animation: flutuar 3s ease-in-out infinite;
    }

    @keyframes pulsar {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }

    .pulsar {
        animation: pulsar 3s ease-in-out infinite;
    }

    .alto .data p {
        max-height: 600px;
    }

</style>

<!-- <script src="https://cdn.jsdelivr.net/npm/driver.js@latest/dist/driver.js.iife.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@latest/dist/driver.css" /> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/intro.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/introjs.min.css" />

<div class="smartphone">
    <div class="screen">
        <div class="topbar">
            <div class="topbar-left">
                <div class="clock">00:00</div>
                <svg xmlns="http://www.w3.org/2000/svg" 
                    width="24" height="24" viewBox="0 0 384 512" 
                    fill="currentColor" 
                    style="cursor: pointer;">
                <path d="M216 0c-12.3 0-23.3 7-28.4 17.9C175.1 53.4 160 98.5 160 128c0 25.3 8.4 46.7 17.4 66.3l-10.9-6.9C149.4 178.5 128 164.6 128 128c0-24.2-16.7-38.3-28.4-43.8c-10.6-5-23.2-2.5-31.3 6.1C24.2 139.5 0 195.8 0 256c0 141.4 114.6 256 256 256s256-114.6 256-256c0-53.7-26.6-108.2-70.6-149.6c-9.2-8.7-23.1-9.9-33.8-3.1c-27.8 17.7-58.4 27.4-92.6 27.4c-21.5 0-42.1-5.4-61.1-14.5C224.6 137.4 216 114.5 216 96V0z"/>
                </svg>
            </div>
            <div class="topbar-middle">
                <div class="camera"></div>
                <div class="camera-lens"></div>
                <div class="inner-lens"></div>
            </div>
            <div class="topbar-right">
                <i class="fa fa-signal"></i>
                73%
                <i class="fa fa-battery-three-quarters"></i>
            </div>
        </div>
        <nav class="navbar">
            <img src="data:image/png;base64,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"
                alt="Tinder Plansul">
            <i class="fa fa-question-circle" data-intro='Se quiser ver esse tour novamente, só clicar aqui.'
                data-step="5" data-position="right"></i>
        </nav>
        <div class="person">
            <figure class="photo"
                data-intro='Bem-vindo, arraste a foto para à esquerda para "Passar" alguém, e arraste para à direita para "Gostar" de alguém.'
                data-step="1" data-position="left">
                <div class="personal"
                    data-intro='E ao passar o mouse em qualquer um desses elementos, a descrição da pessoa expandirá.'
                    data-step="4" data-position="right">
                    <div class="name-age">
                        <h2 class="name">Lorem</h2>
                        <h2 class="age">26</h2>
                    </div>
                    <div class="data">
                        <p>
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, quasi cum a voluptatibus eius
                            eum temporibus? Voluptate quidem odio consectetur ea veniam debitis repellat aspernatur,
                            molestiae reiciendis eaque quod perspiciatis. Lorem Ipsum d
                        </p>
                    </div>
                </div>
            </figure>
        </div>
        <div class="commands">
            <div class="command passar"
                data-intro='Esse botão (>>) serve para "Passar" alguém, isso jogará a pessoa para o fim da fila!'
                data-step="2" data-position="top">
                <i class="fa-solid fa-forward"></i>
            </div>
            <div class="command coracao"
                data-intro='Esse botão (♡) serve para "Gostar" de alguém, isso dará um coração pra ela, e se a pessoa também gostar de você, é um Match!'
                data-step="3" data-position="top">
                <i class="fa-solid fa-heart"></i>
            </div>
        </div>
        <footer>
            <i class="fa fa-reorder"></i>
            <i class="fa fa-square-o"></i>
            <i class="fa fa-chevron-left"></i>
        </footer>
    </div>
</div>

<script>
    // Gets the photo element
    var el = document.querySelector(".photo");
    var girlCount = 0;
    var girlLast = 5;
    // Creates the object
    var hammerTime = new Hammer(el);
    // Unlocks vertical pan and pinch
    hammerTime.get("pan").set({
        direction: Hammer.DIRECTION_ALL
    });
    hammerTime.get("pinch").set({
        enable: true
    });

    // When user grabs the photo..
    hammerTime.on("pan", function (ev) {
        // When the photo start moving, the transition become "none" to avoid delay while dragging
        el.classList.add("moving");
        // If the photo go 80px left/right, the "nope"/"like" stamp appears using css::after
        el.classList.toggle("nope", ev.deltaX < -80);
        el.classList.toggle("like", ev.deltaX > 80);

        // Calculates photo rotation based on offset
        var rotate = ev.deltaX * ev.deltaY * 4e-4;
        // And applies the movement
        el.style.transform =
            "translate(" +
            ev.deltaX +
            "px, " +
            ev.deltaY +
            "px) rotate(" +
            rotate +
            "deg)";
    });

    // When user releases the photo..
    hammerTime.on("panend", function (ev) {
        // Gets the positive value of velocity and X-deslocation
        var absVel = Math.abs(ev.velocity);
        var absDelX = Math.abs(ev.deltaX);
        // Removes the stamps and retrieve the 300ms transition
        el.classList.remove("nope", "like", "moving");
        if (absDelX > 80) {
            // If the photo had a "like"/"dislike" reaction
            // Photo fades faster if dragged faster, beetwen 400 and 150ms
            var transitionDuration =
                250 / (absVel + 0.4) > 150 ?
                250 / (absVel + 0.4) > 400 ?
                400 :
                250 / (absVel + 0.4) :
                150;
            el.style.transitionDuration = transitionDuration + "ms";
            var rotate = ev.deltaX * ev.deltaY * 4e-4;
            // And is thrown farther too
            var mult = absVel > 1.4 ? absVel : 1.4;
            el.style.transform =
                "translate(" +
                ev.deltaX * 1.4 * mult +
                "px, " +
                ev.deltaY * mult +
                "px) rotate(" +
                rotate * mult +
                "deg)";
            // Fade out
            el.style.opacity = 0;
            // And the photo returns
            repeat(transitionDuration);
        } else {
            // If the photo didn't have a reaction, it goes back to the middle
            el.style.transform = "";
        }
    });

    hammerTime.on("pinch", function (ev) {
        el.style.transitionDuration = "0ms";
        el.style.transform = "scale(" + ev.scale + ")";
    });

    hammerTime.on("pinchend", function () {
        el.style.transform = "scale(1)";
    });

    // The function that brings back the photo
    function repeat(transitionDuration = 350) {
        setTimeout(function () {
            el.style.transform = "";
            setTimeout(function () {
                el.classList.remove("nope", "like", "moving");
                el.style.opacity = 1;
                setTimeout(function () {
                    // Reactivates the buttons with a slight delay so that the photo has time to be recognized
                    document
                        .querySelector(".commands")
                        .classList.remove("events-none");
                }, 140);
            }, transitionDuration);
            switchingPeople();
        }, transitionDuration);
    }

    function switchingPeople () {
        girlCount == girlLast ? (girlCount = 1) : girlCount++;
        document.querySelector(".photo").style.background =
            "url('../assets/tinderImgs/girl" + girlCount + ".jpeg') center center/cover";
        switch (girlCount) {
            case 1:
                document.querySelector(".name").innerHTML = "Lorem";
                document.querySelector(".age").innerHTML = "26";
                document.querySelector(".ocupation").innerHTML = "Designer";
                document.querySelector(".work").innerHTML = "Stanford University";
                document.querySelector(".distance").innerHTML = "3 miles away";
                break;
            case 2:
                document.querySelector(".name").innerHTML = "Ipsum";
                document.querySelector(".age").innerHTML = "31";
                document.querySelector(".ocupation").innerHTML = "Lawyer";
                document.querySelector(".work").innerHTML = "Stanford University";
                document.querySelector(".distance").innerHTML = "4 miles away";
                break;
            case 3:
                document.querySelector(".name").innerHTML = "Dolor";
                document.querySelector(".age").innerHTML = "32";
                document.querySelector(".ocupation").innerHTML = "Engineer";
                document.querySelector(".work").innerHTML = "Stanford Engineering";
                document.querySelector(".distance").innerHTML = "4 miles away";
                break;
            case 4:
                document.querySelector(".name").innerHTML = "Sit";
                document.querySelector(".age").innerHTML = "29";
                document.querySelector(".ocupation").innerHTML = "Doctor";
                document.querySelector(".work").innerHTML = "Stanford Medicine";
                document.querySelector(".distance").innerHTML = "5 miles away";
                break;
        }
    }

    // The reactions animation
    function buttonEvent(reaction) {
        // Random transition duration beetwen 300ms and 600ms
        var transitionDuration = Math.random() * 300 + 300;
        // Random X-deslocation beetwen 100px and 400px
        var x = Math.random() * 300 + 100;
        // Random Y-deslocation beetwen -200px and 200px
        var y = Math.random() * 400 - 200;
        var rotate = x * y * 4e-4;
        // Prevents giving new command before current one is finished
        document.querySelector(".commands").classList.add("events-none");
        if (reaction == "like") {
            // If the reaction was a "like", stamps "like"
            el.classList.add("like");
        } else if (reaction == "dislike") {
            // If the reaction was a "dislike", stamps "nope" and moves the photo to the left
            el.classList.add("nope");
            x *= -1;
        }

        el.style.transitionDuration = transitionDuration + "ms";
        el.style.transform =
            "translate(" + x + "px, " + y + "px) rotate(" + rotate + "deg)";
        el.style.opacity = 0;
        repeat(transitionDuration * 0.8);
    }

    // Creates button actions
    document
        .querySelector(".fa-forward")
        .parentNode.addEventListener("click", function () {
            buttonEvent("dislike");
        });

    document
        .querySelector(".fa-heart")
        .parentNode.addEventListener("click", function () {
            buttonEvent("like");
        });

    // Clock
    var clockTicking = setInterval(clock, 1000);

    function clock() {
        var d = new Date(),
            displayDate;
        displayDate = d.toLocaleTimeString();
        document.querySelector(".clock").innerHTML = displayDate.substring(0, 5);
    }

    switchingPeople();


    // Biblioteca do tutorial
    document.addEventListener('DOMContentLoaded', () => {
        intro = introJs(); // Cria a instância do introJs

        intro.setOptions({
            helperElementPadding: 0,
            doneLabel: 'Entendi!', // Personaliza o texto do botão "Done"
            nextLabel: 'Próximo →',
            prevLabel: '← Anterior',
            skipLabel: 'x'
        });

        // Callback antes de cada mudança de passo
        intro.onbeforechange((element) => {
            const currentStep = intro._introItems[intro._currentStep]; // Acessa o passo atual

            // Verifica se é o primeiro passo (data-step="1")
            // ou se é o elemento do primeiro passo
            if (currentStep.element && currentStep.element.classList.contains('photo')) {
                $('.photo').addClass('flutuar');

            } else if (currentStep.element && currentStep.element.classList.contains('passar')) {
                limparClasses();
                $('.passar').addClass('pulsar');

            } else if (currentStep.element && currentStep.element.classList.contains('coracao')) {
                limparClasses();
                $('.coracao').addClass('pulsar');

            } else if (currentStep.element && currentStep.element.classList.contains('personal')) {
                limparClasses();
                $('.personal').addClass('alto');

            } else {
                limparClasses();
            }
        });

        intro.onexit(() => {
            limparClasses();
        });

        intro.oncomplete(() => {
            limparClasses();
        });

        intro.start(); // Inicia o tour
    });

    function limparClasses() {
        $('.photo').removeClass('flutuar');
        $('.command').removeClass('pulsar');
        $('.personal').removeClass('alto');
    }

    $('.fa-question-circle').on('click', function () {
        intro.start();
    });
    // Fim da biblioteca do tutorial







    const usuarios = @json($usuarios);
    console.log("Usuários recebidos do backend:", usuarios);


    let todosPerfis = @json($usuarios); // Recebido da Controller
    let filaAtual = [];
    let perfilAtualIndex = 0;

    $(document).ready(function () {
        embaralhar(todosPerfis);
        filaAtual = [...todosPerfis];
        exibirProximoPerfil();

        $('.coracao').click(() => reagir('like'));
        $('.passar').click(() => reagir('pass'));
    });

    function exibirProximoPerfil() {
        if (filaAtual.length === 0) {
            Swal.fire({
                title: 'Perfis finalizados!',
                text: 'Reiniciando a fila com os que você passou...',
                icon: 'info',
                confirmButtonText: 'Ok'
            }).then(() => {
                reiniciarComPasses();
            });
            return;
        }

        const perfil = filaAtual[0];
        $('#perfil').html(`
            <h2>${perfil.nome}</h2>
            <img src="${perfil.foto}" alt="${perfil.nome}" width="200">
        `);
    }

    function reagir(tipo) {
        const perfil = filaAtual[0];

        // Envia para o back-end imediatamente
        $.post('/registrar-reacao', {
            target_id: perfil.id,
            tipo: tipo
        });

        // Atualiza a lista
        if (tipo === 'like') {
            // Remove completamente o perfil
            todosPerfis = todosPerfis.filter(p => p.id !== perfil.id);
        } else {
            // Move para o final
            filaAtual.push(perfil);
        }

        // Remove o atual da fila
        filaAtual.shift();

        // Próximo
        exibirProximoPerfil();
    }

    function reiniciarComPasses() {
        filaAtual = [...todosPerfis]; // Apenas os que restaram (sem likes)
        embaralhar(filaAtual);
        exibirProximoPerfil();
    }

    function embaralhar(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

</script>



@endsection
