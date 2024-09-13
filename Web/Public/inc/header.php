<?
use App\Controllers\UserController;

?>

<!-- Navbar -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/a2af703eed.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="vendors/font-awesome-4.7.0/css/font-awesome.min.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
    rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="/Public/images/logo.png">
  <link rel="stylesheet" href="/Public/css/costum.css">
  <title>PaPals-Enjoy your meals</title>
  <style>
    * {
      font-family: "Roboto", sans-serif;
    }

    html {
      height: 100%;
    }

    body {
      background-color: #CCD8FF;
      background: linear-gradient(to right, #E2E2E2, #CCD8FF);
      min-height: 100%;
      display: flex;
      flex-direction: column;
    }

    .limited-text {
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      min-height: 4.5em;
    }

    .limited-title {
      display: -webkit-box;
      -webkit-line-clamp: 1;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      /* min-height: 4.5em; */
    }

    input[type="number"] {
      -moz-appearance: textfield;
      -webkit-appearance: textfield;
    }

    p {
      margin: 0.25rem;
    }

    .page {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .page .header {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
    }

    .page .footer {
      margin-top: auto;
      position: fixed;
      bottom: 0;
      width: 100%;
      z-index: 1000;
    }

    footer {
      margin-top: auto;
    }

    .divider:after,
    .divider:before {
      content: "";
      flex: 1;
      height: 1px;
      background: #eee;
    }

    .h-custom {
      height: calc(100% - 73px);
    }

    @media (max-width: 450px) {
      .h-custom {
        height: 100%;
      }
    }

    .navbar {
      height: 80px;
    }

    .navbar-brand img {
      height: 35px
    }

    .navbar-brand h3 {
      font-size: 20px
    }

    .navbar-nav .nav-link {
      font-size: 15px
    }

    a.card,
    div.card {
      transition: all linear 0.24s;
    }

    a.card:hover,
    div.card:hover {
      transform: translate(-3px, -3px);
      box-shadow: 3px 3px 4px 2px #b9b9b9;
    }

    .minspace {
      min-height: 580px;
    }
  </style>

</head>

<body>
  <div class="header">
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e1ebfa;">
      <!-- Container wrapper -->
      <div class="container-fluid">
        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Navbar brand -->
          <a class="d-flex justify-content-center align-items-center">
            <a class="navbar-brand mt-2 mt-lg-0" href="/homepage">
              <img src="/Public/images/logo.png" height="50" alt="PaPals" loading="lazy" />
              <h3>PaPals</h3>
            </a>
          </a>
          <!-- Left links -->
          <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="font-size:16px">
            <li class="nav-item">
              <a class="m-2" href="/homepage">Home</a>
            </li>
            <li class="nav-item">
              <a class="m-2" href="/recipe">Recipes</a>
            </li>
            <li class="nav-item">
              <a class="m-2" href="/ingredient">Ingredients</a>
            </li>
          </ul>

          <form action="/recipe/find-by-name" method="GET"
            class="d-flex justify-content-center align-items-center input-group me-3" style="width:300px">
            <input type="text" class="form-control" id="search" name="value" placeholder="Search" aria-label="Search">
            <button type="submit" class="btn btn-outline-primary">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
          </form>


        </div>

        <?php
        // Kiểm tra xem đã đăng nhập chưa            
        if (UserController::isLoggedIn()):
          // Nếu đã đăng nhập, hiển thị nút logout và account
          ?>
          <div class="d-flex align-items-center ms-auto">
            <div class="btn-group dropstart">
              <img src="/Public/images/account.png" id="user" class="rounded-circle me-3 account"
                data-bs-toggle="dropdown" aria-expanded="false" height="30" alt="account" style="cursor: pointer;" />
              <ul class="dropdown-menu dropdown-menu-start">
                <?php
                if (UserController::isContributer()):
                  ?>
                  <li><a class="dropdown-item" href="/recipe/add">Add recipe <i class="fa-regular fa-plus"></i></a></li>
                  <li><a class="dropdown-item" href="/manager/recipe">Manage recipe<i class="fa-regular fa-plus"></i></a>
                  </li>
                  <li><a class="dropdown-item" href="/ingredient/add">Add ingredient<i class="fa-regular fa-plus"></i></a>
                  </li>
                  <li><a class="dropdown-item" href="/manager/ingredient">Manage ingredient<i
                        class="fa-regular fa-plus"></i></a></li>
                <? elseif (UserController::isAdmin()):
                  ?>
                  <li><a class="dropdown-item" href="/manager/user">Manage user<i class="fa-regular fa-plus"></i></a></li>
                  <li><a class="dropdown-item" href="/manager/recipe">Manage recipe<i class="fa-regular fa-plus"></i></a>
                  </li>
                  <li><a class="dropdown-item" href="/manager/ingredient">Manage ingredient<i
                        class="fa-regular fa-plus"></i></a></li>
                  <li><a class="dropdown-item" href="/manager">Admin page<i class="fa-regular fa-plus"></i></a></li>
                <?php endif; ?>
                <li><a href="/logout" class="ms-3 mt-3 btn btn-primary btn-xs" tabindex="-1" role="button"
                    aria-disabled="true">Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
      <?php else: // Nếu chưa đăng nhập, hiển thị nút login
          ?>
        <div class="d-flex align-items-center">
          <a href="/login" class="btn btn-primary btn-xs " tabindex="-1" role="button" aria-disabled="true">Login</a>
        </div>
      <?php endif; ?>
      </a>
      <!-- Right elements -->
  </div>
  <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
  </div>