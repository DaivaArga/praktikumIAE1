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

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= esc($error) ?></div>
        <?php endif; ?>

        <form method="get" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari buku..."
                    value="<?= esc($search ?? '') ?>">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <a href="/" class="btn btn-secondary mb-3">Kembali ke Home</a>

        <?php if (!empty($books)): ?>
            <div class="row">
                <?php foreach ($books as $book): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($book['title'] ?? 'No Title') ?></h5>
                                <p class="card-text">Author: <?= esc($book['author'] ?? 'Unknown') ?></p>
                                <p class="card-text">ISBN: <?= esc($book['isbn'] ?? 'N/A') ?></p>
                                <a href="/books/<?= esc($book['id']) ?>" class="btn btn-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Tidak ada buku ditemukan.</p>
        <?php endif; ?>
    </div>
</body>

</html>