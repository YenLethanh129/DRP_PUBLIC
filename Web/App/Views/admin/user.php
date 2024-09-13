<? require($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/header.php")?>

<div class="container-fluid py-5" style="width: 100%;">
    <div class="text-center">
        <h1>Manager User</h1>
    </div>
    
    <div class="row g-0 justify-content-center">
        
        <!-- SEARCH AND TABLE-->
        <div class="col-auto" style="padding: 20px;
                                border: 1px solid #e1ebfa; border-radius: 10px; 
                                box-shadow: 0 0 10px 0 #e1ebfa; margin-top: 40px; margin-bottom: 50px;">   
            <h4 class="mb-3" style="width: auto;">
                <span>List user</span>
            </h4>

            <div class="row g-2 ">
                <div class="col">
                    <form action="/manager/user" method="GET" class="row g-3 d-flex justify-content-between flex-fill">
                        <div class="col-2">
                            <input type="text" class="form-control" id="id" name="id" placeholder="ID...">
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control w-200" id="username" name="username" placeholder="Username...">
                        </div>
                        <div class="col-4">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email...">
                        </div>
                        <div class="col-2">
                            <button class="btn btn-success" name="search" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row g-0 py-1">
                <table class="table table-bordered nav">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Date of birth</th>
                        <th scope="col">Email</th>
                        <th scope="col">Gender</th>   
                        <th scope="col">BMI</th>         
                        <th scope="col">Level</th>
                        <th scope="col">Actions</th>
                    </tr>
                    <?php $count = 0; 
                    if(!is_array($users)){
                        $users = [$users];
                    }

                    foreach ($users as $user): 
                        if ($user->getLevel() > 1):
                            $count++;
                            if ($count > 10):
                                break;
                            endif;?>
                        <tr>
                            <td><?= $user->getId() ?></td>
                            <td><?= $user->getUsername() ?></td>
                            <td><?= $user->getFirstName()?></td>
                            <td><?= $user->getLastName()?></td>
                            <td><?= $user->getDateOfBirth()?></td>
                            <td><?= $user->getEmail() ?></td>
                            <td><?= $user->getGender()?></td>
                            <td><?= $user->getBMI_index() ?></td>
                            <td><?= $user->getLevel() ?></td>
                            <td>
                                <!-- btn: Set Contribute, Unset Contribute and Is Ban -->
                                <?php if ($user->getLevel() == 3): ?>
                                    <form class="d-inline-block" action="/manager/user" method="POST">
                                        <input type="hidden" name="id" value="<?= $user->getId() ?>">
                                        <input type="hidden" name="level" value="2">
                                        <button class="btn btn-success" style="width: 170px" type="submit">Set Contributor</button>
                                    </form>
                                <?php elseif ($user->getLevel() == 2): ?>
                                    <form class="d-inline-block" action="/manager/user" method="POST">
                                        <input type="hidden" name="id" value="<?= $user->getId() ?>">
                                        <input type="hidden" name="level" value="3">
                                        <button class="btn btn-warning" style="width: 170px" type="submit">Unset Contributor</button>
                                    </form>
                                <?php else: ?>
                                    <button class="d-inline-block btn btn-outline-danger" style="width: 170px" disabled>Is Ban</button>
                                <?php endif; ?>
                                
                                <!-- btn: Edit user -->

                                <a href="/manager/user/update?id=<?= $user->getId() ?>" class="btn btn-secondary d-inline-block" role="button">Edit</a>
                                <!-- btn: Ban and Unban -->
                                <?php if ($user->getLevel() != 4): ?>
                                    <form class="d-inline-block" action="/manager/user" method="POST">
                                        <input type="hidden" name="id" value="<?= $user->getId() ?>">
                                        <input type="hidden" name="level" value="4">
                                        <button class="btn btn-danger" style="width: 100px" type="submit">Ban</button>
                                    </form>  
                                <?php elseif ($user->getLevel() == 4): ?>
                                    <form class="d-inline-block" action="/manager/user" method="POST">
                                        <input type="hidden" name="id" value="<?= $user->getId() ?>">
                                        <input type="hidden" name="level" value="3">
                                        <button class="btn btn-info" style="width: 100px" type="submit">Unban</button>
                                    </form>
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <!-- ADD -->
        <div class="col-auto" style="padding: 20px; max-height: 400px;
                                border: 1px solid #e1ebfa; border-radius: 10px; 
                                box-shadow: 0 0 10px 0 #e1ebfa; margin-top: 40px; margin-bottom: 50px;">   
            <h4 class="mb-3" style="width: auto;">
                <span>Add new user</span>
            </h4>
            <form id="sign-up-form" action="/manager/user/add" method="POST">   
                <div>
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>
                <div>
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div>
                    <label for="repassword" class="form-label">Repassword</label>
                    <input type="password" class="form-control" id="repassword" name="repassword">
                </div>
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="d-grid gap-2 d-md-block">
                    <button class="btn btn-success" name="update" type="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
    <div class="d-md-flex justify-content-center py-3" >
        <a href="/manager" class="btn btn-secondary me-md-2" tabindex="-1" role="button" style="width: 10%;">Back</a>
    </div>   
</div>

<? require($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/footer.php")?>  
<script src="/Public/js/validate-signup.js"></script>