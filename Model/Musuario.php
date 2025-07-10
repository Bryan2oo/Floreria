<?php
class MUsuario {
    private $conexion;

    public function __construct() {
        include("../Config/conexion.php");
        $this->conexion = $conectBd;
    }

    public function crearUsuario($nombre_completo, $correo, $telefono, $direccion, $contrasena) {
        // Validar si el correo ya existe
        $sql = "SELECT id FROM clientes WHERE correo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return "El correo electrónico ya está registrado.";
        }

        // Hashear la contraseña
        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);

        // Insertar el nuevo cliente
        $sql = "INSERT INTO clientes (nombre_completo, correo, telefono, direccion, contrasena) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssss", $nombre_completo, $correo, $telefono, $direccion, $contrasenaHash);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Error al registrar el usuario: " . $this->conexion->error;
        }
    }

    public function validarAdmin($correo, $contrasena) {
        $sql = "SELECT contrasena FROM administrador WHERE correo = ?";
        $stmt = $this->conexion->prepare($sql);
    
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conexion->error);
        }
    
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows == 1) {
            $admin = $resultado->fetch_assoc();
            // Comparar contraseña (sin hash según tu estructura)
            if ($contrasena === $admin["contrasena"]) {
                return true;
            } else {
                return "clave_incorrecta";
            }
        } else {
            return "correo_incorrecto";
        }
    }

    public function verificarUsuario($correo, $contrasena) {
        $sql = "SELECT id, contrasena FROM clientes WHERE correo = ?";
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            return "Error en la consulta: " . $this->conexion->error;
        }
        
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            if (password_verify($contrasena, $usuario['contrasena'])) {
                return true;
            } else {
                return "Contraseña incorrecta";
            }
        } else {
            return "Correo no registrado";
        }
    }

    public function solicitarRecuperacion($correo) {
        $sql = "SELECT id FROM clientes WHERE correo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows == 1) {
            $token = bin2hex(random_bytes(50));
            $expiracion = date("Y-m-d H:i:s", strtotime("+1 hour"));
    
            // Necesitarías añadir estos campos a tu tabla clientes:
            // ALTER TABLE clientes ADD COLUMN token_recuperacion VARCHAR(100);
            // ALTER TABLE clientes ADD COLUMN token_expiracion DATETIME;
            $sql = "UPDATE clientes SET token_recuperacion = ?, token_expiracion = ? WHERE correo = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sss", $token, $expiracion, $correo);
            
            if ($stmt->execute()) {
                return $token; // Devuelve el token para el enlace
            }
        }
        return false;
    }

    public function restablecerContraseña($token, $nuevaContrasena) {
        // Verificar token válido
        $sql = "SELECT id FROM clientes WHERE token_recuperacion = ? AND token_expiracion > NOW()";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows == 1) {
            $hash = password_hash($nuevaContrasena, PASSWORD_BCRYPT);
            $sql = "UPDATE clientes SET contrasena = ?, token_recuperacion = NULL, token_expiracion = NULL WHERE token_recuperacion = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ss", $hash, $token);
            return $stmt->execute();
        }
        return false;
    }

    public function obtenerIdPorEmail($correo) {
        $sql = "SELECT id FROM clientes WHERE correo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["id"];
        }
        return false;
    }
    
    public function obtenerPorCorreo($correo) {
    $sql = "SELECT id, nombre_completo AS nombre, correo FROM clientes WHERE correo = ?";
    $stmt = $this->conexion->prepare($sql);
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        return $resultado->fetch_assoc();
    } else {
        return null; // No encontrado
    }
}

}
?>