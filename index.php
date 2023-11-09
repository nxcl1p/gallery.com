<?
$dir = (isset($_GET['dir'])) ? $_GET['dir'] : 'img';

if (!empty($_FILES)) {
  move_uploaded_file($_FILES['uploaded_image']['tmp_name'], $dir . '/' . $_FILES['uploaded_image']['name']);
}

if (isset($_POST['delete'])) {
  $filename = $_POST['filename'];
  $filepath = $dir . '/' . $filename;

  if (file_exists($filepath)) {
    unlink($filepath);
  }

  header('Location:' . $_SERVER['PHP_SELF'] . '?dir=' . $dir . '/');
  exit();
}
?>
<!----------------------------------------------------------------------------------------------------------->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <title>Gallery</title>
</head>

<body class="text-bg-dark">
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand">
        <h3>
          You're in
          <?= $dir ?>
        </h3>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        </ul>
        <form action="index.php?dir=<? echo $dir; ?>" class="d-flex my-2 my-lg-0" method="post"
          enctype="multipart/form-data" autocomplete="off">
          <input type="file" id="file" name="uploaded_image" class="form-control me-2 text-bg-dark">
          <button type="submit" class="btn btn-success">Submit</button>
        </form>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="list-group col-lg-2 text-center text-md-start">
        <?
        $root_dir = opendir(".");
        while ($file = readdir($root_dir)): ?>
        <? if (is_dir($file) && $file != '.' && $file != '..' && $file != 'bootstrap' && $file != '.git'):
          $files = array_diff(scandir($dir), ['..', '.']); ?>
        <a href='index.php?dir=<?= $file ?>' class="list-group-item list-group-item-action text-bg-dark border-0"><i
            class="bi bi-folder-fill"></i>
          <?= $file ?>
        </a>
        <? endif; ?>
        <? endwhile; ?>
        <? closedir($root_dir); ?>
      </div>

      <? foreach ($files as $file): ?>
      <div class="col-6 col-lg-2 text-center" style="max-width: 100%;">
        <img src="<? echo $dir . '/' . $file; ?>" alt="img" class="img-fluid">
        <form method="post" class="pt-3 pb-3">
          <input type="hidden" name="filename" value="<? echo $file ?>">
          <button type="submit" class="btn btn-danger btn-primary" name="delete"><i
              class="bi bi-trash-fill"></i>Delete</button>
        </form>
      </div>
      <? endforeach; ?>
    </div>
  </div>

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>