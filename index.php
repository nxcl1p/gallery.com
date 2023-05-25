<?
if (isset($_GET['dir'])) {
  $dir = $_GET['dir'];
} else {
  $dir = 'img/';
}

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
  <title>Gallery</title>
</head>

<body class="text-bg-dark">

  <nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="container-fluid">
      <div class="navbar-brand">
        <h1>
          <? echo $dir ?>
        </h1>
      </div>
      <div class="nav navbar-nav">
        <form action="index.php?dir=<? echo $dir; ?>" class="d-flex my-2 my-lg-0" method="post"
          enctype="multipart/form-data" autocomplete="off">
          <input type="file" id="file" name="uploaded_image" class="form-control me-2">
          <button type="submit" class="btn btn-success">Submit</button>
        </form>
      </div>
    </div>
  </nav>

  <?
  $root_dir = opendir(".");
  while ($file = readdir($root_dir)): ?>
  <? if (is_dir($file) && $file != '.' && $file != '..' && $file != 'bootstrap'):
    $files = array_diff(scandir($dir), array('..', '.')); ?>
  <div class='container'>
    <div class='row'>
      <a href='index.php?dir=<?= $file ?>' class='' type='button'><?= $file ?></a>
    </div>
  </div>
  <? endif; ?>
  <? endwhile; ?>
  <? closedir($root_dir); ?>


  <div class="container">
    <div class="row">
      <? foreach ($files as $file): ?>
      <div class="col-6 col-lg-2 text-center" style="max-width:100%" ;>
        <img src="<? echo $dir . '/' . $file; ?>" alt="img" class="img-fluid">
        <form method="post" class="pt-3 pb-3">
          <input type="hidden" name="filename" value="<? echo $file ?>">
          <button type="submit" class="btn btn-danger btn-primary" name="delete">Delete</button>
        </form>
      </div>
      <? endforeach; ?>
    </div>
  </div>
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>