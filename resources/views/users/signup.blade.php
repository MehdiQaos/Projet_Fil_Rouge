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
            <form  method="POST" action="/users" class="container" data-parsley-validate>
                @csrf
                <div class="row form-outline my-3 gap-1">
                    <input type="text" id="firstname-input" class="col form-control" placeholder="First name" name="first_name" required data-parsley-trigger="keyup" autofocus/>
                    <input type="text" id="lastname-input" class="col form-control" placeholder="Last name" name="last_name"/>
                </div>
                <div class="row form-outline my-3">
                    <input type="text" id="username-input" class="form-control" placeholder="User name" required data-parsley-trigger="keyup" name="user_name"/>
                </div>
                <div class="row form-outline my-3">
                    <input type="email" id="email-input" class="form-control" placeholder="Email" required data-parsley-trigger="keyup" name="email"/>
                </div>
                <div class="row form-outline my-3">
                    <input type="password" id="password-input" class="form-control" placeholder="Password" required data-parsley-trigger="keyup" name="password"/>
                </div>
                <div class="row form-outline my-3">
                    <input type="password" id="password-repeated-input" class="form-control" required data-parsley-trigger="keyup" placeholder="Repeat password" name="password_confirmation"/>
                </div>
                <div class="row d-flex justify-content-center text-center">
                    <button type="submit" id="login-button" class="btn p-2 mt-2 w-25" name="signup"><span class="text-light fw-bold">Sign Up</span></button>
                </div>
            </form>
        </div>
    </section>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
</body>
</html>