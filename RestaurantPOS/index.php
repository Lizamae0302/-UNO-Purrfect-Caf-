<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restro POS System</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">


    <!-- Styles -->
    <style>
        html,
        body {
            background: url('bgg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: rgb(0, 98, 147);
            font-family: "DynaPuff";
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
            background: rgba(255, 255, 255, 0.85);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease-in-out;
        }

        .content:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .logo {
            max-width: 300px;
            margin-bottom: 10px;
        }

        .tagline {
            font-size: 20px;
            font-weight: 600;
            color: rgb(211, 128, 80);
            margin-bottom: 40px;
            animation: fadeIn 2s ease;
        }

        .links > a {
            color: white;
            background-color: rgb(0, 98, 147);
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-decoration: none;
            text-transform: uppercase;
            transition: background 0.3s ease;
        }

        .links > a:hover {
            background-color: rgb(0, 80, 120);
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }

            .logo {
                max-width: 220px;
            }

            .tagline {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <img src="logoo.png" alt="Purrfect Cafe Logo" class="logo">
            <div class="tagline">Taste it! Lick it! Purrfect!</div>
            <div class="links">
                <a href="Restro/admin/">Log In</a>
            </div>
        </div>
    </div>
</body>

</html>
