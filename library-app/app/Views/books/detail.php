<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1><?= esc($title) ?></h1>

        <a href="/books" class="btn btn-secondary mb-3">Kembali ke Daftar Buku</a>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= esc($error) ?></div>
        <?php elseif ($book): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= esc($book['title'] ?? 'No Title') ?></h5>
                    <p><strong>Author:</strong> <?= esc($book['author'] ?? 'Unknown') ?></p>
                    <p><strong>ISBN:</strong> <?= esc($book['isbn'] ?? 'N/A') ?></p>
                    <p><strong>Category:</strong> <?= esc($book['category'] ?? 'N/A') ?></p>
                    <p><strong>Publisher:</strong> <?= esc($book['publisher'] ?? 'N/A') ?></p>
                    <p><strong>Year:</strong> <?= esc($book['year'] ?? 'N/A') ?></p>
                    <p><strong>Stock:</strong> <?= esc($book['stock'] ?? 'N/A') ?></p>
                    <p><strong>Description:</strong> <?= esc($book['description'] ?? 'N/A') ?></p>
                </div>
            </div>
        <?php else: ?>
            <p>Buku tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</body>

</html>