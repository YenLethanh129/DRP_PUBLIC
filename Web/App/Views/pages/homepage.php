<? require($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/header.php") ?>
<body>
    <div class="homepage">
        <div class="container minspace mb-3">
            <div class="content d-flex align-items-start mt-3">
                <? $mainRecipe = $data[0]; ?>
                <div class="main-content flex-fill mb-3" style="position: sticky; top: 1rem">
                    <div class="card" style="width: 45vw; height: 50rem">
                        <a> 
                         <img src="<?php echo ($mainRecipe->getImgUrl()) ? '/Public/uploads/recipes/' . $mainRecipe->getImgUrl() : '/Public/images/image_not_found.png' ?>" 
                            alt="Recipe Image" class="card-img-top" alt="Picture of meal" style="object-fit: cover; height: 32rem">
                        </a>
                        <div class="card-body">
                            <h4 class="card-title"><? echo $mainRecipe->getName() ?></h4>
                            <p class="card-text limited-text" style="height:4rem; overflow: hidden"><? echo $mainRecipe->getDescription() ?></p>
                            <div class="author-info d-flex align-items-center">
                                <img src="https://i.pinimg.com/564x/8f/1a/b1/8f1ab1e2ef48c2a26de7df6e977930bd.jpg" alt="">
                                <div class="des">
                                    <h5>By Mary Maris</h5>
                                    <span>Updated March 13, 2024</span>
                                </div>
                            </div>
                            <p class="card-text"><small class="text-muted">Date: <? echo $mainRecipe->getTimestamp() ?></small></p>
                            <a href="/recipe" class="btn btn-primary mb-1">Get recipe</a>
                        </div>
                    </div>
                </div>
                <?php array_shift($data); ?>
                <div class="nav-content flex-fill ms-3">
                    <? foreach ($data as $recipe) : ?>
                        <a href="<?php echo '/recipe/detail?id=' . $recipe->getId() ?>"  class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="<?php echo ($recipe->getImgUrl()) ? '/Public/uploads/recipes/' . $recipe->getImgUrl() : '/Public/images/image_not_found.png' ?>" class="card-img-bottom" alt="Picture of meal" style="object-fit: cover; height:12rem">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><? echo htmlspecialchars($recipe->getName()); ?></h5>
                                        <p class="card-text limited-text"><? echo $recipe->getDescription() ?></p>
                                        <p class="card-text"><small class="text-muted">Date: <? echo $recipe->getTimestamp() ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
<body>
    <div class="aboutus m-3">
        <div class="container bg mb-3">
            <h3 class="p-2 pt-3" >ABOUT TEAM 3</h3>
            <div class="content d-flex flex-column text-center align-items-center flex-md-row text-center text-md-start justify-content-around py-0 px-4 px-xl-5">
                <div class="mb-md-0 m-3 d-flex align-items-center flex-column">
                    <img class="contribute-img" src="https://i.pinimg.com/564x/8f/1a/b1/8f1ab1e2ef48c2a26de7df6e977930bd.jpg" alt="Contribute">
                    <h5>Mạch Tiến Duy</h5>
                    <p>Admin system</p>
                </div>
                <div class="mb-md-0 m-3 d-flex align-items-center flex-column">
                    <img class="contribute-img" src="https://i.pinimg.com/564x/81/aa/e4/81aae4c00d5e30f0210d855e05be11ac.jpg" alt="Contribute">
                    <h5>Võ Thị Bích Tuyền</h5>
                    <p>Contribute writer</p>
                </div>
                <div class="mb-md-0 m-3 d-flex align-items-center flex-column">
                    <img class="contribute-img" src="https://i.pinimg.com/564x/d7/a5/eb/d7a5eb7de8524da196dda005d47386b2.jpg" alt="Contribute">
                    <h5>Trần Quang Diệu</h5>
                    <p>Leader</p>
                </div>
                <div class="mb-md-0 m-3 d-flex align-items-center flex-column">
                    <img class="contribute-img" src="https://i.pinimg.com/564x/36/b5/6d/36b56d1a4c5f2350d23661dff439f6bb.jpg" alt="Contribute">
                    <h5>Lê Thanh Yên</h5>
                    <p>Contribute writer</p>
                </div>
                <div class="mb-md-0 m-3 d-flex align-items-center flex-column">
                    <img class="contribute-img" src="https://i.pinimg.com/736x/21/f9/6e/21f96e2bf0e2fee80bbf91a3ecf7a987.jpg" alt="Contribute">
                    <h5>Ngô Nguyễn Hạnh Phúc</h5>
                    <p>Database</p>
                </div>
            </div>
        </div>
    </div>    

<style>
.bg {
    display: block;
    width: 100%;
    height: 230px;
    background-color: #ffff;
    border-radius: 10px
}
.contribute-img{
    width: 50px;
    height: 50px;
    border-radius:50%;
}
</style>

<?php require($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/footer.php"); ?>