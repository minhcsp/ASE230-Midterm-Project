<?php
$posts = json_decode(file_get_contents('posts.json'), true);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Portfolio</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Portfolio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    
                    <!-- Conditionally show buttons based on user's login status -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="signout.php">Sign Out</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="signin.php">Sign In</a></li>
                        <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page header with logo and tagline-->
    <header class="py-5 bg-light border-bottom mb-4">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder">Welcome to My Portfolio!</h1>
                <p class="lead mb-0">A place to store and showcase my abilities</p>
            </div>
        </div>
    </header>

    <!-- Page content-->
    <div class="container">
        <div class="row justify-content-center"> <!-- Center the row -->
            <!-- Blog entries-->
            <div class="col-lg-10">
                <!-- Featured blog post-->
                <?php if (!empty($posts)): ?>
                    <div class="card mb-4 text-center">
                        <a href="post.php?id=<?= $posts[0]['id']; ?>"><img class="card-img-top" src="<?= $posts[0]['image']; ?>" alt="..." /></a>
                        <div class="card-body">
                            <div class="small text-muted"><?= $posts[0]['date']; ?></div>
                            <h2 class="card-title"><?= $posts[0]['title']; ?></h2>
                            <p class="card-text"><?= substr($posts[0]['content'], 0, 100); ?>...</p>
                            <a class="btn btn-primary" href="post.php?id=<?= $posts[0]['id']; ?>">Read more →</a>                                
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row justify-content-center">
                    <?php foreach (array_slice($posts, 1) as $post): ?>
                        <div class="col-lg-6 col-md-8 mb-4">
                            <!-- Blog post-->
                            <div class="card">
                                <a href="post.php?id=<?= $post['id']; ?>"><img class="card-img-top" src="<?= $post['image']; ?>" alt="..." /></a>
                                <div class="card-body text-center"> <!-- Added text-center to center the content -->
                                    <div class="small text-muted"><?= $post['date']; ?></div>
                                    <h2 class="card-title h4"><?= $post['title']; ?></h2>
                                    <p class="card-text"><?= substr($post['content'], 0, 100); ?>...</p>
                                    <a class="btn btn-primary" href="post.php?id=<?= $post['id']; ?>">Read more →</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Create Post Button - Only show if user is signed in -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="text-center mt-4">
                        <a class="btn btn-success" href="create.php">Create a Post</a>
                    </div>
                <?php endif; ?>

                <!-- Add spacing under the button -->
                <div class="mt-5"></div> <!-- Extra space -->
            </div>
            <!-- Side widgets and footer here -->
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-4">
        <div class="container text-center">
            <p class="mb-0">© <?= date("Y"); ?> minh</p>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>
