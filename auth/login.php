<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="fondo-ibero">
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow-lg" style="width: 100%; max-width: 420px;">
        <div class="card-body p-4">
            <h4 class="text-center mb-3">Acceso Administrador</h4>

            <form action="login-process.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Correo institucional</label>
                    <input type="email" name="correo" class="form-control"
                           placeholder="admin@ibero.edu.mx" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary">
                        Iniciar sesión
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<p class="text-center mt-3 mb-0 text-muted">
    © 2026 Preparatoria Iberoamericana
</p>
</body>
</html>