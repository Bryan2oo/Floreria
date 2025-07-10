<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de Font Awesome para el ojo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Public/css/stylesNav.css">
    <link rel="stylesheet" href="../Public/css/stylesLog.css">
    <link rel="stylesheet" href="../Public/css/stylesFondo.css">
    <link rel="stylesheet" href="../Public/css/stylesOjo.css">
</head>
<body>
    <?php
        // Configuración de visibilidad de botones
        $showOrderButton = false;
        $showAccountButton = false;
        $showLogoutButton = false;
        $showExitButton = true;
        include("../Model/MMenuNav.php"); 
    ?>

    <div class="login-container">
        <div class="login-header">
            <h1>Acceso Administrador</h1>
        </div>

        <?php if(isset($error)): ?>
            <div class="error-message alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="../Controller/CAdminLogin.php">
            <div class="form-group">
                <input type="email" name="Correo" placeholder="Correo electrónico" 
                       value="<?php echo isset($correo_guardado) ? htmlspecialchars($correo_guardado) : ''; ?>" required>
            </div>
            <div class="form-group password-container">
                <input type="password" name="Clave" id="passwordField" placeholder="Contraseña" required>
                <span class="password-toggle" id="togglePassword">
                    <i class="far fa-eye"></i>
                </span>
            </div>

            <button type="submit" class="login-button">Ingresar</button>
        </form>
    </div>

    <script>
        // Función para mostrar/ocultar contraseña
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('passwordField');
            const icon = this.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>