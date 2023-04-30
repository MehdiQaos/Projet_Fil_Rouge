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
        <div id="signin-card" class="card w-50 mx-auto mt-3 p-5">
            <div class="text-center pb-4 primary-text fs-3 fw-bold text-uppercase"><i class="fa-solid fa-chess me-2"></i>My Chess</div>
            <h3 class="text-center text-muted">Sign Up</h3>
            <form  method="POST" action="/users" class="container">
                @csrf
                <div class="row form-outline my-3 gap-1">
                    <input type="text" class="col form-control" placeholder="First name" name="first_name" required autofocus/>
                    <input type="text" class="col form-control" placeholder="Last name" name="last_name"/>
                    @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row form-outline my-3">
                    <input type="text" class="form-control" placeholder="User name" required name="user_name"/>
                    @error('user_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row form-outline my-3">
                    <input type="email" class="form-control" placeholder="Email" required name="email"/>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row form-outline my-3">
                    <input type="password" class="form-control" placeholder="Password" required name="password"/>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row form-outline my-3">
                    <input type="password" class="form-control" required placeholder="Repeat password" name="password_confirmation"/>
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="text-center fw-medium mb-3">Already have an account? <a class="text-black" href="/login"><span class="fw-semibold">Sign in</span></a></div>
                <div class="row d-flex justify-content-center text-center">
                    <button type="submit" id="login-button" class="btn p-2 mt-2 w-25" name="signup"><span class="text-light fw-bold">Sign Up</span></button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>