<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($dane['title']) ? $dane['title'] : SITENAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .nav-link {
            color: rgba(255,255,255,.75) !important;
        }
        .nav-link:hover {
            color: rgba(255,255,255,1) !important;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .btn-group-sm > .btn {
            margin-right: 2px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <i class="fas fa-book-reader"></i> <?php echo SITENAME; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/ksiazki">
                            <i class="fas fa-book"></i> Książki
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/czytelnicy">
                            <i class="fas fa-users"></i> Czytelnicy
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/wypozyczenia">
                            <i class="fas fa-exchange-alt"></i> Wypożyczenia
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container"><?php if(isset($dane['blad'])): ?>
        <div class="alert alert-danger"><?php echo $dane['blad']; ?></div>
    <?php endif; ?> 