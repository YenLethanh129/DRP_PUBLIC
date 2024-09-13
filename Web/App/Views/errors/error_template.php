
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error <?= $errorCode ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body {
      background: linear-gradient(to right, #E2E2E2,  #CCD8FF);
      flex-direction: column;
      display: flex;
      margin:0 auto;
      clear:left;
      z-index: 0;
      text-align:center;
    }

    .container {
      min-height: 70vh; 
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center; 
    }

    h1 {
      color: #6c757d;
    }

    p {
      color: #6c757d;
    }

    .header {
      position: fixed; 
      top: 0;
      width: 100%;
    }
    .footer {
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>

<body>
  <div class="header">
    <? require_once($_SERVER['DOCUMENT_ROOT'] . '/Public/inc/header.php'); ?>
  </div>  
  <div class="container">
      <img src="/Public/images/<?= $errorCode ?>.png" alt="" style="height:100vh; width:100vw; object-fit: fit">
  </div>
  <div class="footer">
    <? require_once($_SERVER['DOCUMENT_ROOT'] . '/Public/inc/footer.php'); ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>