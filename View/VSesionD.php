<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../Public/css/stylesNav.css">
    <link rel="stylesheet" href="../Public/css/stylesLog.css">
    <link rel="stylesheet" href="../Public/css/stylesFondo.css">
    <link rel="stylesheet" href="../Public/css/stylesOjo.css">
</head>
<body>
    <?php 
        $showOrderButton = false;
        $showAccountButton = false;
        $showLogoutButton = false;
        $showExitButton = true;
        include("../Model/MMenuNav.php"); 
    ?>

    <div class="login-container">
        <div class="login-header">
            <h1>Iniciar sesión</h1>
        </div>

        <?php if(isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="../Controller/CIniciarSesion.php">
            <div class="form-group">
                <input type="email" name="Correo" placeholder="Correo electrónico" 
                       value="<?php echo isset($_SESSION['correo_ingresado']) ? $_SESSION['correo_ingresado'] : ''; ?>" required>
            </div>
            <div class="form-group password-container">
                <input type="password" name="Clave" id="passwordField" class="password-input" placeholder="Contraseña" required>
                <span class="password-toggle" id="togglePassword">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <button type="submit" class="login-button">Iniciar sesión</button>
        </form>

        <div class="login-register">
            <a href="VRegistro.php" class="create-account">Crear nueva cuenta</a> 
        </div>
    </div>

    <script>
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