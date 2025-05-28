<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
?>
<body>
<style>
    body {
        background-color: #b09081;
        overflow-x: hidden;
        font-size: 14px;
        font-family: "DynaPuff", system-ui;
    }

    .fixed-layout {
        max-width: 1300px;
        margin: auto;
    }

    .dual-card {
        display: flex;
        gap: 20px;
    }

    .dual-card .card {
        flex: 1;
        height: 550px;
        overflow: hidden;
        background-color: #F7E6CA;
        padding: 10px;
        display: flex;
        flex-direction: column;
        font-size: 12px;
        position: relative;
    }

    .fixed-square {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 5px;
    }

    .table {
        table-layout: fixed;
        width: 100%;
    }

    .table th,
    .table td {
        padding: 4px 6px;
        vertical-align: middle;
        font-size: 12px;
        word-break: break-word;
    }

    .table th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 1;
        text-align: center;
    }

    /* Column width & wrapping for both product list and cart tables */
    .table td:nth-child(1),
    .table th:nth-child(1) {
        width: 100px;
        white-space: normal !important;
        word-wrap: break-word;
        word-break: break-word;
        text-align: left;
    }

    .table td:nth-child(2),
    .table th:nth-child(2) {
        width: 90px;
        text-align: center;
    }

    .table td:nth-child(3),
.table th:nth-child(3) {
    width: 100px; /* previously 120px */
    text-align: left;
    white-space: normal !important;
    word-break: break-word;
}

.table td:nth-child(4),
.table th:nth-child(4) {
    width: 80px; /* previously 60px */
    text-align: center;
}


    .table td:nth-child(5),
    .table th:nth-child(5) {
        width: 60px;
        text-align: center;
    }

    .qty {
        width: 40px;
        padding: 2px;
        text-align: center;
    }

    .btn {
        font-size: 11px;
        padding: 3px 8px;
    }

    .table-responsive {
        overflow-y: auto;
        overflow-x: hidden;
        flex: 1;
    }

    .card-footer {
        background: #f7e6ca;
        position: sticky;
        bottom: 0;
        padding: 15px 10px;
        z-index: 2;
        border-top: 1px solid #ccc;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-footer h4 {
        font-size: 20px;
        margin: 0;
        font-weight: bold;
        color: #333;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    .card-footer .btn-success {
        font-size: 16px;
        padding: 10px 20px;
        font-weight: bold;
    }
</style>

<!-- Sidebar -->
<?php require_once('partials/_sidebar.php'); ?>

<div class="main-content">
    <?php require_once('partials/_topnav.php'); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">

    <div style="background-image: url(assets/img/theme/bjes.png); background-size: cover;" class="header pb-8 pt-5 pt-md-9">
        <span class="mask bg-gradient-dark opacity-5"></span>
        <div class="container-fluid">
            <div class="header-body"></div>
        </div>
    </div>

    <div class="container-fluid mt--8 fixed-layout">
        <div class="card shadow p-3">
            <div class="dual-card">
                <!-- Select Products -->
                <div class="card">
                    <div class="card-header border-0">
                        <h3>Select Products</h3>
                        <input type="text" id="barcodeInput" class="form-control" placeholder="Scan barcode...">
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 55px;">Img</th>
                                    <th style="width: 90px;">Barcode</th>
                                    <th style="width: 120px;">Name</th>
                                    <th style="width: 60px;">Price</th>
                                    <th style="width: 60px;">Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM rpos_products";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($prod = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><img src="/RestaurantPOS/Restro/admin/assets/img/products/<?= $prod->prod_img ?: 'default.jpg'; ?>" class="fixed-square"></td>
                                        <td><?= $prod->barcode; ?></td>
                                        <td><?= $prod->prod_name; ?></td>
                                        <td>P <?= $prod->prod_price; ?></td>
                                        <td><button class="btn btn-sm btn-warning add-to-cart" data-id="<?= $prod->prod_id; ?>" data-name="<?= $prod->prod_name; ?>" data-price="<?= $prod->prod_price; ?>">Add</button></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Cart -->
                <div class="card">
                    <div class="card-header border-0">
                        <h3>Cart</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>SubTotal</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody id="cart-body"></tbody>
                        </table>
                    </div>
                    <div class="card-footer text-right">
                        <h4>Grand Total: P<span id="totalPrice">0.00</span></h4>
                        <button class="btn btn-success" id="checkout">Checkout</button>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once('partials/_footer.php'); ?>
    </div>
</div>

<?php require_once('partials/_scripts.php'); ?>

<script>
    let cart = {};

    function updateCart() {
    let cartBody = document.getElementById('cart-body');
    let totalPrice = 0;
    cartBody.innerHTML = '';

    let entries = Object.entries(cart).reverse();
    for (let [id, item] of entries) {
        totalPrice += item.price * item.qty;
        cartBody.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td><input type='number' class='form-control qty' data-id='${id}' value='${item.qty}'></td>
                <td>P${item.price.toFixed(2)}</td>
                <td>P${(item.price * item.qty).toFixed(2)}</td>
                <td><button class='btn btn-danger btn-sm remove-item' data-id='${id}'>X</button></td>
            </tr>`;
    }
    document.getElementById('totalPrice').innerText = totalPrice.toFixed(2);
}

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            let id = button.getAttribute('data-id');
            let name = button.getAttribute('data-name');
            let price = parseFloat(button.getAttribute('data-price'));
            if (cart[id]) {
                cart[id].qty += 1;
            } else {
                cart[id] = { name, price, qty: 1 };
            }
            updateCart();
        });
    });

    document.getElementById('cart-body').addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-item')) {
            let id = e.target.getAttribute('data-id');
            delete cart[id];
            updateCart();
        }
    });

    document.getElementById('cart-body').addEventListener('input', (e) => {
        if (e.target.classList.contains('qty')) {
            let id = e.target.getAttribute('data-id');
            let qty = parseInt(e.target.value);
            if (qty > 0) {
                cart[id].qty = qty;
            } else {
                delete cart[id];
            }
            updateCart();
        }
    });

    document.getElementById('barcodeInput').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            let barcode = e.target.value;
            fetch(`fetch_product.php?barcode=${barcode}`)
                .then(response => response.json())
                .then(product => {
                    if (product) {
                        let id = product.prod_id;
                        if (cart[id]) {
                            cart[id].qty += 1;
                        } else {
                            cart[id] = {
                                name: product.prod_name,
                                price: parseFloat(product.prod_price),
                                qty: 1
                            };
                        }
                        updateCart();
                    }
                });
            e.target.value = '';
        }
    });

    document.getElementById('checkout').addEventListener('click', () => {
        let cartData = JSON.stringify(cart);
        fetch('save_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: cartData
        }).then(response => response.json()).then(data => {
            if (data.success) {
                window.location.href = 'payments.php';
            } else {
                console.error("Error storing cart data");
            }
        });
    });
</script>
</body>
</html>
