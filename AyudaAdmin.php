<?php
// AyudaAdmin.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ayuda - Administrador</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f9f9f9; }
        h1 { color: #2d6a4f; }
        section { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px #ccc; margin-bottom: 20px; }
        ul { margin-left: 20px; }
        .ayuda-img { max-width: 400px; display: block; margin: 10px 0; border-radius: 6px; box-shadow: 0 1px 4px #bbb; }
        .paso { margin-bottom: 18px; }
        .nota { background: #e9f5e1; padding: 10px; border-left: 4px solid #2d6a4f; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Ayuda para Administradores</h1>

    <section>
        <h2>Introducción</h2>
        <p>
            Esta ayuda está basada en las funcionalidades actualmente implementadas en el sistema de administración de la florería. Aquí encontrarás una explicación detallada de cada sección y cómo utilizar el panel de administrador.
        </p>
    </section>

    <section>
        <h2>Menú de Navegación</h2>
        <div class="paso">
            El <b>menú de navegación</b> (nav) se encuentra generalmente en la parte superior o lateral de la pantalla y te permite acceder rápidamente a las diferentes secciones del sistema:<br>
            <img src="img/menu_nav.png" alt="Menú de Navegación" class="ayuda-img">
            <ul>
                <li><b>Inicio:</b> Acceso al panel principal con el resumen general.</li>
                <li><b>Productos:</b> Gestión de productos (agregar, editar, eliminar).</li>
                <li><b>Pedidos:</b> Visualización y administración de pedidos.</li>
                <li><b>Usuarios:</b> Administración de usuarios registrados.</li>
                <li><b>Reportes:</b> Acceso a reportes y estadísticas.</li>
                <li><b>Configuración:</b> Modificación de parámetros generales del sistema.</li>
                <li><b>Perfil/Cerrar sesión:</b> Opciones para ver tu perfil o cerrar sesión de forma segura.</li>
            </ul>
        </div>
        <div class="nota">
            <b>Nota:</b> El menú puede variar ligeramente según los permisos del usuario o las personalizaciones realizadas.
        </div>
    </section>

    <section>
        <h2>1. Panel de Inicio</h2>
        <div class="paso">
            Al ingresar como administrador, verás el <b>Panel de Inicio</b> con un resumen de la actividad reciente, estadísticas de ventas y accesos rápidos.<br>
            <img src="img/panel_inicio.png" alt="Panel de Inicio" class="ayuda-img">
        </div>
        <div class="nota">
            <b>Nota:</b> Desde aquí puedes acceder rápidamente a las secciones principales del sistema.
        </div>
    </section>

    <section>
        <h2>2. Gestión de Productos</h2>
        <div class="paso">
            En la sección <b>Productos</b> puedes:
            <ul>
                <li>Agregar nuevos productos (nombre, descripción, precio, imagen, stock).</li>
                <li>Editar información de productos existentes.</li>
                <li>Eliminar productos que ya no estén disponibles.</li>
            </ul>
            <img src="img/gestion_productos.png" alt="Gestión de Productos" class="ayuda-img">
        </div>
        <div class="nota">
            <b>Consejo:</b> Mantén actualizada la información y las imágenes para mejorar la experiencia del cliente.
        </div>
    </section>

    <section>
        <h2>3. Administración de Pedidos</h2>
        <div class="paso">
            En la sección <b>Pedidos</b> puedes:
            <ul>
                <li>Ver el listado de pedidos realizados.</li>
                <li>Consultar detalles de cada pedido (cliente, productos, estado, fecha).</li>
                <li>Actualizar el estado del pedido (pendiente, en proceso, entregado, cancelado).</li>
            </ul>
            <img src="img/gestion_pedidos.png" alt="Gestión de Pedidos" class="ayuda-img">
        </div>
        <div class="nota">
            <b>Nota:</b> Es importante actualizar el estado de los pedidos para mantener informados a los clientes.
        </div>
    </section>

    <section>
        <h2>4. Administración de Usuarios</h2>
        <div class="paso">
            Desde la sección <b>Usuarios</b> puedes:
            <ul>
                <li>Ver la lista de usuarios registrados.</li>
                <li>Editar información de usuarios (nombre, correo, permisos).</li>
                <li>Eliminar usuarios si es necesario.</li>
            </ul>
            <img src="img/gestion_usuarios.png" alt="Gestión de Usuarios" class="ayuda-img">
        </div>
        <div class="nota">
            <b>Importante:</b> Solo los administradores con permisos pueden modificar o eliminar usuarios.
        </div>
    </section>

    <section>
        <h2>5. Reportes y Estadísticas</h2>
        <div class="paso">
            En la sección <b>Reportes</b> puedes:
            <ul>
                <li>Visualizar reportes de ventas por periodo.</li>
                <li>Consultar estadísticas de productos más vendidos.</li>
                <li>Exportar reportes en formatos PDF o Excel.</li>
            </ul>
            <img src="img/reportes.png" alt="Reportes y Estadísticas" class="ayuda-img">
        </div>
        <div class="nota">
            <b>Consejo:</b> Utiliza los reportes para tomar decisiones informadas sobre inventario y promociones.
        </div>
    </section>

    <section>
        <h2>6. Configuración del Sistema</h2>
        <div class="paso">
            En <b>Configuración</b> puedes modificar parámetros generales como:
            <ul>
                <li>Datos de la empresa (nombre, dirección, contacto).</li>
                <li>Opciones de pago y envío.</li>
                <li>Personalización de mensajes y notificaciones.</li>
            </ul>
            <img src="img/configuracion.png" alt="Configuración del Sistema" class="ayuda-img">
        </div>
        <div class="nota">
            <b>Nota:</b> Realiza cambios con precaución, ya que pueden afectar el funcionamiento general del sistema.
        </div>
    </section>

    <section>
        <h2>7. Perfil y Cerrar Sesión</h2>
        <div class="paso">
            Desde el menú de usuario puedes:
            <ul>
                <li>Ver y editar tu perfil (nombre, correo, contraseña).</li>
                <li>Cerrar sesión de forma segura.</li>
            </ul>
            <img src="img/perfil.png" alt="Perfil de Usuario" class="ayuda-img">
        </div>
        <div class="nota">
            <b>Recomendación:</b> Cambia tu contraseña periódicamente para mayor seguridad.
        </div>
    </section>

    <section>
        <h2>8. Soporte</h2>
        <p>Si tienes dudas o problemas, contacta al equipo de soporte técnico al correo <a href="mailto:soporte@floreria.com">soporte@floreria.com</a>.</p>
    </section>
