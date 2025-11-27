<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('/CSS/contactenos.css') }}">

    <title>Contactenos</title>
</head>

<body>

    <div class="wrap">
        <h1 class="hero-title">CONTACTENOS</h1>

        <div class="card" role="form" aria-label="Formulario reservar cita">

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
                    <input id="nombre_completo" type="text" name="nombre_completo" placeholder="Ej: Juan Perez" autocomplete="name" required>
                </div>

                <div class="field">
                    <label for="documento">Documento de identidad</label>
                    <input id="documento" type="text" name="documento" placeholder="Ej: 1023456789" autocomplete="off" required>
                </div>

                <div class="field">
                    <label for="telefono_natural">Telefono</label>
                    <input id="telefono_natural" type="text" name="telefono_natural" placeholder="Ej: +57 300 123 4567" autocomplete="tel">
                </div>

                <div class="field">
                    <label for="correo_electronico">Correo electronico</label>
                    <input id="correo_electronico" type="email" name="correo_electronico" class="input-email" placeholder="ejemplo@correo.com" autocomplete="email" required>
                </div>

                <div class="field">
                    <label for="razon_social">Nombre de la entidad</label>
                    <input id="razon_social" type="text" name="razon_social" placeholder="Si aplica, nombre de la entidad" autocomplete="organization">
                </div>

            </div>

            <h3 class="section-title">Informacion del evento</h3>

            <div class="form-grid">

                <div class="field">
                    <label for="evento_nombre">Nombre del evento</label>
                    <input id="evento_nombre" type="text" name="evento_nombre" placeholder="Ej: Torneo Intercolegial 2026">
                </div>

                <div class="field">
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" required>
                        <option value="" disabled selected hidden>Seleccione categoria...</option>
                        <option value="torneo">Hombres</option>
                        <option value="escuela">Mujeres</option>
                        <option value="interempresas">Infantil</option>
                        <option value="interhinchas">Mixto adultos</option>
                        <option value="recreativa">Mixto infantil</option>
                    </select>
                </div>

                <div class="field full">
                    <label for="descripcion">Descripcion del evento</label>
                    <textarea id="descripcion" name="descripcion" rows="5" placeholder="Describe brevemente el objetivo, numero de participantes, edad aproximada, necesidades (cancha, arbitros, seguridad), etc."></textarea>
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

            <button class="btn" type="button">ENVIAR</button>
        </div>
    </div>

</body>
</html>
