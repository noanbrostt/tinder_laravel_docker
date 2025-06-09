$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// ✅ Tornar Toast global
Toast = Swal.mixin({
    toast: true,
    position: "top",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

// ✅ Tornar validarCampos global
function validarCampos(campos) {
    return new Promise((resolve) => {
        let erros = [];

        // Resetar erros anteriores
        campos.forEach((campo) => {
            campo.element.removeClass("input-error");
        });

        setTimeout(() => {
            campos.forEach((campo) => {
                let valor = "";

                if (campo.type === "custom") {
                    if (!campo.isValid) {
                        erros.push(campo.message);
                        campo.element.addClass("input-error");
                    }
                    return;
                }

                if (
                    campo.element.is("input") ||
                    campo.element.is("textarea") ||
                    campo.element.is("select")
                ) {
                    valor = campo.element.val().trim();
                }

                const minLength = campo.minLength || 1;

                if (valor.length < minLength) {
                    erros.push(campo.message);
                    campo.element.addClass("input-error");
                }
            });

            if (erros.length > 0) {
                erros.forEach((erro, index) => {
                    console.log(erro);
                    setTimeout(() => {
                        Toast.fire({
                            icon: "error",
                            title: erro,
                        });
                    }, index * 600);
                });
                return resolve(false);
            }

            resolve(true);
        }, 0);
    });
}


// 🔧 Remover borda de erro ao começar a digitar/selecionar
$(document).on("input change", ".input-error", function() {
    $(this).removeClass("input-error");
});
