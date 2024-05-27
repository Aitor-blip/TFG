<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'desirecloset';
    private $username = 'root';
    private $password = 'aitor2002';
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }


    public  function getIdRolByEmailUser($email){
        try{
            $sql="SELECT idRol FROM usuarios_roles inner join Usuarios on usuarios.idUsuario= usuarios_roles.idUsuario where usuarios.email='$email'; ";
            $consulta = $this->conn->prepare($sql);
            $consulta->execute();
            return $consulta->fetch(PDO::FETCH_LAZY)['idRol'];
        }catch(PDOException $e){
            echo $e->getMessage();
        } 
    }

    public  function getRutaFotoByIdProducto($id){
        try{
            $sql="SELECT nombreFoto FROM fotos inner join productos on productos.idProducto= fotos.idProducto where fotos.idProducto=$id";
            $consulta = $this->conn->prepare($sql);
            $consulta->execute();
            return $consulta->fetch(PDO::FETCH_LAZY)['nombreFoto'];
        }catch(PDOException $e){
            echo $e->getMessage();
        } 
    }

}

?>
