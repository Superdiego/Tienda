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
        if(preg_match("/dni_usr'$/",$e->getMessage())){
        echo  "Este DNI ya esta registrado";
        }else if(preg_match("/nic_usr'$/",$e->getMessage())){
            echo "Este nick ya esta en uso, pruebe otro";
        }
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
     * @param mixed
     */
    public function getAct_usr()
    {
        return $this->act_usr;
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
    /**
     * @param mixed $act_usr
     */
    public function setAct_usr($act_usr)
    {
        $this->act_usr = $act_usr;
    }

}
function buscar_usuario($nombre,$password){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM usuarios WHERE nic_usr = :nic");
    $consulta->execute(array(':nic'=>$nombre));
    $consulta->setFetchMode(PDO::FETCH_CLASS, "usuarios");
    if($fila = $consulta->fetch()){
        if($fila->getPas_usr()==$password  && $fila->getAct_usr()){
            if($fila->getRol_usr()==2){
                return 0;
            }else if($fila->getRol_usr()==3){
                return 3;
            }else if($fila->getRol_usr()==4){
                return 4;
            }else{
                return 5;
            }
        }else{
            return 1;
        }
    }else{
        return 2;
    }
}
function datos_usuario($nombre){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM usuarios WHERE nic_usr = :nic");
    $consulta->execute(array(':nic'=>$nombre));
    $consulta->setFetchMode(PDO::FETCH_CLASS, "usuarios");
    if($fila = $consulta->fetch()){
        return $fila;
    }else{
        return false;
    }
}
function mostrar_usuario(){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM usuarios");
    $consulta->execute();
    $consulta->setFetchMode(PDO::FETCH_CLASS, "usuarios");
    while($fila = $consulta->fetch()){
        echo "<form method='POST' action='adminusers.php'>
            <tr><th scope='row'><input type='text' style='width:3em' name='id' value='".$fila->getId_usr()."'></th>
            <td><input type='text' size='9' name='dni' value='".$fila->getDni_usr()."'></td>
            <td><input type='text' size='1' name='rol' value='".$fila->getRol_usr()."'></td>
            <td><input type='text' size='9' name='nic' value='".$fila->getNic_usr()."'></td>
            <td><input type='text' size='9' name='nom' value='".$fila->getNom_usr()."'></td>
            <td><input type='text' size='9' name='ape' value='".$fila->getApe_usr()."'></td>
            <td><input type='text' size='12' name='dir' value='".$fila->getDir_usr()."'></td>
            <td><input type='text' size='4' name='cop' value='".$fila->getCop_usr()."'></td>
            <td><input type='text' size='9' name='loc' value='".$fila->getLoc_usr()."'></td>
            <td><input type='text' size='9' name='pro' value='".$fila->getPro_usr()."'></td>
            <td><input type='text' size='12' name='ema' value='".$fila->getEma_usr()."'></td>
            <td><input type='text' size='9' name='tel' value='".$fila->getTel_usr()."'></td>
            <td><input type='text' size='4' name='pas' value='".$fila->getPas_usr()."'></td>
            <td><input type='text' size='1' name='act' value='".$fila->getAct_usr()."'></td>
            <td><button type='submit' class='btn btn-primary'>Modificar</button></td></tr>
            </form>";
    }
}

function editar_cliente($nic, $dni, $nom, $ape, $dir, $loc, $pro, $ema, $tel, $pas)
{
    $conex = conectar();
    $codigo = "UPDATE usuarios SET nic_usr = :nic, nom_usr = :nom, ape_usr = :ape, dir_usr = :dir,
                loc_usr = :loc, pro_usr = :pro, ema_usr = :ema, tel_usr = :tel, pas_usr = :pas WHERE dni_usr = :dni";
    $insert = $conex->prepare($codigo);
    $fila = $insert->execute(array(
            ':dni' => $dni,
            ':nic' => $nic,
            ':nom' => $nom,
            ':ape' => $ape,
            ':dir' => $dir,
            ':loc' => $loc,
            ':pro' => $pro,
            ':ema' => $ema,
            ':tel' => $tel,
            ':pas' => $pas
        ));
        if ($fila == 1) {
            echo "<br>Modificacion completada";
        }else{
            echo "<br>Error en la modificacion<br>";
        }
}

function mostrar_categorias(){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT nom_cat FROM categorias ORDER BY id_cat");
    $consulta->execute();
    while($fila = $consulta->fetch()){
        $categ[]=$fila[0];
    }
    return $categ;   
}
function mostrar_subcategorias($categ){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT nom_sub FROM subcategorias WHERE cat_sub=:categ");
    $consulta->execute(array(':categ'=>$categ));
    while($fila = $consulta->fetch()){
        $subcateg[] = $fila[0];
    }
    return $subcateg;
}
function ver_subcategorias($subcateg){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM articulos WHERE sub_art=:subcat ORDER BY id_art DESC");
    $consulta->execute(array(':subcat'=>$subcateg));
    $consulta->setFetchMode(PDO::FETCH_CLASS, 'articulos');
    while($fila = $consulta->fetch()){
        echo '<div class="col-md-6 col-xl-4"><div><a href="detalleArticulo.php?art='.$fila->getId_art().'">
                <img src="imgProductos/'.$fila->getId_art().'.jpg" width="100" height="100"></a></div><div>'.
                $fila->getNom_art() . ' ' . $fila->getPre_art().'</div></div>';
    }
}
function ver_idSubcategoria($nombre_sub){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT id_sub FROM subcategorias WHERE nom_sub=:nom_sub");
    $consulta->execute(array(':nom_sub'=>$nombre_sub));
    $fila = $consulta->fetch();
    return $fila[0];
}
function buscar_articulo($articulo){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM articulos WHERE id_art=:art");
    $consulta->execute(array(":art"=>$articulo));
    $consulta->setFetchMode(PDO::FETCH_CLASS,"articulos");
    $fila = $consulta->fetch();
    return $fila;   
}
?>
