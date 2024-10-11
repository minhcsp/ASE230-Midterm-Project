<?php
session_start();

// Check if the user is signed in; if not, redirect to the sign-in page
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

// Initialize variables for the form
$title = '';
$date = date('Y-m-d H:i:s'); // Default to current date
$image = '';
$content = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted data and sanitize it
    $title = htmlspecialchars(trim($_POST['title']));
    $date = htmlspecialchars(trim($_POST['date']));
    $image = htmlspecialchars(trim($_POST['image']));
    $content = htmlspecialchars(trim($_POST['content']));

    // Read existing posts
    $posts = json_decode(file_get_contents('posts.json'), true);

    // Create a new post array
    $newPost = [
        'id' => count($posts) + 1, // Assign a new ID
        'title' => $title,
        'date' => $date,
        'image' => $image,
        'content' => $content,
        'author' => $_SESSION['username'] // Include the username of the author
    ];

    // Add the new post to the array
    $posts[] = $newPost;

    // Write the updated posts back to the JSON file
    file_put_contents('posts.json', json_encode($posts, JSON_PRETTY_PRINT));

    // Redirect to the home page after creation
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Create a New Post</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#!">Start Bootstrap</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Create a New Post</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Post Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($title) ?>" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="text" class="form-control" id="date" name="date" value="<?= htmlspecialchars($date) ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image URL</label>
                <input type="url" class="form-control" id="image" name="image" value="<?= htmlspecialchars($image) ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?= htmlspecialchars($content) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Post</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php';">Cancel</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
