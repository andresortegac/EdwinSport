<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Edwin Sport</title>

    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS personalizado -->
     <link rel="stylesheet" href="{{ asset('/principal.css') }}">
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="card p-4 shadow-lg login-card">

            <div class="text-center mb-4">
                <img src="{{ asset('img/img2.png') }}" width="370" alt="Logo Empresa">
                
            </div>

            <form>

                <!-- Campo Usuario -->
                <div class="form-group mb-3">
                    <label for="usuario" class="form-label">Admin</label>
                    <input type="text" class="form-control" id="usuario" placeholder="Ingrese Admin">
                </div>

                <!-- Campo Contraseña con ojito -->
                <div class="form-group mb-3 position-relative">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Ingrese contraseña">
                    
                    <span class="toggle-password" onclick="togglePassword()">
                        👁️‍🗨️ 
                    </span>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">
                    Iniciar
                </button>

            </form>

        </div>
    </div>

    <!-- Script para el ojito -->
    <script>
        function togglePassword() {
            const password = document.getElementById("password");
            password.type = password.type === "password" ? "text" : "password";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
