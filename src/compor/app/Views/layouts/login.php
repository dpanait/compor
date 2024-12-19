<?php use Core\View; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Mi Proyecto' ?></title>
    <?php foreach (View::getCssFiles() as $cssFile): ?>
      <link rel="stylesheet" href="<?= View::$base_path . $cssFile ?>">
    <?php endforeach; ?>
	<link rel="stylesheet" href="<?= View::$base_path ?>/css/base.css">
		<!-- Incluir los archivos JS -->
	<?php foreach (View::getJsFiles() as $jsFile): ?>
      <script src="<?= View::$base_path . $jsFile ?>"></script>
  	<?php endforeach; ?>
</head>
<body>
	<header>
	</header>

	<div class="container">
			<!-- Aquí se insertará el contenido específico de cada vista -->
			<?= $content ?>
	</div>

	<footer>
			<p>&copy; 2024 comporlive.com. Todos los derechos reservados.</p>
	</footer>
</body>
</html>