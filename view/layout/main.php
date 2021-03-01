<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Boostrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Boostrap JS link -->
    <script defer src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <!-- Font Awesome link -->
    <script defer src="https://kit.fontawesome.com/42762d49f1.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./css/style.css">
    <script defer src="./js/app.js"></script>
    <title>Super Sports Club</title>
</head>

<body>


    <nav class="navbar navbar-expand-xl navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-dumbbell"></i> <strong>Super</strong>Sports</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" id="home">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item" id="comments">
                        <a class="nav-link" href="/comments">Comments About Us</a>
                    </li>
                    <?php if (!\app\core\Session::isUserLoggedIn()) : ?>
                        <li class="nav-item" id="register">
                            <a class="nav-link" href="/register">Register</a>
                        </li>
                        <li class="nav-item" id="login">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item" id="logout">
                            <a class="nav-link" href="/logout">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        {{content}}
    </div>

</body>

</html>