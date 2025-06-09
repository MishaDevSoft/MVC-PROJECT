<?php require VIEWROOT . '/templates/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="error-template">
                <h1 class="display-1">404</h1>
                <h2>Strona nie została znaleziona</h2>
                <div class="error-details mb-4">
                    Przepraszamy, ale strona której szukasz nie istnieje lub została przeniesiona.
                </div>
                <div class="error-actions">
                    <a href="<?php echo BASE_URL; ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-home"></i> Strona główna
                    </a>
                    <a href="<?php echo BASE_URL; ?>/ksiazki" class="btn btn-secondary btn-lg">
                        <i class="fas fa-book"></i> Lista książek
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-template {
    padding: 40px 15px;
}
.error-actions {
    margin-top: 15px;
    margin-bottom: 15px;
}
.error-actions .btn {
    margin-right: 10px;
}
</style>

<?php require VIEWROOT . '/templates/footer.php'; ?> 