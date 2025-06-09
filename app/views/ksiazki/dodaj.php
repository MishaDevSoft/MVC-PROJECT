<?php require VIEWROOT . '/templates/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Dodaj nową książkę</h2>
                </div>
                <div class="card-body">
                    <?php if(isset($dane['blad'])): ?>
                        <div class="alert alert-danger"><?php echo $dane['blad']; ?></div>
                    <?php endif; ?>

                    <?php if(isset($dane['bledy']) && !empty($dane['bledy'])): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach($dane['bledy'] as $blad): ?>
                                    <li><?php echo $blad; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>/ksiazki/dodaj" method="POST">
                        <div class="mb-3">
                            <label for="tytul" class="form-label">Tytuł</label>
                            <input type="text" class="form-control" id="tytul" name="tytul" 
                                   value="<?php echo isset($dane['dane']['tytul']) ? $dane['dane']['tytul'] : ''; ?>" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="autor" class="form-label">Autor</label>
                            <input type="text" class="form-control" id="autor" name="autor" 
                                   value="<?php echo isset($dane['dane']['autor']) ? $dane['dane']['autor'] : ''; ?>" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="rok_wydania" class="form-label">Rok wydania</label>
                            <input type="number" class="form-control" id="rok_wydania" name="rok_wydania" 
                                   value="<?php echo isset($dane['dane']['rok_wydania']) ? $dane['dane']['rok_wydania'] : date('Y'); ?>" 
                                   min="1" max="<?php echo date('Y'); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" 
                                   value="<?php echo isset($dane['dane']['isbn']) ? $dane['dane']['isbn'] : ''; ?>" 
                                   pattern="[0-9]{13}" title="ISBN powinien składać się z 13 cyfr">
                        </div>

                        <div class="mb-3">
                            <label for="ilosc_dostepnych" class="form-label">Ilość dostępnych</label>
                            <input type="number" class="form-control" id="ilosc_dostepnych" name="ilosc_dostepnych" 
                                   value="<?php echo isset($dane['dane']['ilosc_dostepnych']) ? $dane['dane']['ilosc_dostepnych'] : '1'; ?>" 
                                   min="0" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Dodaj książkę</button>
                            <a href="<?php echo BASE_URL; ?>/ksiazki" class="btn btn-secondary">Anuluj</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require VIEWROOT . '/templates/footer.php'; ?> 