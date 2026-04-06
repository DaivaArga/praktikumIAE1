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

        <a href="/members" class="btn btn-secondary mb-3">Kembali ke Daftar Member</a>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= esc($error) ?></div>
        <?php elseif ($member): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= esc($member['name'] ?? 'No Name') ?></h5>
                    <p><strong>Member Code:</strong> <?= esc($member['member_code'] ?? 'N/A') ?></p>
                    <p><strong>Email:</strong> <?= esc($member['email'] ?? 'N/A') ?></p>
                    <p><strong>Phone:</strong> <?= esc($member['phone'] ?? 'N/A') ?></p>
                    <p><strong>Address:</strong> <?= esc($member['address'] ?? 'N/A') ?></p>
                    <p><strong>Status:</strong> <?= esc($member['status'] ?? 'N/A') ?></p>
                    <p><strong>Joined At:</strong> <?= esc($member['joined_at'] ?? 'N/A') ?></p>
                </div>
            </div>
        <?php else: ?>
            <p>Member tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</body>

</html>