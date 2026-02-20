<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | Sistema de Inscripciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="fondo-ibero">

<div class="container vh-100 d-flex justify-content-center align-items-center">

    <div class="card shadow-lg" style="width: 100%; max-width: 420px;">
        <div class="card-body p-4">

            <h3 class="text-center mb-3">Preparatoria Iberoamericana</h3>
            <p class="text-center text-muted mb-4">
                Sistema de Inscripciones Escolares
            </p>

            <!-- FORMULARIO ÚNICO -->
            <form action="login-process.php" method="POST">

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email"
                           name="correo"
                           class="form-control"
                           placeholder="correo@ibero.edu.mx"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="********"
                           required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        Iniciar Sesión
                    </button>
                </div>

            </form>

            <!-- AVISO -->
            <div class="alert alert-info text-center mt-4 mb-3">
                Para obtener acceso al sistema, dirígete a la institución para que se te asigne el correo electrónico y la contraseña correspondientes.
            </div>

            <hr>

            <!-- ACCESO ADMIN -->
            <div class="text-center">
                <a href="login.php" class="text-decoration-none">
                    Iniciar sesión como administrador
                </a>
            </div>

            <p class="text-center mt-3 mb-0 text-muted">
                © 2026 Preparatoria Iberoamericana
            </p>

        </div>
    </div>

</div>

</body>
</html>