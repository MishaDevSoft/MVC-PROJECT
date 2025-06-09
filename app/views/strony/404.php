<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 text-center">
            <h1 class="display-1">404</h1>
            <h2 class="mb-4"><?php echo $dane['tytul']; ?></h2>
            <p class="lead mb-5"><?php echo $dane['opis']; ?></p>
            <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">
                <i class="fas fa-home"></i> Wróć do strony głównej
            </a>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/templates/footer.php'; ?> 