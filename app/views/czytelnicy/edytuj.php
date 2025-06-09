<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Edytuj czytelnika</h2>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>/czytelnicy/edytuj/<?php echo $dane['czytelnik']->id; ?>" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="imie" class="form-label">Imię</label>
                            <input type="text" class="form-control" id="imie" name="imie" 
                                   value="<?php echo $dane['czytelnik']->imie; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nazwisko" class="form-label">Nazwisko</label>
                            <input type="text" class="form-control" id="nazwisko" name="nazwisko" 
                                   value="<?php echo $dane['czytelnik']->nazwisko; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo $dane['czytelnik']->email; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefon" class="form-label">Telefon</label>
                        <input type="tel" class="form-control" id="telefon" name="telefon" 
                               value="<?php echo $dane['czytelnik']->telefon; ?>"
                               pattern="[0-9]{9}" title="Numer telefonu musi zawierać 9 cyfr">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Zapisz zmiany
                        </button>
                        <a href="<?php echo BASE_URL; ?>/czytelnicy/szczegoly/<?php echo $dane['czytelnik']->id; ?>" 
                           class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Anuluj
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/templates/footer.php'; ?> 