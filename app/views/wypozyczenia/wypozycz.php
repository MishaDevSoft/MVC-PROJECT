<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Nowe wypożyczenie</h2>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>/wypozyczenia/wypozycz" method="POST">
                    <?php if(isset($_GET['ksiazka_id'])): ?>
                        <input type="hidden" name="ksiazka_id" value="<?php echo $_GET['ksiazka_id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Wybrana książka</label>
                            <input type="text" class="form-control" value="<?php echo $dane['ksiazka']->tytul; ?>" disabled>
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <label for="ksiazka_id" class="form-label">Książka</label>
                            <select class="form-select" id="ksiazka_id" name="ksiazka_id" required>
                                <option value="">Wybierz książkę...</option>
                                <?php foreach($dane['ksiazki'] as $ksiazka): ?>
                                    <?php if($ksiazka->ilosc_dostepnych > 0): ?>
                                        <option value="<?php echo $ksiazka->id; ?>">
                                            <?php echo $ksiazka->tytul; ?> (<?php echo $ksiazka->autor; ?>)
                                            - dostępnych: <?php echo $ksiazka->ilosc_dostepnych; ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($_GET['czytelnik_id'])): ?>
                        <input type="hidden" name="czytelnik_id" value="<?php echo $_GET['czytelnik_id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Wybrany czytelnik</label>
                            <input type="text" class="form-control" 
                                   value="<?php echo $dane['czytelnik']->imie . ' ' . $dane['czytelnik']->nazwisko; ?>" 
                                   disabled>
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <label for="czytelnik_id" class="form-label">Czytelnik</label>
                            <select class="form-select" id="czytelnik_id" name="czytelnik_id" required>
                                <option value="">Wybierz czytelnika...</option>
                                <?php foreach($dane['czytelnicy'] as $czytelnik): ?>
                                    <option value="<?php echo $czytelnik->id; ?>">
                                        <?php echo $czytelnik->imie . ' ' . $czytelnik->nazwisko; ?>
                                        <?php if(isset($czytelnik->aktywne_wypozyczenia) && $czytelnik->aktywne_wypozyczenia > 0): ?>
                                            (<?php echo $czytelnik->aktywne_wypozyczenia; ?> aktywnych wypożyczeń)
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="data_wypozyczenia" class="form-label">Data wypożyczenia</label>
                        <input type="date" class="form-control" id="data_wypozyczenia" name="data_wypozyczenia" 
                               value="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-book"></i> Wypożycz książkę
                        </button>
                        <a href="<?php echo BASE_URL; ?>/wypozyczenia" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Anuluj
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/templates/footer.php'; ?> 