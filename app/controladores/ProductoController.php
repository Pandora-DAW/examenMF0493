<?php
require_once(__DIR__ . '/../modelos/Producto.php');
    class ProductoController {
        private $bd;

        public function __construct($bd) {
            $this->bd=$bd;
        }

        /**
         * Funcion del controlador que muestra el listado de productos
         */
        public function mostrar_productos() {
            $vista = __DIR__ . '/../vistas/productos/listado.php';
            $productos = []; // Inicializar el array de productos
            // Obtener los productos de la base de datos
            $productos = Producto::getListaProductos($this->bd);
            require(__DIR__ . '/../vistas/layout.php');
        }

        /**
         * Funcion del controlador que muestra el formulario para incluir un nuevo producto
         */
        public function mostrar_formulario() {
            $vista = __DIR__ . '/../vistas/productos/nuevo.php';
            // Obtenemos las categorías para el select
            require_once(__DIR__ . '/../modelos/Categoria.php');    
            $categorias = Categoria::getListaCategorias($this->bd);
            require(__DIR__ . '/../vistas/layout.php');
        }

        // método del controlador que se encarga de procesar el formulario de nuevo producto app/vistas/productos/nuevo.php
        public function registrar_producto() {
            // Recoger los datos del formulario
            $nombreProducto = $_POST['nombre_producto'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $categoriaId = $_POST['categoria_id'];

            // Manejar la subida de la imagen
            $imagen_url = null;
            if (isset($_FILES['imagen_url']) && $_FILES['imagen_url']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/assests/';
                $nombreArchivo = uniqid() . '_' . basename($_FILES['imagen_url']['name']);
                $uploadFile = $uploadDir . $nombreArchivo;
                if (move_uploaded_file($_FILES['imagen_url']['tmp_name'], $uploadFile)) {
                    $imagen_url = $nombreArchivo;
                }
            }

            // Crear el producto y guardarlo en la base de datos
            require_once(__DIR__ . '/../modelos/Producto.php');
            $producto = new Producto(
                $nombreProducto,
                $descripcion,
                $precio,
                $stock,
                $imagen_url,
                $categoriaId,
                $this->bd,
                0
            );

            // Guardar en la base de datos
            if ($producto->guardar()>0) {
                header('Location: ' . BASE_URL . '/productos/listado');
                exit;
            } else {
                $error = "No se pudo guardar el producto." . $bd->errorInfo()[2];
                $vista = __DIR__ . '/../vistas/productos/nuevo.php';
                require(__DIR__ . '/../vistas/layout.php');
            }
        }

        public function mostrar_detalle($id) {
            // Obtener el producto por su id
            $producto = Producto::getProductoPorId($this->bd, $id);

            // Si no existe, mostrar error o redirigir
            if (!$producto) {
                $vista = __DIR__ . '/../vistas/productos/listado.php';
                $error = "Producto no encontrado.";
                require(__DIR__ . '/../vistas/layout.php');
                return;
            }

            // Mostrar la vista de detalle
            $vista = __DIR__ . '/../vistas/productos/detalle.php';
            require(__DIR__ . '/../vistas/layout.php');
        }

    }
?>