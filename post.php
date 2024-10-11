<?php
session_start();

// Get post ID from the query string
$postId = isset($_GET['id']) ? $_GET['id'] : null;

// Read posts from JSON file
$posts = json_decode(file_get_contents('posts.json'), true);

// Find the post by ID
$post = null;
foreach ($posts as $p) {
    if ($p['id'] == $postId) {
        $post = $p;
        break;
    }
}

if (!$post) {
    die("Post not found!");
}

// Handle form submissions for deletion or editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        // Remove the post from the posts array
        $posts = array_filter($posts, fn($p) => $p['id'] != $postId);

        // Re-index the array to maintain consistent IDs
        $posts = array_values($posts);

        // Write back to the JSON file with pretty printing
        file_put_contents('posts.json', json_encode($posts, JSON_PRETTY_PRINT));

        // Redirect to the posts listing page after deletion
        header('Location: index.php');
        exit;
    } elseif (isset($_POST['action']) && $_POST['action'] === 'edit') {
        // Redirect to the edit page
        header("Location: edit.php?id={$postId}");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= htmlspecialchars($post['title']); ?> - Blog Post</title>
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

    <!-- Page content-->
    <div class="container">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">
                <article>
                    <h1 class="fw-bolder"><?= htmlspecialchars($post['title']); ?></h1>
                    <div class="small text-muted"><?= htmlspecialchars($post['date']); ?></div>
                    <img class="img-fluid rounded mb-4" src="<?= htmlspecialchars($post['image']); ?>" alt="..." />
                    <p><?= nl2br(htmlspecialchars($post['content'])); ?></p>
                </article>
                <!-- Buttons for editing and deleting the post -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form method="POST" action="" class="d-inline">
                        <input type="hidden" name="action" value="delete">
                        <input type="submit" value="Delete Post" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">
                    </form>
                    <form method="POST" action="" class="d-inline">
                        <input type="hidden" name="action" value="edit">
                        <input type="submit" value="Edit Post" class="btn btn-warning">
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>
