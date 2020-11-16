
<?php

class Upload
{
    public $extensiones=array("image/jpg", "image/jpeg", "image/png", "image/gif");
    public $_image;
    public $size=900000;
    public $name="imagen";

    //Metodo magicos
    public function __get($var)
    {
        return $this->$var;
    }
    public function __set($var, $value)
    {
        $this->$var=$value;
    }
    
    public function Init($imagen,$temp)//,$id)
    {

        if($_FILES["imagen"]['size']<= $this->size )
        {
            //echo "  entro";
            $error = $_FILES["imagen"]['error'];
            switch($error)
            {
                case 0:
                    if($this->ValidaTipo())
                    {
                        if($this->name=="imagen")
                        {
                            $this->AsignarNombre();
                        }
                        $origen=$temp;
                        $folder="img/";
                        $destino=$folder.$this->name;
                        $subido=move_uploaded_file($origen,$destino);
                        echo "se ha subido la imagen: $subido ","\n";
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
        return $folder.$this->name;
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
    public function Move()
    {
        //echo $name;
        if(copy("img/20200929081846.jpg","backup/20200929081846.jpg"))
        {
            unlink("img/20200929081846.jpg");
        }
    }
}

?>