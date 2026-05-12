<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
            <h1>Registro</h1>
        </div>

        <?php if(isset($error)): ?>
            <div class="error-message alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if(isset($success)): ?>
            <div class="success-message alert alert-success">
                <?php echo $success; ?>
            </div>
            <div class="form-group">
                <button onclick="window.location.href='../View/VSesionD.php'" class="login-button">Iniciar Sesión</button>
            </div>
        <?php else: ?>
            <form method="POST" action="../Controller/CRegistro.php">
                <div class="form-group">
                    <input type="text" name="Nombre" placeholder="Nombre completo" required>
                </div>
                <div class="form-group">
                    <input type="email" name="Correo" placeholder="Correo electrónico" required>
                </div>
                <div class="form-group">
                    <input type="text" name="Telefono" placeholder="Teléfono" required>
                </div>
                <div class="form-group">
                    <input type="text" name="Direccion" placeholder="Dirección" required>
                </div>
                
                <!-- Campo de contraseña con ojo -->
                <div class="form-group password-container">
                    <input type="password" name="Clave" id="passwordField" placeholder="Contraseña" required>
                    <span class="password-toggle" onclick="togglePassword('passwordField', 'togglePassword')">
                        <i class="fas fa-eye" id="togglePassword"></i>
                    </span>
                </div>
                
                <!-- Campo de confirmación de contraseña con ojo -->
                <div class="form-group password-container">
                    <input type="password" name="ConfirmarClave" id="confirmPasswordField" placeholder="Confirmar contraseña" required>
                    <span class="password-toggle" onclick="togglePassword('confirmPasswordField', 'toggleConfirmPassword')">
                        <i class="fas fa-eye" id="toggleConfirmPassword"></i>
                    </span>
                </div>

                <div class="form-group">
                    <button type="submit" class="login-button">Registrarse</button>
                </div>
            </form>

            <div class="login-register">
                <a href="../View/VSesionD.php" class="create-account">¿Ya tienes una cuenta? Inicia sesión</a> 
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Función para mostrar/ocultar contraseña
        function togglePassword(fieldId, toggleId) {
            const passwordField = document.getElementById(fieldId);
            const icon = document.getElementById(toggleId);
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>