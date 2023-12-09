<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: index.php");
    exit;
}
?>
<?php include 'layouts/headers.php'; ?>
<div class="container-fluid bg-success" style="height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-6 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h3 text-gray-900 mb-4 text-bold">Welcome Back Admin!</h1>
                                </div>
                                <form class="user" action="./functions/login_func.php" method="POST">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="username"
                                            placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                            placeholder="Password" name="password">
                                    </div>

                                    <input class="btn btn-success btn-user btn-block" type="submit" value="Login" />

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>