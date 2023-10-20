<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - EPrescribe</title>
    <link href="./resources/css/styles.css" rel="stylesheet" />
    <script src="./resources/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                            <div id="alert_success" style="display: none" class="alert alert-success alert-dismissible fade show" role="alert">

                            </div>
                            <div id="alert_failed" style="display: none" class="alert alert-danger alert-dismissible fade show" role="alert">

                            </div>
                            <div class="card-body">
                                <form id="login_form">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="email" id="email" type="email" placeholder="name@example.com" />
                                        <label for="inputEmail">Email address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="password" id="password" type="password" placeholder="Password" />
                                        <label for="inputPassword">Password</label>
                                        <input type="hidden" name="action" id="action" value="login">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <a class="small" href="forgot-password">Forgot Password?</a>
                                        <input class="btn btn-primary" type="submit" value="Login">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; EPrescribe 2023</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="./resources/vendor/components/jquery/jquery.min.js"></script>
<script src="./resources/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="./resources/js/scripts.js"></script>
<script src="script.js"></script>
</body>
</html>
