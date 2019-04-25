<?php
$pageTitle = 'Shopping Cart';
require('parts/header.php');
?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="Checkout">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Shopping Cart <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Shipping Details</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Payment Options</a>
                </li>
            </ul>
        </div>
    </nav>

    <hr class="mb-4">

    <div class="col-md-4 order-md-2 mb-4">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Summary</span>
            <span class="badge badge-secondary badge-pill">3</span>
        </h4>
        <ul class="list-group mb-3">

            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <div class="col-md-4">
                        <img src="..." class="card-img" alt="...">
                    </div>
                    <h6 class="my-0">Product name</h6>
                    <small class="text-muted">Brief description</small>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Amount</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01">
                            <option selected>Choose...</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <span class="text-muted">$12</span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <div class="col-md-4">
                        <img src="..." class="card-img" alt="...">
                    </div>
                    <h6 class="my-0">Second product</h6>
                    <small class="text-muted">Brief description</small>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Amount</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01">
                            <option selected>Choose...</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <span class="text-muted">$8</span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <div class="col-md-4">
                        <img src="../../resources/images/dog.jpg" class="card-img" alt="...">
                    </div>
                    <h6 class="my-0">Third item</h6>
                    <small class="text-muted">Brief description</small>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Amount</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01">
                            <option selected>Choose...</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <span class="text-muted">$5</span>
            </li>

            <li class="list-group-item d-flex justify-content-between">
                <span>Total (USD)</span>
                <strong>$20</strong>
            </li>

        </ul>
        <hr class="mb-4">

        <button class="btn btn-primary" type="submit">Next</button>
        <button class="btn btn-secondary" type="submit">Cancel</button>
    </div>


</div>
<?php require('parts/footer.php'); ?>