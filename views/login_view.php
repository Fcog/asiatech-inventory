<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asiatech Distributors</title>
<link href="<?php echo base_url(); ?>recursos/css/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
<img src="<?php echo base_url(); ?>recursos/imagenes/logo_asiatech.png" alt="Asiatech Logo" name="index_logo" width="372" height="174" id="index_logo" />

<div id="index_container">
  <form id="index_form" name="index_form" action="<?php echo base_url() ?>log_user" method="post">
    <p><?php echo $aviso ?></p>
    <table>
      <tr>
        <td><label>Usuario:</label></td>
        <td><input type="text" id="login" name="login"/></td>
      </tr>
      <tr>
        <td><label>Clave:</label></td>
        <td><input type="password" id="clave" name="clave" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="entrar" id="entrar" value="ENTRAR"/></td>
      </tr>
    </table>
    <p><br />
    </p>
    <p>&nbsp;</p>
  </form>
</div>
<?php include 'compatibilidad.php'; ?>
</body>
</html>