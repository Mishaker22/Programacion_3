
<?php

class Upload
{
    public $extensiones=array("image/jpg", "image/jpeg", "image/png", "image/gif");
    public $_image;
    public $size=900000;
    public $name="imagen";
    public $mensaje="";

    
    
    //Metodo magicos
    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name=$value;
    }
    
    public function Init($imagen,$temp)//,$id)
    {
        echo "entro aqui";

        if($_FILES["imagen"]['size']<= $this->size )
        {
            echo "  entro";
            $error = $_FILES["imagen"]['error'];
            switch($error)
            {
                case 0:
                    if($this->ValidaTipo())
                    {
                        $name="imagen";
                        if($name=="imagen")
                        {
                            $this->AsignarNombre();
                        }
                        $origen=$temp;
                        $destino="img/".$this->name;
                        $subido=move_uploaded_file($origen,$destino);
                        echo "se ha subido: $subido ";
                    }else
                    {
                        echo "Error. Tipo de archivo invalido";
                    }
                break;
                case 3:
                    echo "La imagen no se subió correctamente.";
                break;
                case 4:
                    echo "Debe seleccionar un archivo";
                break;             
            }
        }else
        {
            echo "La imagen es muy pesada.";
        }
        return $this->mensaje;
    }
    public function AsignarNombre() { 
		
		switch($_FILES["imagen"]['type']) {
			case "image/jpg":
			case "image/jpeg":
			$this->extensiones = "jpg";
			break; 
			case "image/gif":
			$this->estensiones = "gif";
			break; 
			case "image/png":
			$this->extensiones = "png";
			break; 
		}
		$this->name = date("Ymdhis").".".$this->extensiones;
	}
    public function ValidaTipo() 
    {
        
        if (in_array(strtolower($_FILES["imagen"]['type']), $this->extensiones))
        {
            return true;
        }
            
	}
}
/*var_dump($_FILES);
$nombreAleatorio=rand(1000,10000);
$extArray=explode('.',$_FILES["archivo"]['name']);
$extension=".png";

$origen=$_FILES['archivo']["tmp_name"];
$destino="img/".$extArray[0].'.'.$nombreAleatorio.$extension;//<--mejor manera.$_FILES["archivo"]['name'].'.'.$nombreAleatorio.$extension;

$subido=move_uploaded_file($origen,$destino);
echo "Subido: $subido";*/
?>