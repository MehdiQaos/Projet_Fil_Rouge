<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Hospital | Home</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="One page parallax responsive HTML Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="best_group">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
</head>

<body id="body">
  <header class="navigation fixed-top">
    <div class="container ">
      <!-- main nav -->
      <nav class="navbar navbar-expand-lg navbar-light px-0 d-flex justify-content-between flex-column flex-sm-row">
        <!-- logo -->
        <a class="navbar-brand logo" href="/">
              <div class="sidebar-heading text-center py-4 fs-4 fw-bold text-uppercase color-2"><i
            class="fa-solid fa-chess me-2"></i>My Chess</div>
        </a>
        <div>
          <a href="/login" class="login btn btn-outline-success py-1"
            style="min-width:100px;border-color:#007A69;">Login</a>
          <a href="/register" class="login btn btn-success ms-3 py-1"
            style="min-width:100px;background-color:#007A69">Register</a>
        </div>
      </nav>
      <!-- /main nav -->
    </div>
  </header>
  <!--
End Fixed Navigation
====================== -->
  <div class="hero-slider">
    <div class="slider-item th-fullpage hero-area" style="background-image: url( {{ asset('assets/img/chessbg/hassan-pasha-nEbMedmVwgw-unsplash.jpg') }});">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1>Welcome To<br>
              Our Online Chess Platform!</h1>
            <p>
              We are thrilled to have you here and can't wait for you to explore all the exciting features!<br>
              Whether you're a seasoned chess player or just starting out, we've got everything you need to play, learn, and improve your skills.<br>
              our website has it all. So join us today and let's make some unforgettable chess moments together!<br>
            </p>
            <a class="btn btn-main" href="/guest">Play as Guest</a>
          </div>
        </div>
      </div>
    </div>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"></script>
</body>

</html>