<?php

function conectar()
{
    try {
        $conex = new PDO("mysql:dbname=tienda;host=localhost", "jefe", "jefe");
        $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conex;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function registrar_clientes($nic, $dni, $nom, $ape, $dir, $loc, $pro, $ema, $tel, $pas)
{
    $conex = conectar();
    $codigo = "INSERT INTO usuarios (rol_usr,nic_usr,dni_usr,nom_usr,ape_usr,dir_usr,loc_usr,pro_usr,
                                     ema_usr,tel_usr,pas_usr,act_usr) 
               VALUES (:rol,:nic,:dni,:nom,:ape,:dir,:loc,:pro,:ema,:tel,:pas,:act);";
    $insert = $conex->prepare($codigo);
    try {
        $fila = $insert->execute(array(
            ':rol' => 2,
            ':nic' => $nic,
            ':dni' => $dni,
            ':nom' => $nom,
            ':ape' => $ape,
            ':dir' => $dir,
            ':loc' => $loc,
            ':pro' => $pro,
            ':ema' => $ema,
            ':tel' => $tel,
            ':pas' => $pas,
            ':act' => 1
        ));

        if ($fila == 1) {
            echo "<br>Registro completado";
        }
    } catch (PDOException $e) {
        echo "<br><span class='error'>Este DNI ya esta registrado</span>";
    }
}

function registrar_categoria($nom)
{
    $conex = conectar();
    $codigo = "INSERT INTO categorias (nom_cat) VALUES (:nom);";
    $insert = $conex->prepare($codigo);
    try {
        $fila = $insert->execute(array(
            ':nom' => $nom
        ));
        if ($fila == 1) {
            echo '<br><span class="correcto">Registro completado correctamente</span>';
        }
    } catch (PDOException $e) {
        echo "<br>Nombre de la categoría utilizado anteriormente";
    }
}

function leer_categoria($cat)
{
    $conex = conectar();
    $codigo = "SELECT nom_cat FROM categorias WHERE id_cat= :cat ";
    $consulta = $conex->prepare($codigo);
    $consulta->bindParam(':cat', $cat, PDO::PARAM_INT);
    $consulta->execute();
    $nombre = $consulta->fetch();
    if (isset($nombre[0]) && $nombre[0] != '') {
        return $nombre[0];
    } else {

        return null;
    }
}

function leer_subcategoria($sub)
{
    $conex = conectar();
    $codigo = "SELECT nom_sub FROM subcategorias WHERE id_sub= :sub ";
    $consulta = $conex->prepare($codigo);
    $consulta->bindParam(':sub', $sub, PDO::PARAM_INT);
    $consulta->execute();
    $nombre = $consulta->fetch();
    if (isset($nombre[0]) && $nombre[0] != '') {
        return $nombre[0];
    } else {
        return null;
    }
}

function registrar_subcategoria($cat, $nom)
{
    $conex = conectar();
    $codigo = "INSERT INTO subcategorias(cat_sub, nom_sub) VALUES (:cat,:nom);";
    $insert = $conex->prepare($codigo);
    try {
        $fila = $insert->execute(array(
            ':cat' => $cat,
            ':nom' => $nom
        ));
        if ($fila == 1) {
            echo '<br><span class="correcto">Registro completado correctamente</span>';
        }
    } catch (PDOException $e) {
        echo "<br>Nombre de la subcategoría utilizado anteriormente";
    }
}

function registrar_articulos($nom, $sub, $cat, $des, $pre)
{
    $conex = conectar();
    $codigo = "INSERT INTO articulos (nom_art,sub_art,cat_art,des_art,pre_art,act_art,sto_art)
               VALUES (:nom,:sub,:cat,:des,:pre,:act,:sto);";
    $insert = $conex->prepare($codigo);
    try {
        $fila = $insert->execute(array(
            ':nom' => $nom,
            ':sub' => $sub,
            ':cat' => $cat,
            ':des' => $des,
            ':pre' => $pre,
            ':act' => '0',
            ':sto' => '0'
        ));

        if ($fila == 1) {
            echo '<br><span class="correcto">Registro completado correctamente</span>';
        }
    } catch (PDOException $e) {
        echo "<br><span class='error'>Error en el registro</span>";
    }
}

function guardar_archivo($img)
{
    $temporal = $_FILES[$img]["tmp_name"];
    $imagen = GetImageSize($temporal);
    if ($imagen[0]==300 && $imagen[1]==300 && $imagen[2]==2){
        $destino = "imgProductos/" . $_FILES["$img"]["name"];
        if (move_uploaded_file($temporal, $destino)) {
            echo "Imagen subida a servidor";
        } else {
            echo "Error en la subida de la imagen";
        }
    }else{
        echo "La imagen no tiene las medidas o el formato correcto";
    }
}

class articulos{
    private $id_art;
    private $nom_art;
    private $sub_art;
    private $cat_art;
    private $des_art;
    private $pre_art;
    private $act_art;
    private $sto_art;
    /**
     * @return mixed
     */
    public function getId_art()
    {
        return $this->id_art;
    }

    /**
     * @return mixed
     */
    public function getNom_art()
    {
        return $this->nom_art;
    }

    /**
     * @return mixed
     */
    public function getSub_art()
    {
        return $this->sub_art;
    }

    /**
     * @return mixed
     */
    public function getCat_art()
    {
        return $this->cat_art;
    }

    /**
     * @return mixed
     */
    public function getDes_art()
    {
        return $this->des_art;
    }

    /**
     * @return mixed
     */
    public function getPre_art()
    {
        return $this->pre_art;
    }

    /**
     * @return mixed
     */
    public function getAct_art()
    {
        return $this->act_art;
    }

    /**
     * @return mixed
     */
    public function getSto_art()
    {
        return $this->sto_art;
    }

    /**
     * @param mixed $id_art
     */
    public function setId_art($id_art)
    {
        $this->id_art = $id_art;
    }

    /**
     * @param mixed $nom_art
     */
    public function setNom_art($nom_art)
    {
        $this->nom_art = $nom_art;
    }

    /**
     * @param mixed $sub_art
     */
    public function setSub_art($sub_art)
    {
        $this->sub_art = $sub_art;
    }

    /**
     * @param mixed $cat_art
     */
    public function setCat_art($cat_art)
    {
        $this->cat_art = $cat_art;
    }

    /**
     * @param mixed $des_art
     */
    public function setDes_art($des_art)
    {
        $this->des_art = $des_art;
    }

    /**
     * @param mixed $pre_art
     */
    public function setPre_art($pre_art)
    {
        $this->pre_art = $pre_art;
    }

    /**
     * @param mixed $act_art
     */
    public function setAct_art($act_art)
    {
        $this->act_art = $act_art;
    }

    /**
     * @param mixed $sto_art
     */
    public function setSto_art($sto_art)
    {
        $this->sto_art = $sto_art;
    }   
}

function mostrar_articulos(){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM articulos  ORDER BY id_art DESC");
    $consulta->execute();
    $consulta->setFetchMode(PDO::FETCH_CLASS, 'articulos');
    while($fila = $consulta->fetch()){
        echo '<div class="col-md-6 col-xl-4"><div><a href="detalleArticulo.php?art='.$fila->getId_art().'">
                <img src="imgProductos/'.$fila->getId_art().'.jpg" width="100" height="100"></a></div><div>'. 
                $fila->getNom_art() . ' ' . $fila->getPre_art().'</div></div>';
    }
}

class usuarios{
    private $id_usr;
    private $dni_usr;
    private $rol_usr;
    private $nic_usr;
    private $nom_usr;
    private $ape_usr;
    private $dir_usr;
    private $cop_usr;
    private $loc_usr;
    private $pro_usr;
    private $ema_usr;
    private $tel_usr;
    private $pas_usr;
    private $act_usr;
    /**
     * @return mixed
     */
    public function getId_usr()
    {
        return $this->id_usr;
    }

    /**
     * @return mixed
     */
    public function getDni_usr()
    {
        return $this->dni_usr;
    }

    /**
     * @return mixed
     */
    public function getRol_usr()
    {
        return $this->rol_usr;
    }

    /**
     * @return mixed
     */
    public function getNic_usr()
    {
        return $this->nic_usr;
    }

    /**
     * @return mixed
     */
    public function getNom_usr()
    {
        return $this->nom_usr;
    }

    /**
     * @return mixed
     */
    public function getApe_usr()
    {
        return $this->ape_usr;
    }

    /**
     * @return mixed
     */
    public function getDir_usr()
    {
        return $this->dir_usr;
    }

    /**
     * @return mixed
     */
    public function getCop_usr()
    {
        return $this->cop_usr;
    }

    /**
     * @return mixed
     */
    public function getLoc_usr()
    {
        return $this->loc_usr;
    }

    /**
     * @return mixed
     */
    public function getPro_usr()
    {
        return $this->pro_usr;
    }

    /**
     * @return mixed
     */
    public function getEma_usr()
    {
        return $this->ema_usr;
    }

    /**
     * @return mixed
     */
    public function getTel_usr()
    {
        return $this->tel_usr;
    }


    /**
     * @return mixed
     */
    public function getPas_usr()
    {
        return $this->pas_usr;
    }

    /**
     * @param mixed $id_usr
     */
    public function setId_usr($id_usr)
    {
        $this->id_usr = $id_usr;
    }

    /**
     * @param mixed $dni_usr
     */
    public function setDni_usr($dni_usr)
    {
        $this->dni_usr = $dni_usr;
    }

    /**
     * @param mixed $rol_usr
     */
    public function setRol_usr($rol_usr)
    {
        $this->rol_usr = $rol_usr;
    }

    /**
     * @param mixed $nic_usr
     */
    public function setNic_usr($nic_usr)
    {
        $this->nic_usr = $nic_usr;
    }

    /**
     * @param mixed $nom_usr
     */
    public function setNom_usr($nom_usr)
    {
        $this->nom_usr = $nom_usr;
    }

    /**
     * @param mixed $ape_usr
     */
    public function setApe_usr($ape_usr)
    {
        $this->ape_usr = $ape_usr;
    }

    /**
     * @param mixed $dir_usr
     */
    public function setDir_usr($dir_usr)
    {
        $this->dir_usr = $dir_usr;
    }

    /**
     * @param mixed $cop_usr
     */
    public function setCop_usr($cop_usr)
    {
        $this->cop_usr = $cop_usr;
    }

    /**
     * @param mixed $loc_usr
     */
    public function setLoc_usr($loc_usr)
    {
        $this->loc_usr = $loc_usr;
    }

    /**
     * @param mixed $pro_usr
     */
    public function setPro_usr($pro_usr)
    {
        $this->pro_usr = $pro_usr;
    }

    /**
     * @param mixed $ema_usr
     */
    public function setEma_usr($ema_usr)
    {
        $this->ema_usr = $ema_usr;
    }

    /**
     * @param mixed $tel_usr
     */
    public function setTel_usr($tel_usr)
    {
        $this->tel_usr = $tel_usr;
    }


    /**
     * @param mixed $pas_usr
     */
    public function setPas_usr($pas_usr)
    {
        $this->pas_usr = $pas_usr;
    }

}



function buscar_usuario($nombre,$password){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM usuarios WHERE nic_usr = :nic");
    $consulta->execute(array(':nic'=>$nombre));
    if($fila = $consulta->fetch()){
        if($fila->getPas_usr()==$password){
            return true;
        }else{
            echo "Password equivocado";
        }
    }else{
        echo "No existe este usuario";
    }
}


?>
