<h2>Ver clientes</h2>

<div id="ver_clientes_empresas_container">
	<h2>Empresas</h2>
	<ul>
	<?php foreach ($empresas as $empresa): ?>
				<li id="ver_clientes_empresas">
				<a href="<?php echo base_url() ?>clientes/ver_empresa/<?php echo $empresa['id'] ?>" class="lupa"><?php echo $empresa['nombre'] ?></a></li>
	<?php endforeach ?>
	</ul>
</div>

<div id="ver_clientes_personas_container">
	<h2>Personas Naturales</h2>
	<ul>
	<?php foreach($personas as $row): ?>
		<div id="div_persona_<?php echo $row['id']?>">
				<li id="ver_clientes_personas">
				<a href="<?php echo base_url() ?>clientes/ver_persona/<?php echo $row['id'] ?>" class="lupa"><?php echo $row['nombre'] ?></a></li>
		</div>
	<?php endforeach ?>
	</ul>
</div>

</body>
</html>