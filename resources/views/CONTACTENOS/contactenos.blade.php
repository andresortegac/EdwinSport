<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="{{ asset('/CSS/contactenos.css') }}">

        <title>Crear un evento</title>

    </head>

    <body>

        <div class="wrap">
            <h1 class="hero-title">CONTACTENOS</h1>

            <div class="card" role="form" aria-label="Formulario reservar cita">
                <div class="field">
                    <label for="tipo">Tipo de solicitante</label>
                    <select id="tipo" name="tipo">
                        <option value="">Seleccione...</option>
                        <option value="natural">Persona Natural</option>
                        <option value="empresa">Empresa</option>
                        <option value="escuela">Escuela Deportiva</option>
                        <option value="institucion">Institución Deportiva</option>
                    </select>
                </div>

                <!-- DATOS PERSONA NATURAL -->
                <div id="naturalFields" class="field">
                    <label>Nombres y apellidos</label>
                    <input type="text" name="nombre_completo">

                    <label>Documento de identidad</label>
                    <input type="text" name="documento">

                    <label>Teléfono</label>
                    <input type="text" name="telefono_natural">
                </div>

                <!-- DATOS EMPRESA / ESCUELA / INSTITUCIÓN -->
                <div id="empresaFields" class="hidden">
                    <label>Nombre de la entidad</label>
                    <input type="text" name="razon_social">

                    <label>NIT / Registro</label>
                    <input type="text" name="nit">

                    <label>Representante</label>
                    <input type="text" name="representante">

                    <label>Teléfono de contacto</label>
                    <input type="text" name="telefono_empresa">
                </div>

                <!-- SECCIÓN 2 ? Información del Evento -->
                <h3>Información del evento</h3>

                <label>Nombre del evento</label>
                <input type="text" name="evento_nombre">

                <label>Categoría</label>
                <select name="categoria">
                    <option value="">Seleccione...</option>
                    <option>Torneo deportivo</option>
                    <option>Escuela deportiva</option>
                    <option>Interempresas</option>
                    <option>Interhinchas</option>
                    <option>Actividad recreativa</option>
                </select>

                <label>Descripción del evento</label>
                <textarea name="descripcion" rows="5"></textarea>

                <label>Fecha del evento</label>
                <input type="date" name="fecha_evento">

                <!-- Adjuntar imágenes -->
                <label>Adjuntar imágenes del evento (opcional)</label>
                <input type="file" name="imagenes[]" multiple accept="image/*">

                <!-- SECCIÓN 3 ? Mensaje general -->
                <h3>Mensaje adicional</h3>

                <textarea name="mensaje" rows="4" placeholder="Escriba un mensaje adicional / solicitud"></textarea>

                <button class="btn" type="button">ENVIAR</button>
            </div>
        </div>

        <script>
            const tipo = document.getElementById("tipo");
            const naturalFields = document.getElementById("naturalFields");
            const empresaFields = document.getElementById("empresaFields");

            tipo.addEventListener("change", function() {
                naturalFields.classList.add("hidden");
                empresaFields.classList.add("hidden");

                if (this.value === "natural") {
                    naturalFields.classList.remove("hidden");
                } else if (this.value === "empresa" || this.value === "escuela" || this.value === "institucion") {
                    empresaFields.classList.remove("hidden");
                }
            });
        </script>
    </body>
</html>

