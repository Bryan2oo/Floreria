# 🌻 Florería J&A - Sistema Web

Este repositorio contiene el código fuente del sistema web para la Florería J&A, un proyecto académico desarrollado bajo la firma CodeFlowers S.A. 

La plataforma es una aplicación web basada en el patrón de arquitectura Modelo-Vista-Controlador (MVC). Su propósito principal es centralizar y automatizar los ciclos operativos del negocio, optimizando la gestión de inventarios, el manejo de perfiles de clientes y el seguimiento de pedidos en tiempo real[cite: 15, 16, 17]. [cite_start]Al desacoplar la lógica de negocio de la interfaz de usuario, el sistema garantiza una operación escalable, estable y robusta.

## 🚀 Características Principales

El sistema está dividido en dos grandes módulos con funcionalidades específicas:

### 👤 Módulo de Cliente
* Registro y Acceso Seguro:** Creación de cuentas y login utilizando correos electrónicos y contraseñas fuertemente encriptadas (algoritmo bcrypt) para garantizar la privacidad de los datos.
* Catálogo Dinámico:** Visualización de arreglos florales y productos con cálculo automático de precios finales cuando existen descuentos activos por festividades.
* Búsqueda Optimizada:** Herramienta de búsqueda rápida por ID o nombre del producto, arrojando resultados en menos de 1 segundo.
* Carrito de Compras Inteligente:** Gestión del carrito con un sistema de verificación automática que comprueba la disponibilidad física de las flores en el inventario antes de procesar la reserva.

### 🛠️ Módulo de Administrador
* Panel de Control Exclusivo:** Acceso restringido únicamente para el personal autorizado del negocio.
* Gestión de Inventario (CRUD):** Capacidad para agregar, modificar o eliminar productos, subir fotografías, actualizar precios, categorizar arreglos y gestionar el stock disponible.
* Seguimiento de Pedidos:** Visualización y actualización manual del estado logístico de cada pedido (Pendiente, Reservado, Completado, Cancelado).
* Generación de Reportes:** Creación y descarga de informes de ventas e inventario en formato PDF, parametrizables por cliente, periodo o montos de compra.

## 💻 Tecnologías y Arquitectura

El ecosistema del proyecto hace uso de tecnologías de código abierto y herramientas gratuitas:

* Backend:** PHP 8.x [cite: 142]
* Arquitectura:** MVC (Modelo-Vista-Controlador) 
* Base de Datos:** MySQL (Relacional) 
* Frontend:** HTML5, CSS3 y Bootstrap 5 (Diseño 100% responsivo para móviles, tablets y escritorio) 
* Librerías Adicionales:** FPDF (Para la generación de reportes) 
* Entorno Local:** Compatible con servidores Apache vía XAMPP o WAMP 

## ⚙️ Instalación y Configuración Local

1. Clona este repositorio en tu máquina local:
   ```bash
   git clone [https://github.com/Bryan2oo/Floreria.git](https://github.com/Bryan2oo/Floreria.git)
