<?php
require_once(__DIR__ . '/../../config/Database.php');
class Producto {
    private $id; // id autonumerico
    private $nombreProducto;    
    private $descripcion;
    private $precio;
    private $stock;
    private $imagenUrl; // imagen del producto
    private $categoriaId; // clave foranea a categorias
    private $bd; // copia de la conexion


    public function __construct($nombreProducto, $descripcion, $precio, $stock, $imagenUrl, $categoriaId, $bd, $id=0)
    {
        $this->nombreProducto=$nombreProducto;
        $this->descripcion=$descripcion;
        $this->precio=$precio;
        $this->stock=$stock;
        $this->imagenUrl=$imagenUrl;
        $this->categoriaId=$categoriaId;
        $this->bd=$bd;
        $this->id=$id;
    }
    
    // Opreaciones del CRUD. Se podrian hacer en otra clase
    public static function getProductoPorId($id, $bd){
        $stmt = $bd->prepare("SELECT * FROM productos WHERE id= ?");
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            $producto = new Producto(
                $fila['nombre_producto'],
                $fila['descripcion'],
                $fila['precio'],
                $fila['stock'],
                $fila['imagen_url'],
                $fila['categoria_id'],
                $bd,
                $fila['id'] 
            );
        }
        if (isset($producto)) return $producto;
    }

    public static function getListaProductos($bd) {
        $stmt = $bd->query("SELECT * FROM productos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 

    /** Método de la clase que insert o actualiza un usuario */
    public function guardar() {
        if (isset($this->id) && $this->id != 0) {
            // Actualizar producto existente
            $stmt = $this->bd->prepare("UPDATE productos SET nombre_producto = ?, descripcion = ?, precio = ?, stock = ?, imagen_url = ?, categoria_id = ? WHERE id = ?");
            return $stmt->execute([$this->nombreProducto, $this->descripcion, $this->precio, $this->stock, $this->imagenUrl, $this->categoriaId, $this->id]);
        } else {
            // Insertar nuevo producto
            $stmt = $this->bd->prepare("INSERT INTO productos (nombre_producto, descripcion, precio, stock, imagen_url, categoria_id) VALUES (?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$this->nombreProducto, $this->descripcion, $this->precio, $this->stock, $this->imagenUrl, $this->categoriaId]);
        }
    }
    /**
     * Crearemos la función estática para realizar una búsqueda de productos por nombre
     */
    public static function buscarPorNombre($nombreProducto, $bd) {
        $stmt = $bd->prepare("SELECT * FROM productos WHERE nombre_producto LIKE ?");
        $stmt->execute(['%' . $nombreProducto . '%']);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }
    

    /**
     * Get the value of nombreProducto
     */
    public function getNombreProducto()
    {
        return $this->nombreProducto;
    }

    /**
     * Set the value of nombreProducto
     */
    public function setNombreProducto($nombreProducto): self
    {
        $this->nombreProducto = $nombreProducto;

        return $this;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion($descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio($precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the value of stock
     */
    public function setStock($stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get the value of imagenUrl
     */
    public function getImagenUrl()
    {
        return $this->imagenUrl;
    }

    /**
     * Set the value of imagenUrl
     */
    public function setImagenUrl($imagenUrl): self
    {
        $this->imagenUrl = $imagenUrl;

        return $this;
    }

    /**
     * Get the value of categoriaId
     */
    public function getCategoriaId()
    {
        return $this->categoriaId;
    }

    /**
     * Set the value of categoriaId
     */
    public function setCategoriaId($categoriaId): self
    {
        $this->categoriaId = $categoriaId;

        return $this;
    }
}
