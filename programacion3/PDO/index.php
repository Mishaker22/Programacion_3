<?php 
$numero=$_GET['pNumero'];
try
{
    //se abre la conexion
    $pdo = new PDO('mysql:host=localhost;dbname=utn;charset=utf8', 'root', '');
    //$query=$pdo->query("Select * from productos");
    //$query=$pdo->query("Select * from productos where pNumero=$numero");
    //echo "Filas ", $query->rowCount();//muestra el numero de columnas
    $query=$pdo->prepare("Select * from productos where pNumero=:pNumero");//analiza la base de datos
    $query->bindParam(':pNumero',$numero);
    $resultado=$query->execute();
    var_dump($query->fetchAll()); 
    /*$resultado=$query->fetchAll(); //Trae todo el array de la tabla
    foreach ($resultado as $key => $value) 
    {
        var_dump($value[0]);
        echo $key,' ',$value[0];
    }
    //var_dump($resultado);*/
    //$resultado=$query->fetch();

    while ($fila=$query->fetch(PDO::FETCH_LAZY))//FETCH_CLASS, "Productos" convierte en clase, y debe existor con los mismo atributos
    //mejor para traer cantidad de datos, mas performante
    {
        echo "<br> \n";
        print_r($fila->pNombre);
        echo "<br> \n";
    }

    //$resultado=$query->fetchObject('Producto');//convierte en objeto estandar o de una clase
} catch (\Throwable $th) 
{
    echo $th->getMessage();
}


?> 