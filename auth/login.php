<!DOCTYPE html>
<html>
<head>
    <title>Login Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
        }

        body {
            background: linear-gradient(to right, black, #8B0000);
        }

        .wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        footer {
            background: black;
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>

<body>

<div class="wrapper">

    <!-- CONTENT -->
    <div class="content">

        <div class="card p-4 shadow text-center" style="width: 350px; border-radius:15px;">

            <!-- LOGO TENGAH PERFECT -->
            <img src="../assets/logo.jpeg" width="100" class="d-block mx-auto mb-3">

            <h4 class="mb-3 text-danger fw-bold">Rumah Makan Karian</h4>

            <form method="POST" action="proses_login.php">
                <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

                <button class="btn btn-danger w-100">Login</button>
            </form>

        </div>

    </div>

    <!-- FOOTER -->
    <footer>
        © 2026 - Andre Radhitya | Rafif Rizki Naufal | Yuda Wahyu
    </footer>

</div>

</body>
</html>