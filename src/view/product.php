<?php
$pageTitle = 'Product';
require('parts/header.php');
?>

    <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="..." class="card-img" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Product title</h5>
                    <p class="card-text">Product description</p>
                    <p class="card-text">Price: 200$</p>
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
                    <a href="#" class="btn btn-primary">Add to cart</a>
                </div>
            </div>
        </div>
    </div>


</div>
<?php require('parts/footer.php');?>