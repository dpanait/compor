<?php use Core\View;?>
<div class="row d-flex flex-column align-content-center">
  <div class="row col-auto text-center">
    <h1><?= htmlspecialchars($title) ?></h1>
    <p><?= htmlspecialchars($description) ?></p>
    <?php if($error != ""): ?>
        <div class="text-danger"><?=$error;?></div>
    <?php endif ?>
  </div>
  <div class="row col-auto mx-auto">
    <form action="<?=View::$droot;?>login/authenticate" method="POST">
      <div class="mb-3">
        <div>
          <label for="username">User name</label>
          <input type="text" class="form-control" aria-label="Text input with radio button"  name="username" id="username" required>
        </div>
        <div>
          <label for="password">Password</label>
          <input type="text" class="form-control" aria-label="Text input with radio button"  name="password" id="password" required>
        </div>
        
        <button class="btn btn-outline-secondary" type="button" id="stop_camera"><i class="bi bi-camera-video-off"></i></button>
      </div>
      <!--div class="mb-3">
        <label for="password" class="form-label">Contraseña:</label>
        <input type="text" class="form-control" aria-label="Text input with radio button"  name="password" id="password" required>
      </div-->
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Ingresar</button>
      </div>
    </form>
  </div>
  <div class="row justify-content-around">
    <div id="reader" class="m-5" style="max-width: 400px;"></div>
  </div>
</div>