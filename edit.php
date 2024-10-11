<?php
$postId = isset($_GET['id']) ? $_GET['id'] : null;
$posts = json_decode(file_get_contents('posts.json'), true);

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

// Handle form submission for updating the post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update the post content
    $post['title'] = $_POST['title'];
    $post['content'] = $_POST['content'];
    $post['date'] = date('Y-m-d H:i:s'); // Update the date

    // Save the updated post back to the array
    foreach ($posts as $key => $p) {
        if ($p['id'] == $postId) {
            $posts[$key] = $post; // Update the post
            break;
        }
    }

    // Write back to the JSON file
    file_put_contents('posts.json', json_encode($posts, JSON_PRETTY_PRINT));

    // Redirect to the updated post
    header("Location: post.php?id={$postId}");
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
    <title>Edit Post - <?= htmlspecialchars($post['title']); ?></title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Edit</a>
        </div>
    </nav>
    <!-- Page content-->
    <div class="container">
        <h1 class="my-4">Edit</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($post['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?= htmlspecialchars($post['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php';">Cancel</button>
        </form>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
