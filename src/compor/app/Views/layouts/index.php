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
	<link rel="stylesheet" href="<?= View::$base_path ?>/css/font-awesome.css">
	<link rel="stylesheet" href="<?= View::$base_path ?>/css/base.css">
</head>
<body>
		<!-- Navbar -->
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Brand/Logo -->
            <a class="navbar-brand" href="#"><i class="fa-solid fa-ring"></i></a>
            <!-- Hamburger Menu (for mobile) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?=View::$droot;?>home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=View::$droot;?>about">About</a>
                    </li>
                </ul>
				<div id="logout"><a href="<?=View::$droot;?>login/logout">Cerrar Sesión</a></div>
            </div>	
        </div>
    </nav>
	<div class="container">
		<!-- Aquí se insertará el contenido específico de cada vista -->
		<?= $content ?>
	</div>

	<footer>
		<p>&copy; 2024 comporlive.com. Todos los derechos reservados.</p>
	</footer>
	<?php foreach (View::getJsFiles() as $jsFile): ?>
      <script src="<?= View::$base_path . $jsFile ?>"></script>
  	<?php endforeach; ?>
</body>
</html>