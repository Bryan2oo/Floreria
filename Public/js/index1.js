        // Función para confirmar la salida de la sesión
        function confirmLogout() {
            var confirmacion = confirm("¿Estás seguro de que deseas cerrar sesión?");
            if (confirmacion) {
                window.location.href = '../IndexP.php';
            }
        }

        // Función para confirmar la salida del sitio
        function confirmExit() {
            var confirmacion = confirm("¿Seguro que deseas salir?");
            if (confirmacion) {
                window.location.href = '../IndexP.php';
            }
        }
