<!-- customer_display.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Customer Display</title>
    <style>
        body {
            background-color: #f7e6ca;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Your Order</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody id="display-cart-body">
        </tbody>
    </table>
    <h3 style="text-align:right;">Total: $<span id="displayTotal">0.00</span></h3>

    <script>
        function updateCustomerDisplay() {
            let cart = JSON.parse(localStorage.getItem('pos_cart') || '{}');
            let displayBody = document.getElementById('display-cart-body');
            let total = 0;
            displayBody.innerHTML = '';
            for (let id in cart) {
                let item = cart[id];
                let subtotal = item.qty * item.price;
                total += subtotal;
                displayBody.innerHTML += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.qty}</td>
                        <td>$${item.price.toFixed(2)}</td>
                        <td>$${subtotal.toFixed(2)}</td>
                    </tr>`;
            }
            document.getElementById('displayTotal').innerText = total.toFixed(2);
        }

        window.addEventListener('storage', updateCustomerDisplay);
        window.onload = updateCustomerDisplay;
    </script>
</body>
</html>
