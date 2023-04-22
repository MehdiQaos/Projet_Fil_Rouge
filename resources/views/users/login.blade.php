<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <script defer src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
    <title>Document</title>
</head>
<body>
    <section class="vh-100" id="wrapper">
        <div id="signin-card" class="card w-50 mx-auto mt-5 p-5">
            <div class="text-center pb-4 primary-text fs-3 fw-bold text-uppercase"><i class="fa-solid fa-chess me-2"></i>My Chess</div>
            <h3 class="text-center text-muted">Sign In</h3>
            <form  method="POST" action="/users/authenticate" class="container">
                @csrf
                <div class="row form-outline my-3">
                    <input type="text" id="email_input" class="form-control" placeholder="Email" name="email"/>
                </div>
                <div class="row form-outline my-3">
                    <input type="password" id="password_input" class="form-control" placeholder="Password" name="password"/>
                </div>
                <div class="row text-center d-flex justify-content-center">
                    <button type="submit" id="login-button" class="btn p-2 my-0 mt-4 w-25" name="login"><span class="text-light fw-bold">Sign In</span></button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>