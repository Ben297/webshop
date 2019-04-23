<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
            integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o"
            crossorigin="anonymous"></script>
    <title>Webshop Product</title>
</head>
<body>
<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Webshop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Products</a>
                </li>
            </ul>

            <form class="form-inline my-2 my-lg-0">
                <button class="btn btn-outline-secondary" type="button">Shopping Cart</button>
                <button class="btn btn-outline-success" type="button">Suscribe / Login</button>
            </form>

        </div>

    </nav>

    <form>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">Email</label>
                <input type="email" class="form-control" id="inputEmail" placeholder="Email">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword">Password</label>
                <input type="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword">Confirm Password</label>
                <input type="password" class="form-control" id="inputPasswordConfirm" placeholder="Password">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputfirstname">First Name</label>
                <input type="text" class="form-control" id="inputfirstname" placeholder="Max">
            </div>
            <div class="form-group col-md-6">
                <label for="inputlastname">Last Name</label>
                <input type="text" class="form-control" id="inputhousenr" placeholder="Mustermann">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="inputStreename">Streetname</label>
                <input type="text" class="form-control" id="inputStreename" placeholder="Teststraße">
            </div>
            <div class="form-group col-md-4">
                <label for="inputhousenr">Housenumber</label>
                <input type="text" class="form-control" id="inputhousenr" placeholder="42">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6 mb-3">
                <label for="inputZip">Zip</label>
                <input type="text" class="form-control" id="inputZip" placeholder="12345">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="inputCity">City</label>
                <input type="text" class="form-control" id="inputCity" placeholder="Kiel">
            </div>
        </div>
            <hr class="mb-4">
            <button type="submit" class="btn btn-primary">Sign in</button>

    </form>


</div>
</body>
</html>