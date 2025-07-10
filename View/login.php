<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Iniciar Sesión</h2>
        <form action="../Controller/UsuarioController.php" method="POST">
            <input type="email" name="email" placeholder="Correo" class="form-control" required>
            <input type="password" name="password" placeholder="Contraseña" class="form-control" required>
            <button type="submit" name="login" class="btn btn-primary mt-2">Ingresar</button>
        </form>
    </div>
</body>
</html>