<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="./public/libjs/jquery/bootstrap.min.css" rel="stylesheet">
  <link href="./public/css/base.css" rel="stylesheet">
</head>
<body>
  <header>
    <h1>Login</h1>
  </header>

  <main>
    <section id="home" class="box-container-one-col">
      <div class="mx-auto">
        <label for="code" class="">Codígos</label>
        <input name="code" id="code" class="form-control"/>
      </div>
      <div>
        <div class="btn btn-primary" onclick="login();">Login</div>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2024 kuuvoo.com. Todos los derechos reservados.</p>
  </footer>
  <script src="./public/js/base.js" ></script>
</body>
</html>