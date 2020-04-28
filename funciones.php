<?php

// Conexión a insertar en la mayoría de funciones
function conectar()
{
    try {
        //$conex = new PDO("mysql:dbname=tienda;host=localhost", "jefe", "jefe");
        $conex = new PDO("mysql:dbname=id13325790_nubehost;host=localhost", "id13325790_jefe", "hkbSBiBo/>H3I9EB");
        $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conex;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Formulario para registro clientes (son únicos: id,dni y nic)
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
            return "<span class='text-success'>Registro completado correctamente</span>";
        }
    } catch (PDOException $e) {
        if (preg_match("/dni_usr'$/", $e->getMessage())) {
            return "<span class='text-danger'>Este DNI ya está registrado</span>";
        } else if (preg_match("/nic_usr'$/", $e->getMessage())) {
            return "<span class='text-danger'>Este nick ya está en uso, pruebe otro</span>";
        }
    }
}

// Registro nuevas categorías
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
            return "<span class='text-primary'>Registro completado correctamente</span>";
        }
    } catch (PDOException $e) {
        return "<span class='text-danger'>Nombre de la categoria utilizado anteriormente</span>";
    }
}

// Devuelve nombre de categoria a partir de su id
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

// Devuelve nombre subcategoria a partir de su id
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

// Registro de nueva subcategoría
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
            return "<span class='text-primary'>Registro completado correctamente</span>";
        }
    } catch (PDOException $e) {
        return "<span class='text-danger'>Nombre de la categoria utilizado anteriormente</span>";
    }
}

// Registro nuevos articulos
function registrar_articulos($nom, $cat, $sub, $des, $pre, $act, $sto)
{
    $conex = conectar();
    $codigo = "INSERT INTO articulos (nom_art,cat_art,sub_art,des_art,pre_art,act_art,sto_art)
               VALUES (:nom,:cat,:sub,:des,:pre,:act,:sto);";
    $insert = $conex->prepare($codigo);
    try {
        $fila = $insert->execute(array(
            ':nom' => $nom,
            ':cat' => $cat,
            ':sub' => $sub,
            ':des' => $des,
            ':pre' => $pre,
            ':act' => $act,
            ':sto' => $sto
        ));

        if ($fila == 1) {
            return '<br><span class="correcto">Registro completado correctamente</span>';
        }
    } catch (PDOException $e) {
        return "<br><span class='error'>Error en el registro</span>";
    }
}

// Guardar imagenes(nombre archivo pre-nombrado igual que id_articulo)
function guardar_archivo($img)
{
    $temporal = $_FILES[$img]["tmp_name"];
    $imagen = GetImageSize($temporal);
    if ($imagen[0] == 300 && $imagen[1] == 300 && $imagen[2] == 2) {
        $destino = "imgProductos/" . $_FILES["$img"]["name"];
        if (move_uploaded_file($temporal, $destino)) {
            echo "Imagen subida a servidor";
        } else {
            echo "Error en la subida de la imagen";
        }
    } else {
        echo "La imagen no tiene las medidas o el formato correcto";
    }
}

// Clase articulos para mapeo, solo getters(debería ir en archivo aparte, clases.php)
class articulos
{

    private $id_art;

    private $nom_art;

    private $sub_art;

    private $cat_art;

    private $des_art;

    private $pre_art;

    private $act_art;

    private $sto_art;

    public function getId_art()
    {
        return $this->id_art;
    }

    public function getNom_art()
    {
        return $this->nom_art;
    }

    public function getSub_art()
    {
        return $this->sub_art;
    }

    public function getCat_art()
    {
        return $this->cat_art;
    }

    public function getDes_art()
    {
        return $this->des_art;
    }

    public function getPre_art()
    {
        return $this->pre_art;
    }

    public function getAct_art()
    {
        return $this->act_art;
    }

    public function getSto_art()
    {
        return $this->sto_art;
    }
}

// Articulos ordenados por registros más recientes (OJO, "siguiente" avanza hacia los más antiguos,)
function mostrar_articulos($bloque, $orden = 'ASC')
{
    if (isset($_GET["comienzo"])) {
        $comienzo = $_GET["comienzo"];
    } else {
        $comienzo = 0;
    }
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM articulos  ORDER BY id_art $orden LIMIT $comienzo , $bloque");
    $consulta->execute();
    $consulta->setFetchMode(PDO::FETCH_CLASS, 'articulos');
    while ($fila = $consulta->fetch()) {
        $articulos[] = $fila;
    }
    $datos[] = $articulos;
    if (($comienzo + $bloque) < contar_articulos()) {
        $prox = $comienzo + $bloque;
        $url = $_SERVER["PHP_SELF"] . "?comienzo=$prox";
        $datos[] = "<a href='$url'>Siguiente</a>";
    } else {
        $datos[] = "";
    }
    if ($comienzo > 0) {
        $prev = $comienzo - $bloque;
        $url = $_SERVER["PHP_SELF"] . "?comienzo=$prev";
        $datos[] = "<a href='$url'>Anterior</a>";
    } else {
        $datos[] = "";
    }

    return $datos;
}

// Clase usuarios, solo getters (debería ir en archivo aparte, clases.php)
class usuarios
{

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

    public function getId_usr()
    {
        return $this->id_usr;
    }

    public function getDni_usr()
    {
        return $this->dni_usr;
    }

    public function getRol_usr()
    {
        return $this->rol_usr;
    }

    public function getNic_usr()
    {
        return $this->nic_usr;
    }

    public function getNom_usr()
    {
        return $this->nom_usr;
    }

    public function getApe_usr()
    {
        return $this->ape_usr;
    }

    public function getDir_usr()
    {
        return $this->dir_usr;
    }

    public function getCop_usr()
    {
        return $this->cop_usr;
    }

    public function getLoc_usr()
    {
        return $this->loc_usr;
    }

    public function getPro_usr()
    {
        return $this->pro_usr;
    }

    public function getEma_usr()
    {
        return $this->ema_usr;
    }

    public function getTel_usr()
    {
        return $this->tel_usr;
    }

    public function getPas_usr()
    {
        return $this->pas_usr;
    }

    public function getAct_usr()
    {
        return $this->act_usr;
    }
}

// Si cumple mínimas validaciones antes, aquí se comprueba si existe usuario y si coincide password.
function buscar_usuario($nombre, $password)
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM usuarios WHERE nic_usr = :nic");
    $consulta->execute(array(
        ':nic' => $nombre
    ));
    $consulta->setFetchMode(PDO::FETCH_CLASS, "usuarios");
    if ($fila = $consulta->fetch()) {
        if ($fila->getPas_usr() == $password && $fila->getAct_usr()) {
            if ($fila->getRol_usr() == 2) {
                return 0;
            } else if ($fila->getRol_usr() == 3) {
                return 3;
            } else if ($fila->getRol_usr() == 4) {
                return 4;
            } else {
                return 5;
            }
        } else {
            return 1;
        }
    } else {
        return 2;
    }
}

// Devuelve el objeto usuario a partir de su nic (que es único)
function datos_usuario($nombre)
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM usuarios WHERE nic_usr = :nic");
    $consulta->execute(array(
        ':nic' => $nombre
    ));
    $consulta->setFetchMode(PDO::FETCH_CLASS, "usuarios");
    if ($fila = $consulta->fetch()) {
        return $fila;
    } else {
        return false;
    }
}

// Nos devuelve el total de usuarios para la función de paginación
function contar_usuarios()
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT COUNT(*) FROM usuarios");
    $consulta->execute();
    $fila = $consulta->fetch();
    return $fila[0];
}

// Nos devuelve el total de articulos para la función de paginación
function contar_articulos()
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT COUNT(*) FROM articulos");
    $consulta->execute();
    $fila = $consulta->fetch();
    return $fila[0];
}

// Listado para de usuarios manipulable para uso exclusivo del administrador
function mostrar_usuario($bloque)
{
    if (isset($_GET["desplazamiento"])) {
        $desplazamiento = $_GET["desplazamiento"];
    } else {
        $desplazamiento = 0;
    }
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM usuarios ORDER BY id_usr LIMIT $desplazamiento , $bloque");
    $consulta->execute();
    $consulta->setFetchMode(PDO::FETCH_CLASS, "usuarios");

    while ($fila = $consulta->fetch()) {
        $inv = '';
        $cli = '';
        $emp = '';
        $adm = '';
        switch ($fila->getRol_usr()) {
            case 1:
                $inv = 'selected';
                break;
            case 2:
                $cli = 'selected';
                break;
            case 3:
                $emp = 'selected';
                break;
            case 4:
                $adm = 'selected';
        }
        echo "<form method='POST' action='adminusers.php'>
            <tr><th class='px-0' scope='row'><input type='text' class='bg-light text-dark' readonly style='width:2em' name='id' value='" . $fila->getId_usr() . "'></th>
            <td class='px-0'><input type='text' size='9' class='bg-light text-dark' name='dni' readonly value='" . $fila->getDni_usr() . "'></td>
            <td class='px-0'><input type='text' size='9' class='bg-light text-dark' name='nic' readonly value='" . $fila->getNic_usr() . "'></td>
            <td class='px-0'><select  name='rol' value='" . $fila->getRol_usr() . "'>
                    <option value=1 $inv>Invitado</option>
                    <option value=2 $cli>Cliente</option>
                    <option value=3 $emp>Empleado</option>
                    <option value=4 $adm>Administrador</option> ></select></td>
            <td class='px-0'><input type='text' size='9' name='nom' value='" . $fila->getNom_usr() . "'></td>
            <td class='px-0'><input type='text' size='9' name='ape' value='" . $fila->getApe_usr() . "'></td>
            <td class='px-0'><input type='text' size='12' name='dir' value='" . $fila->getDir_usr() . "'></td>
            <td class='px-0'><input type='text' size='4' name='cop' value='" . $fila->getCop_usr() . "'></td>
            <td class='px-0'><input type='text' size='9' name='loc' value='" . $fila->getLoc_usr() . "'></td>
            <td class='px-0'><input type='text' size='9' name='pro' value='" . $fila->getPro_usr() . "'></td>
            <td class='px-0'><input type='text' size='12' name='ema' value='" . $fila->getEma_usr() . "'></td>
            <td class='px-0'><input type='text' size='9' name='tel' value='" . $fila->getTel_usr() . "'></td>
            <td class='px-0'><input type='text' size='4' name='pas' value='" . $fila->getPas_usr() . "'></td>
            <td class='px-0'><input type='text' size='1' name='act' value='" . $fila->getAct_usr() . "'></td>
            <td class='px-0'><button type='submit' class='btn btn-primary'>Modificar</button></td></tr>
            </form>";
    }
    if ($desplazamiento > 0) {
        $prev = $desplazamiento - $bloque;
        $url = $_SERVER["PHP_SELF"] . "?desplazamiento=$prev";
        echo "<div class='text-center'><a href='$url'>Anterior</a>";
    } else {
        echo "<div class='text-center'>";
    }
    if (($desplazamiento + 4) < contar_usuarios()) {
        $prox = $desplazamiento + $bloque;
        $url = $_SERVER["PHP_SELF"] . "?desplazamiento=$prox";
        echo "<a href='$url'>Siguiente</a></div>";
    } else {
        echo "</div>";
    }
}

//
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
        return "<span class='text-success'>Modificación completada</span>";
    } else {
        return "<span class='text-danger'>Error en la modificacion</span>";
    }
}

// Lista todas las categorías existentes (para menú lateral)
function mostrar_categorias()
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM categorias ORDER BY id_cat");
    $consulta->execute();
    $categ = array();
    while ($fila = $consulta->fetch()) {
        $categ[] = $fila;
    }
    if (isset($categ)) {
        return $categ;
    }
}

// Lista todas las subcategorias de una id de categoria (para menú lateral)
function mostrar_subcategorias($categ)
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM subcategorias WHERE cat_sub=:categ");
    $consulta->execute(array(
        ':categ' => $categ
    ));
    $subcateg = array();
    while ($fila = $consulta->fetch()) {
        $subcateg[] = $fila;
    }
    if (isset($subcateg)) {
        return $subcateg;
    } else {
        return null;
    }
}

// Muestra todos los articulos de una subcategoría a partir del id (para menú principal subcategoria)
function ver_subcategorias($categ, $subcateg)
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM articulos WHERE cat_art = :cat AND sub_art=:subcat  ORDER BY id_art DESC");
    $consulta->execute(array(
        ':cat' => $categ,
        ':subcat' => $subcateg
    ));
    $consulta->setFetchMode(PDO::FETCH_CLASS, 'articulos');
    while ($fila = $consulta->fetch()) {
        echo "<div class='col-md-6 col-xl-4'><div><a href='detalleArticulo.php?art=" . $fila->getId_art() . "'>
                <img src='imgProductos/" . $fila->getId_art() . ".jpg' width='100' height='100'></a></div>" . $fila->getNom_art() . " " . $fila->getPre_art() . "</div>";
    }
}

// Devuelve el id de una subcategoria a partir de su nombre
function ver_idSubcategoria($nombre_sub)
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT cat_sub, id_sub FROM subcategorias WHERE nom_sub=:nom_sub");
    $consulta->execute(array(
        ':nom_sub' => $nombre_sub
    ));
    $fila = $consulta->fetch();
    return $fila;
}

// Devuelve objeto articulo a partir de su id
function buscar_articulo($articulo)
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM articulos WHERE id_art=:art");
    $consulta->execute(array(
        ":art" => $articulo
    ));
    $consulta->setFetchMode(PDO::FETCH_CLASS, "articulos");
    $fila = $consulta->fetch();
    if(isset($fila)){
        return $fila;
    }else{
        return false;
    }
}

// Edita usuario a partir de su dni (solo para administrador, accede al rol)
function editar_usuario($dni, $rol, $nom, $ape, $dir, $cop, $loc, $pro, $ema, $tel, $pas, $act)
{
    $conex = conectar();
    $codigo = "UPDATE usuarios SET rol_usr = :rol, nom_usr = :nom, ape_usr = :ape, dir_usr = :dir,
                cop_usr = :cop, loc_usr = :loc, pro_usr = :pro, ema_usr = :ema,
                tel_usr = :tel, pas_usr = :pas, act_usr = :act WHERE dni_usr = :dni";
    $insert = $conex->prepare($codigo);
    $fila = $insert->execute(array(
        ':dni' => $dni,
        ':rol' => $rol,
        ':nom' => $nom,
        ':ape' => $ape,
        ':dir' => $dir,
        ':cop' => $cop,
        ':loc' => $loc,
        ':pro' => $pro,
        ':ema' => $ema,
        ':tel' => $tel,
        ':pas' => $pas,
        ':act' => $act
    ));
    if ($fila == 1) {
        return "<br>Modificacion completada";
    } else {
        return "<br>Error en la modificacion<br>";
    }
}

// Genera un nuevo pedido para el cliente que se encuentre autentificado
function crear_pedido($cliente)
{
    $fecha = time();
    $usr = datos_usuario($cliente)->getId_usr();
    $conex = conectar();
    $insertar = $conex->prepare("INSERT INTO pedidos (usr_ped, fec_ped) VALUES (:cli, :fecha)");
    $fila = $insertar->execute(array(
        ':cli' => $usr,
        ':fecha' => $fecha
    ));
    return $conex->lastInsertId();
}

// Registra una linea en un pedido
function crear_linea($ped, $art, $cant)
{
    $conex = conectar();
    $insertar = $conex->prepare("INSERT INTO lineas (ped_lin, art_lin, can_lin) VALUES(:ped,:art,:can)");
    $fila = $insertar->execute(array(
        ':ped' => $ped,
        ':art' => $art,
        ':can' => $cant
    ));
}

// Clase lineas para mapeo, solo getters(debería ir en archivo aparte, clases.php)
class lineas
{

    private $ped_lin;

    private $id_lin;

    private $art_lin;

    private $can_lin;

    public function getPed_lin()
    {
        return $this->ped_lin;
    }

    public function getId_lin()
    {
        return $this->id_lin;
    }

    public function getArt_lin()
    {
        return $this->art_lin;
    }

    public function getCan_lin()
    {
        return $this->can_lin;
    }
}

// Lista las lineas de un pedido a partir de su id
function mostrar_lineas($ped)
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM lineas WHERE ped_lin = :id_ped");
    $consulta->execute(array(
        ':id_ped' => $ped
    ));
    $consulta->setFetchMode(PDO::FETCH_CLASS, "lineas");
    $total = 0;
    echo "<table class='table bg-light'><th>Linea</th><th>Articulo</th><th>Cantidad</th><th>Precio(IVA incluido)</th><th>Importe</th>";
    while ($fila = $consulta->fetch()) {
        $art = buscar_articulo($fila->getArt_lin());
        $total += ($art->getPre_art() * $fila->getCan_lin());
        echo "<tr class='text-center'><td>" . $fila->getId_lin() . "</td><td>" . $art->getNom_art() . "</td><td>" . $fila->getCan_lin() . "</td>
            <td>" . $art->getPre_art() . "</td>
            <td class='text-right'>" . number_format($art->getPre_art() * $fila->getCan_lin(), 2) . "</td></tr>";
    }
    echo "<tr><td colspan='4' class='text-right'>Base Imponible</td>
        <td class='text-right'>" . number_format($total / 1.21, 2) . "</td></tr><tr>
        <td colspan='4' class='text-right'>I.V.A. 21%</td>
        <td class='text-right'>" . number_format($total * 21 / 121, 2) . "</td></tr><tr class='table-active'>
        <th colspan='4' class='text-right'>Total pedido</th>
        <th class='text-right'>" . number_format($total, 2) . "</th></tr></table>";
}

// Menu desplegable categorias para registrar subcategorias
function menu_categorias()
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM categorias");
    $consulta->execute();
    while ($fila = $consulta->fetch()) {
        echo "<option value=" . $fila[0] . ">" . $fila[1] . "</option>";
    }
}

function menu_subcategorias()
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM subcategorias");
    $consulta->execute();
    while ($fila = $consulta->fetch()) {
        echo "<option value=" . $fila[1] . ">" . $fila[2] . "</option>";
    }
}

function modificar_articulo($id, $nom, $cat, $sub, $des, $pre, $act, $sto)
{
    $conex = conectar();
    $codigo = "UPDATE articulos SET  nom_art = :nom, cat_art = :cat, sub_art = :sub, des_art = :des, pre_art = :pre,
            act_art = :act, sto_art = :sto WHERE id_art = :id";
    $insert = $conex->prepare($codigo);
    $registro = $insert->execute(array(
        ':nom' => $nom,
        ':cat' => $cat,
        ':sub' => $sub,
        ':des' => $des,
        ':pre' => $pre,
        ':act' => $act,
        ':sto' => $sto,
        ':id' => $id
    ));
    if ($registro == 1) {
        return "Modificado";
    }
}

function listadesubcategorias()
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM subcategorias");
    $consulta->execute();
    while ($fila = $consulta->fetch()) {
        $lista_subcateg[] = $fila;
    }
    return $lista_subcateg;
}

function devuelve_categoria($id_cat)
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM categorias WHERE id_cat = :id");
    $consulta->execute(array(
        ':id' => $id_cat
    ));
    $cat = $consulta->fetch();
    return $cat;
}

function modificar_categoria($nom, $id)
{
    $conex = conectar();
    $consulta = $conex->prepare("UPDATE categorias SET nom_cat = :nom WHERE id_cat = :id");
    $actualiza = $consulta->execute(array(
        ':nom' => $nom,
        ':id' => $id
    ));
    if ($actualiza == 1) {
        return true;
    } else {
        return false;
    }
}

function devuelve_subcategoria($idcat, $idsub){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM subcategorias WHERE cat_sub = :cat AND id_sub = :sub ");
    $consulta->execute(array(':cat'=>$idcat, ':sub'=>$idsub));
    $sub = $consulta->fetch();
    return $sub;
}
function modificar_subcategoria($nom,$idcat, $idsub){
    $conex = conectar();
    $consulta = $conex->prepare("UPDATE subcategorias SET nom_sub = :nom WHERE cat_sub = :idcat AND id_sub = :idsub");
    $actualiza = $consulta->execute(array(':nom'=>$nom, ':idcat'=> $idcat,':idsub'=> $idsub));
    if ($actualiza == 1) {
        return true;
    } else {
        return false;
    }
}
function cargar_articulos($categ, $subcateg)
{
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM articulos WHERE cat_art = :cat AND sub_art=:subcat");
    $consulta->execute(array(
        ':cat' => $categ,
        ':subcat' => $subcateg
    ));
    $articulos = array();
    $consulta->setFetchMode(PDO::FETCH_CLASS, 'articulos');
    while ($fila = $consulta->fetch()) {
       $articulos[] = $fila;
    }
    return $articulos;
}
function borrar_categoria($id){
    $conex = conectar();
    $consulta = $conex->prepare("DELETE FROM categorias WHERE id_cat = :id");
    $borrado = $consulta->execute(array(':id'=>$id));    
}
function borrar_subcategoria($idcat, $idsub){
    $conex = conectar();
    $consulta = $conex->prepare("DELETE FROM subcategorias WHERE cat_sub = :idcat AND id_sub = :idsub");
    $borrado = $consulta->execute(array(':idcat'=>$idcat, ':idsub'=>$idsub));
}

function datos_user($iduser){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM usuarios WHERE id_usr = :id");
    $consulta->execute(array(
        ':id' => $iduser
    ));
    $consulta->setFetchMode(PDO::FETCH_CLASS, "usuarios");
    if ($fila = $consulta->fetch()) {
        return $fila;
    } else {
        return false;
    }
}

function mostrar_pedidos(){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM pedidos");
    $consulta->execute();
    while($fila=$consulta->fetch()){
        $fecha = getDate($fila[2]);
        $dia = $fecha["mday"];
        $mes = $fecha['mon'];
        $anyo = $fecha['year'];
        echo "<h5 class='pt-5'>Pedido nº $fila[0] -  Fecha: $dia/$mes/$anyo - Cliente: ". datos_user($fila[1])->getNom_usr(). " " .
        datos_user($fila[1])->getApe_usr()."</h5>";
        mostrar_lineas($fila[0]);
    }
}
function mis_pedidos($cliente){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM pedidos WHERE usr_ped = :id");
    $consulta->execute(array(':id'=>$cliente));
    while($fila=$consulta->fetch()){
        $fecha = getDate($fila[2]);
        $dia = $fecha["mday"];
        $mes = $fecha['mon'];
        $anyo = $fecha['year'];
        echo "<h5 class='pt-5'>Pedido nº $fila[0] -  Fecha: $dia/$mes/$anyo - Cliente: ". datos_user($fila[1])->getNom_usr(). " " .
            datos_user($fila[1])->getApe_usr()."</h5>";
            mostrar_lineas($fila[0]);
    }
}

function informe_pedidos($cliente, $inicio, $final){
    $totalperiodo = 0;
    echo "<h5>Cliente: ". datos_user($cliente)->getNom_usr()." ". datos_user($cliente)->getApe_usr() . "<h5>";
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM pedidos WHERE usr_ped = :id AND fec_ped >= :inicio
                                AND fec_ped <= :final");  
    $consulta->execute(array(':id'=>$cliente, ':inicio'=>$inicio, ':final'=>$final));
    while($fila=$consulta->fetch()){
        $lineas = devuelve_lineas($fila[0]);
        foreach($lineas as $detalle){
            $totalperiodo += $detalle->getCan_lin() * (buscar_articulo($detalle->getArt_lin()))->getPre_art();  
        }     
        $fecha = getDate($fila[2]);
        $dia = $fecha["mday"];
        $mes = $fecha['mon'];
        $anyo = $fecha['year'];
        echo "<h5 class='pt-5'>Pedido nº $fila[0] -  Fecha: $dia/$mes/$anyo </h5>";
        mostrar_lineas($fila[0]);
    }
    echo "<h5 class='bg-light'>Total en el periodo: ".number_format($totalperiodo,2)."</h5>";
}
function devuelve_lineas($id_pedido){
    $lineas=array();
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM lineas WHERE ped_lin = :ped");
    $consulta->execute(array(':ped'=>$id_pedido));
    $consulta->setFetchMode(PDO::FETCH_CLASS, "lineas");
    while($fila=$consulta->fetch()){
        $lineas[] = $fila;
    }
    return $lineas;
}

function stock($articulo){
    $conex = conectar();
    $consulta = $conex->prepare("SELECT sto_art FROM articulos WHERE id_art = :art");
    $consulta->execute(array(':art'=>$articulo));
    $fila=$consulta->fetch();
    $oldstock = $fila[0];
    return $oldstock;
}

function descontar_stock($articulo,$cantidad){
    $stock = stock($articulo);
    $newstock = $stock - $cantidad;
    $conex = conectar();
    $consulta = $conex->prepare('UPDATE articulos SET sto_art = :sto WHERE id_art = :art');
    $consulta->execute(array(':sto' => $newstock, ':art' => $articulo));   
}

function insertar_pedidoAlmacen($ped, $fec, $art, $cant){
    $conex = conectar();
    $consulta = $conex->prepare("INSERT INTO almacen (ped_alm, fec_alm, art_alm, can_alm)
                VALUES (:ped, :fec, :art, :cant);");
    $insertar = $consulta->execute(array(':ped'=>$ped, ':fec'=>$fec, ':art'=>$art, ':cant'=>$cant));
    if($insertar == 1){
        return "Insertado registro en almacén";
    }else{
        return "Ha ocurrido un error y no se ha podido grabar";
    }
}
function busca_cliente($cliente){
    $conex = conectar();
    $conexion = $conex->prepare("SELECT * FROM usuarios WHERE id_usr = :usr");
    $conexion->execute(array(':usr'=>$cliente));
    $conexion->setFetchMode(PDO::FETCH_CLASS, 'usuarios');
    $fila = $conexion->fetch();
    return $fila; 
}
    
// Listado para de usuarios manipulable para uso exclusivo del administrador y empleados
function mostrar_cliente($bloque)
{
    if (isset($_GET["desplazamiento"])) {
        $desplazamiento = $_GET["desplazamiento"];
    } else {
        $desplazamiento = 0;
    }
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM usuarios WHERE rol_usr = '2' ORDER BY id_usr LIMIT $desplazamiento , $bloque");
    $consulta->execute();
    $consulta->setFetchMode(PDO::FETCH_CLASS, "usuarios");
    
    while ($fila = $consulta->fetch()) {

        echo "<form method='POST' action='clientes.php'>
            <tr><th class='px-0' scope='row'><input type='text' class='bg-light text-dark' readonly style='width:2em' name='id' value='" . $fila->getId_usr() . "'></th>
            <td class='px-0'><input type='text' size='9' class='bg-light text-dark' name='dni' readonly value='" . $fila->getDni_usr() . "'></td>
            <td class='px-0'><input type='text' size='9' class='bg-light text-dark' name='nic' readonly value='" . $fila->getNic_usr() . "'></td>
            <td class='px-0'><input type='text' size='9' name='nom' value='" . $fila->getNom_usr() . "'></td>
            <td class='px-0'><input type='text' size='9' name='ape' value='" . $fila->getApe_usr() . "'></td>
            <td class='px-0'><input type='text' size='12' name='dir' value='" . $fila->getDir_usr() . "'></td>
            <td class='px-0'><input type='text' size='4' name='cop' value='" . $fila->getCop_usr() . "'></td>
            <td class='px-0'><input type='text' size='9' name='loc' value='" . $fila->getLoc_usr() . "'></td>
            <td class='px-0'><input type='text' size='9' name='pro' value='" . $fila->getPro_usr() . "'></td>
            <td class='px-0'><input type='text' size='12' name='ema' value='" . $fila->getEma_usr() . "'></td>
            <td class='px-0'><input type='text' size='9' name='tel' value='" . $fila->getTel_usr() . "'></td>
            <td class='px-0'><input type='text' size='4' name='pas' value='" . $fila->getPas_usr() . "'></td>
            <td class='px-0'><input type='text' size='1' name='act' value='" . $fila->getAct_usr() . "'></td>
            <td class='px-0'><button type='submit' class='btn btn-primary'>Modificar</button></td></tr>
            </form>";
    }
    if ($desplazamiento > 0) {
        $prev = $desplazamiento - $bloque;
        $url = $_SERVER["PHP_SELF"] . "?desplazamiento=$prev";
        echo "<div class='text-center'><a href='$url'>Anterior</a>";
    } else {
        echo "<div class='text-center'>";
    }
    if (($desplazamiento + 4) < contar_usuarios()) {
        $prox = $desplazamiento + $bloque;
        $url = $_SERVER["PHP_SELF"] . "?desplazamiento=$prox";
        echo "<a href='$url'>Siguiente</a></div>";
    } else {
        echo "</div>";
    }
}



?>
