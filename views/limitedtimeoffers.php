<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONOMICHI</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* Container with shared background */
        .background {
            background: url('path/to/your/background-image.jpg') no-repeat center center;
            background-size: cover;
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Optional semi-transparent overlay */
        }

        nav {
            display: flex;
            gap: 20px;
        }

        nav a {
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }

        main {
            flex: 1;
            padding: 20px;
            color: #333;
        }

        .menu {
            display: none; /* Hide initially */
            position: absolute;
            top: 60px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .menu ul {
            list-style: none;
            padding: 10px;
        }

        .menu ul li {
            margin: 5px 0;
        }

        .menu ul li a {
            text-decoration: none;
            color: #000;
        }

        .menu img {
            max-width: 100%;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body>
    <div class="background">
        <header>
            <div class="logo">
                <img src="path/to/logo.png" alt="Logo">
            </div>
            <nav>
                <a href="#services">Services</a>
                <a href="#products">Products</a>
                <a href="#about">About</a>
            </nav>
        </header>
        
        <main>
            <h1>A Seamless Design for All</h1>
            <p>Retirement is a journey... make it meaningful with Five Pathways Financial.</p>
        </main>
        
        <footer>
            <p>&copy; 2024 MONOMICHI. All Rights Reserved.</p>
        </footer>
    </div>
</body>
</html>
