<!--
<div class="py-2">
<h3>Iniciar sesion</h3>
<form action="control.php" method="POST">
<table align="center" width="80%" cellspacing="2" cellpadding="2" border="0">
<tr>
<td colspan="2" class="text-left pl-2"
<?php if (isset($_GET["errorusuario"]) && $_GET["errorusuario"]=="si"){
echo 'bgcolor=red><span style="color:ffffff"><b>Datos incorrectos</b></span>';
}else{
    echo "bgcolor=#cccccc>Introduce usuario";
}?></td>
</tr>
<tr>
<td align="right">USER:</td>
<td><input type="Text" name="usuario" size="8" maxlength="50"></td>
</tr>
<tr>
<td align="right">PASSWD:</td>
<td><input type="password" name="contrasena" size="8" maxlength="50"></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="Submit" value="ENTRAR"></td>
</tr>
</table>
</form>
</div>
-->
<h5>Inicio sesion</h5>
<form type="POST" action="control_usr">	
  <div class="form-group">
    <label for="usuario">Usuario</label>
    <input type="text" class="form-control" name="usuario">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" name="password">
  </div>
  
  <button type="submit" class="btn btn-primary">Enviar</button>
</form>


