<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('/CSS/contactenos.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Contactenos</title>
</head>

<body>

    <div class="wrap">
        <h1 class="hero-title">CONTACTENOS</h1>

        {{-- FORMULARIO FUNCIONAL --}}
        <form action="{{ route('contactenos.store') }}" method="POST">
            @csrf

            <div class="card" role="form" aria-label="Formulario reservar cita">

                <h3 class="section-title">Informacion de contacto</h3>

                <div class="form-grid">

                    <div class="field">
                        <label for="tipo">Tipo de solicitante</label>
                        <select id="tipo" name="tipo" required>
                            <option value="" disabled selected hidden>Seleccione tipo...</option>
                            <option value="natural">Persona Natural</option>
                            <option value="empresa">Empresa</option>
                            <option value="escuela">Escuela Deportiva</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="nombre_completo">Nombres y apellidos</label>
                        <input id="nombre_completo" type="text" name="nombre_completo"
                               placeholder="Ej: Juan Perez" autocomplete="name" required>
                    </div>

                    <div class="field">
                        <label for="documento">Documento de identidad</label>
                        <input id="documento" type="text" name="documento"
                               placeholder="Ej: 1023456789" autocomplete="off" required>
                    </div>

                    <div class="field">
                        <label for="telefono_natural">Telefono</label>
                        <input id="telefono_natural" type="text" name="telefono_natural"
                               placeholder="Ej: +57 300 123 4567" autocomplete="tel">
                    </div>

                    <div class="field">
                        <label for="correo_electronico">Correo electronico</label>
                        <input id="correo_electronico" type="email" name="correo_electronico"
                               class="input-email" placeholder="ejemplo@correo.com"
                               autocomplete="email" required>
                    </div>

                    <div class="field">
                        <label for="razon_social">Nombre de la entidad</label>
                        <input id="razon_social" type="text" name="razon_social"
                               placeholder="Si aplica, nombre de la entidad"
                               autocomplete="organization">
                    </div>

                </div>

                <h3 class="section-title">Informacion del evento</h3>

                <div class="form-grid">

                    <div class="field">
                        <label for="evento_nombre">Nombre del evento</label>
                        <input id="evento_nombre" type="text" name="evento_nombre"
                               placeholder="Ej: Torneo Intercolegial 2026">
                    </div>

                    <div class="field">
                        <label for="categoria">Categoria</label>
                        <select id="categoria" name="categoria" required>
                            <option value="" disabled selected hidden>Seleccione categoria...</option>
                            <option value="hombres">Hombres</option>
                            <option value="mujeres">Mujeres</option>
                            <option value="infantil">Infantil</option>
                            <option value="mixto_adultos">Mixto adultos</option>
                            <option value="mixto_infantil">Mixto infantil</option>
                        </select>
                    </div>

                    <div class="field full">
                        <label for="descripcion">Descripcion del evento</label>
                        <textarea id="descripcion" name="descripcion" rows="5"
                                  placeholder="Describe brevemente el objetivo, numero de participantes, edad aproximada, necesidades (cancha, arbitros, seguridad), etc."></textarea>
                    </div>

                    <div class="field">
                        <label for="fecha_inicial">Fecha inicial del evento</label>
                        <input id="fecha_inicial" type="date" name="fecha_inicial">
                    </div>

                    <div class="field">
                        <label for="fecha_final">Fecha final del evento</label>
                        <input id="fecha_final" type="date" name="fecha_final">
                    </div>

                </div>

                <button class="btn" type="submit">ENVIAR</button>

            </div>
        </form>
    </div>

<script>

    const telInput = document.getElementById("telefono_natural");
    telInput.addEventListener("input", function () {
        const original = this.value;
        const soloNumeros = original.replace(/[^0-9+\-() ]/g, "");
        if (original !== soloNumeros) {
            alert("Solo se permiten numeros en este campo");
            this.value = soloNumeros;
        }
    });

    const telInput2 = document.getElementById("documento");
    telInput2.addEventListener("input", function () {
        const original = this.value;
        const soloNumeros = original.replace(/[^0-9]/g, "");
        if (original !== soloNumeros) {
            alert("Solo se permiten numeros en este campo");
            this.value = soloNumeros;
        }
    });

    // === VALIDACION DEL CORREO ===
    const emailInput = document.getElementById("correo_electronico");

    emailInput.addEventListener("input", function () {
        const original = this.value;
        const permitido = original.replace(/[^a-zA-Z0-9@._-]/g, "");
        if (original !== permitido) {
            alert("En el campo Correo solo se permiten caracteres válidos.");
            this.value = permitido;
        }
    });

    emailInput.addEventListener("blur", function () {
        const correo = this.value.trim();
        const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (correo !== "" && !regexCorreo.test(correo)) {
            alert("El correo ingresado no es válido. Ejemplo: usuario@correo.com");
        }
    });

</script>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Registro exitoso!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#3f61ff',
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif


</body>
</html>
