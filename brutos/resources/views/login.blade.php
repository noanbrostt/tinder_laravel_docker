@extends('main')

@section('title', 'Login')

@section('conteudo')

<!-- Inspirações: AsmrProg-YT -> https://www.youtube.com/watch?v=PlpM2LJWu-s -->

<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
    }

    body {
        height: calc(var(--vh, 1vh) * 100);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background: linear-gradient(191.42deg, var(--bg-orange) 5.12%, var(--bg-blue) 107.11%);
    }

    #logo {
        width: 166px;
        position: absolute;
        top: 0px;
        justify-self: anchor-center;
        display: flex;
        align-items: center;

        img:first-child {
            width: 50px;
            height: 50px;
            margin-right: -30px;
            margin-top: -10px;
        }

        img {
            width: 100%;
        }
    }

    .container {
        background-color: #ffffff;
        border-radius: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
        position: relative;
        overflow: hidden;
        width: 768px;
        max-width: 98%;
        min-height: 480px;
        margin-inline: auto;

        p {
            font-size: 14px;
            line-height: 20px;
            letter-spacing: 0.3px;
            margin: 20px 0;
        }

        span {
            font-size: 12px;
        }

        a {
            color: var(--contrast-secondary);
            font-size: 13px;
            text-decoration: none;
            margin: 15px 0 10px;
        }

        button {
            color: var(--contrast-secondary);
            border: 1px solid var(--contrast-secondary);
            font-size: 12px;
            padding: 10px 45px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 10px;
            cursor: pointer;
        }

        .form {
            color: var(--contrast-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 190px;
            margin-inline: -150px;
            height: 100%;

            h1 {
                color: var(--bg-blue);
                font-weight: bold;
                margin-bottom: 15px;
            }
        }

        input {
            background-color: #eee;
            border: none;
            margin: 8px 0;
            padding: 10px 15px;
            font-size: 13px;
            border-radius: 8px;
            width: 100%;
            outline: none;
        }
    }

    .container.active {
        .sign-in {
            transform: translateX(100%);
            opacity: 0;
        }

        .sign-up {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: move 0.6s;
        }
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    .sign-in {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    .sign-up {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    @keyframes move {

        0%,
        49.99% {
            opacity: 0;
            z-index: 1;
        }

        50%,
        100% {
            opacity: 1;
            z-index: 5;
        }
    }

    .toggle-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: all 0.6s ease-in-out;
        border-radius: 150px 0 0 100px;
        z-index: 10;

        button {
            border: 1px solid var(--contrast-secondary);
        }
    }

    .container.active .toggle-container {
        transform: translateX(-100%);
        border-radius: 0 150px 100px 0;
    }

    .toggle {
        background-color: var(--bg-blue);
        color: var(--contrast-secondary);
        height: 100%;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: all 0.6s ease-in-out;
    }

    .container.active .toggle {
        transform: translateX(50%);
    }

    .toggle-panel {
        position: absolute;
        width: 50%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 30px;
        text-align: center;
        transform: translateX(0);
        transition: all 0.6s ease-in-out;

        h1 {
            font-weight: bold;
            margin-bottom: 0px;
        }
    }

    .toggle-left {
        transform: translateX(-200%);
    }

    .container.active .toggle-left {
        transform: translateX(0);
    }

    .toggle-right {
        right: 0;
        transform: translateX(0);
    }

    .container.active .toggle-right {
        transform: translateX(200%);
    }

    .toggle-password {
        position: relative;
        top: -35px;
        right: 10px;
        height: 0;
        font-size: 17px;
        color: var(--bg-blue);
        cursor: pointer;
        align-self: self-end;
    }

    .esqueceu {
        color: var(--contrast-primary);
    }

    .fa-eye-slash {
        right: 9px;
    }

    /* Responsive */

    @media only screen and (max-width: 600px) {
        #logo {
            top: -25px;
        }

        .container {
            margin-top: 20px;
            button {
                padding: 6px 15px;
            }

            .form-container {

                &.sign-in,
                &.sign-up {
                    top: 6%;
                    width: 100%;
                }
            }

            .toggle-container {
                left: 0;
                width: 100%;
                height: 20%;
                border-radius: 0px 0px 50px 50px;
                
                transform: translateY(-1%);

                .toggle-panel {
                    flex-direction: row;
                    flex-wrap: wrap;
                    gap: 10px;
                    padding-block: 10px;

                    h1 {
                        font-size: 20px;
                    }

                    p {
                        display: none;
                    }

                    button {
                        margin-top: 0px;
                    }
                }

                .toggle-left {
                    transform: translateX(100%) translateY(200%);
                }

                .toggle-right {
                    transform: translateX(0%) translateY(0%);
                }
            }

            &.active {
                .sign-in {
                    top: -6%;
                    transform: translateY(-0%);
                }

                .sign-up {
                    top: -6%;
                    transform: translateY(0%);
                }

                .toggle-container {
                    transform: translateY(401%);
                    border-radius: 50px 50px 0px 0px;
                    bottom: 0;

                    .toggle-left {
                        transform: translateY(0%);
                    }

                    .toggle-right {
                        transform: translateX(-100%) translateY(-200%);
                    }
                }
            }
        }
    }
</style>

<div id="logo">
    <img src="{{ asset('img/logo-plansul.png')}}" alt="Logo" />
    <img src="{{ asset('img/logo-tinder-white.png') }}" alt="Logo" />
</div>

</div>

<div class="container" id="container">
    <div class="form-container sign-up">
        <div class="form">
            <h1>Criar Senha</h1>
            <input type="text" placeholder="Matrícula Plansul" class="input_matricula" />
            <input type="text" placeholder="CPF" class="input_cpf" />
            <span class="d-contents">
                <input type="password" class="password" placeholder="Nova Senha" />
                <i class="fa-solid fa-eye toggle-password"></i>
            </span>
            <button id="register_form">
                Criar Senha
            </button>
        </div>
    </div>
    <div class="form-container sign-in">
        <div class="form">
            <h1>Entrar</h1>
            <input type="text" placeholder="Matrícula Plansul" class="input_matricula" autofocus />
            <span class="d-contents">
                <input type="password" class="password" placeholder="Senha do Paco" />
                <i class="fa-solid fa-eye toggle-password"></i>
            </span>
            <span class="c-pointer esqueceu" data-toggle="modal" data-target="#exampleModalCenter">Esqueceu sua senha?</span>
            <button id="login_form">Entrar</button>
        </div>
    </div>
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h1>Já Tem Senha?</h1>
                <p>Insira sua matrícula e senha</p>
                <button class="hidden" id="login">
                    Entrar
                </button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Sem Senha?</h1>
                <p>Crie uma senha para entrar</p>
                <button class="hidden" id="register">
                    Criar Senha
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Esqueci Minha Senha -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Recuperação de senha
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Caso seja seu primeiro acesso ou tenha esquecido sua senha,
                    clique em "Criar Senha" e crie uma nova senha.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<script>

    // Isso ajusta a altura da viewport real do device
    function setViewportHeight() {
        let vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    }
    window.addEventListener('resize', setViewportHeight);
    window.addEventListener('orientationchange', setViewportHeight);
    setViewportHeight();

    // Animação tela de login/register
    $("#register").on("click", function() {
        $("#container").addClass("active");
    });

    $("#login").on("click", function() {
        $("#container").removeClass("active");
    });
    //

    // Show password eye
    $(".toggle-password").on("click", function() {
        if ($(this).hasClass("fa-eye")) {
            $(".toggle-password")
                .removeClass("fa-eye")
                .addClass("fa-eye-slash");
            $(".password").attr("type", "text");
        } else {
            $(".toggle-password")
                .removeClass("fa-eye-slash")
                .addClass("fa-eye");
            $(".password").attr("type", "password");
        }
    });
    //

    // Input Masks
    $(".input_matricula").mask("000000");
    $(".input_cpf").mask("000.000.000-00");
    //

    $("#login_form").on("click", function(e) {
        e.preventDefault();

        let matricula = $(".sign-in .input_matricula");
        let senha = $(".sign-in .password");

        const campos = [
            {
                element: matricula,
                minLength: 6,
                message: "A matrícula deve ter 6 números.",
            },
            {
                element: senha,
                minLength: 1,
                message: "A senha está vazia.",
            },
        ];

        validarCampos(campos).then(valido => {
            if(valido){
                // ✅ Dados válidos - pode enviar via AJAX
                $.ajax({
                    url: "{{ route('login') }}",
                    type: "POST",
                    data: {
                        loginMatricula: matricula.val().trim(),
                        loginPassword: senha.val().trim(),
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Aguarde...',
                            text: 'Verificando seus dados',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function (response) {
                        // Redireciona para a página de inscrição
                        window.location.href = response.redirect;
                    },
                    error: function (error) {
                        Swal.close();

                        var erro = error.responseJSON.error;

                        if (erro == 'Matrícula não encontrada, cadastra-se em "Criar Senha".') {
                            matricula.addClass("input-error");
                        } else if (erro == 'Senha incorreta.') {
                            senha.addClass("input-error");
                        }

                        Toast.fire({
                            icon: "error",
                            title: erro,
                        });
                    },
                });
            }
        });
    });

    $("#register_form").on("click", function(e) {
        let matricula = $(".sign-up .input_matricula");
        let cpf = $(".sign-up .input_cpf");
        let senha = $(".sign-up .password");

        const campos = [
            {
                element: matricula,
                minLength: 6,
                message: "A matrícula deve ter 6 números.",
            },
            {
                element: cpf,
                minLength: 14, // Máscara aplicada no CPF
                message: "O CPF deve ter 11 números.",
            },
            {
                element: senha,
                minLength: 1,
                message: "A senha está vazia.",
            },
        ];

        validarCampos(campos).then(valido => {
            if (valido) {
                // ✅ Dados válidos - pode enviar via AJAX
                $.ajax({
                    url: "{{ route('resetarSenha') }}",
                    type: "POST",
                    data: {
                        matricula: matricula.val().trim(),
                        cpf: cpf.val().replace(/\D/g, '').trim(),
                        nova_senha: senha.val().trim(),
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Aguarde...',
                            text: 'Verificando seus dados',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function (response) {
                        // Redireciona para a página de inscrição
                        window.location.href = response.redirect;
                    },
                    error: function (error) {
                        Swal.close();

                        var erro = error.responseJSON.error;

                        if (erro == 'CPF não encontrado.') {
                            cpf.addClass("input-error");
                        }

                        Toast.fire({
                            icon: "error",
                            title: erro,
                        });

                    },
                });
            }
        });


    });

    $(".sign-in input, .sign-up input").on("keydown", function(e) {
        if (e.key === "Enter") {
            e.preventDefault();

            const container = $(this).closest(".form"); // Encontra o container do formulário atual
            const inputs = container.find("input"); // Todos os inputs desse container
            const index = inputs.index(this); // Pega o índice do input atual

            if (index === inputs.length - 1) {
                // Último input → clica no botão desse container
                container.find("button").click();
            } else {
                // Foca no próximo input
                inputs.eq(index + 1).focus();
            }
        }
    });

</script>

@endsection