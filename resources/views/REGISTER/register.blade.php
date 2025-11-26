<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro de Eventos Deportivos</title>

  <!-- Bootstrap 5 CDN -->
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet"
  />

  <style>
    body{
      background: #f5f7fb;
    }
    .hero{
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
      color: white;
      border-radius: 1.5rem;
    }
    .card{
      border: 0;
      border-radius: 1.25rem;
    }
    .shadow-soft{
      box-shadow: 0 8px 24px rgba(0,0,0,.06);
    }
    .icon-circle{
      width: 54px;
      height: 54px;
      display: grid;
      place-items: center;
      border-radius: 50%;
      background: #eef3ff;
      font-size: 1.4rem;
    }
  </style>
</head>

<body>

  <div class="container py-5">

    <!-- Encabezado / Hero -->
    <section class="hero p-5 shadow-soft mb-5 text-center">
      <h1 class="fw-bold display-6 mb-2">Registro de Eventos Deportivos</h1>
      <p class="fs-5 mb-0 opacity-75">
        Gestiona competencias, crea eventos y registra participantes de forma rápida y organizada.
      </p>
    </section>

    <div class="row g-4">

      <!-- Panel principal -->
      <div class="col-lg-8">
        <div class="card shadow-soft">
          <div class="card-body p-4 p-md-5">

            <h3 class="fw-semibold mb-2">👋 Bienvenido</h3>
            <p class="text-muted mb-4">
              Desde este panel podrás crear eventos, administrar torneos y revisar inscripciones.
            </p>

            <div class="row g-3">

              <div class="col-md-4">
                <div class="card shadow-sm h-100">
                  <div class="card-body">
                    <div class="icon-circle mb-3">🏟️</div>
                    <h5 class="fw-bold">Crear evento</h5>
                    <p class="text-muted small">
                      Registra nuevas competencias con fecha, lugar y categorías.
                    </p>
                    <a href="#" class="btn btn-primary w-100">Nuevo evento</a>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="card shadow-sm h-100">
                  <div class="card-body">
                    <div class="icon-circle mb-3">📅</div>
                    <h5 class="fw-bold">Ver eventos</h5>
                    <p class="text-muted small">
                      Consulta el calendario y el estado de inscripciones.
                    </p>
                    <a href="#" class="btn btn-outline-secondary w-100">Calendario</a>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="card shadow-sm h-100">
                  <div class="card-body">
                    <div class="icon-circle mb-3">👥</div>
                    <h5 class="fw-bold">Participantes</h5>
                    <p class="text-muted small">
                      Administra equipos, atletas y categorías inscritas.
                    </p>
                    <a href="#" class="btn btn-outline-success w-100">Gestionar</a>
                  </div>
                </div>
              </div>

            </div>

            <!-- Tabla ejemplo -->
            <hr class="my-5">

            <h4 class="fw-semibold mb-3">Próximos eventos</h4>
            <div class="table-responsive">
              <table class="table table-hover align-middle bg-white rounded-3 overflow-hidden">
                <thead class="table-light">
                  <tr>
                    <th>Evento</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Torneo Regional de Fútbol</td>
                    <td>12 Dic 2025</td>
                    <td>Estadio Central</td>
                    <td><span class="badge bg-success">Inscripciones abiertas</span></td>
                  </tr>
                  <tr>
                    <td>Carrera 10K Ciudad</td>
                    <td>20 Ene 2026</td>
                    <td>Parque Principal</td>
                    <td><span class="badge bg-warning text-dark">Próximo</span></td>
                  </tr>
                  <tr>
                    <td>Liga de Baloncesto</td>
                    <td>05 Feb 2026</td>
                    <td>Coliseo Norte</td>
                    <td><span class="badge bg-secondary">En preparación</span></td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

      <!-- Panel lateral usuario -->
      <div class="col-lg-4">
        <div class="card shadow-soft">
          <div class="card-body p-4 text-center">

            <img
              src="https://ui-avatars.com/api/?name=Usuario+Deportivo&background=0D6EFD&color=fff"
              class="rounded-circle shadow mb-3"
              width="90"
              height="90"
              alt="avatar"
            />

            <h5 class="fw-bold mb-0">Usuario Deportivo</h5>
            <small class="text-muted">usuario@email.com</small>

            <hr class="my-4">

            <button class="btn btn-danger w-100">
              Cerrar sesión
            </button>

            <p class="small text-muted mt-3 mb-0">
              Sistema de administración de eventos deportivos v1.0
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
