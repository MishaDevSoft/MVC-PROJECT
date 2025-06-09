<?php require VIEWROOT . '/templates/header.php'; ?>

<div class="container">
    <!-- Статистика -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Książki</h5>
                    <p class="card-text display-4"><?php echo $dane['statystyki']['liczba_ksiazek'] ?? 0; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Czytelnicy</h5>
                    <p class="card-text display-4"><?php echo $dane['statystyki']['liczba_czytelnikow'] ?? 0; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Aktywne wypożyczenia</h5>
                    <p class="card-text display-4"><?php echo $dane['statystyki']['aktywne_wypozyczenia'] ?? 0; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Przeterminowane</h5>
                    <p class="card-text display-4"><?php echo $dane['statystyki']['przeterminowane'] ?? 0; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Ostatnio dodane książki -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ostatnio dodane książki</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php if(!empty($dane['ostatnie_ksiazki'])): ?>
                            <?php foreach($dane['ostatnie_ksiazki'] as $ksiazka): ?>
                                <a href="<?php echo BASE_URL; ?>/ksiazki/szczegoly/<?php echo $ksiazka->id; ?>" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($ksiazka->tytul); ?></h6>
                                        <small><?php echo htmlspecialchars($ksiazka->autor); ?></small>
                                    </div>
                                    <small class="text-muted">
                                        Dostępne: <?php echo $ksiazka->ilosc_dostepnych; ?>
                                    </small>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-info mb-0">Brak ostatnio dodanych książek</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Ostatnie wypożyczenia -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ostatnie wypożyczenia</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php if(!empty($dane['ostatnie_wypozyczenia'])): ?>
                            <?php foreach($dane['ostatnie_wypozyczenia'] as $wypozyczenie): ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($wypozyczenie->tytul); ?></h6>
                                        <small><?php echo date('d.m.Y', strtotime($wypozyczenie->data_wypozyczenia)); ?></small>
                                    </div>
                                    <p class="mb-1">
                                        Czytelnik: <?php echo htmlspecialchars($wypozyczenie->imie . ' ' . $wypozyczenie->nazwisko); ?>
                                    </p>
                                    <small class="text-muted">
                                        Termin zwrotu: <?php echo date('d.m.Y', strtotime($wypozyczenie->data_wypozyczenia . ' +30 days')); ?>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-info mb-0">Brak ostatnich wypożyczeń</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Najpopularniejsze książki -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Najpopularniejsze książki</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($dane['najpopularniejsze'])): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tytuł</th>
                                        <th>Autor</th>
                                        <th>Liczba wypożyczeń</th>
                                        <th>Dostępne</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($dane['najpopularniejsze'] as $ksiazka): ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>/ksiazki/szczegoly/<?php echo $ksiazka->id; ?>">
                                                    <?php echo htmlspecialchars($ksiazka->tytul); ?>
                                                </a>
                                            </td>
                                            <td><?php echo htmlspecialchars($ksiazka->autor); ?></td>
                                            <td><?php echo $ksiazka->liczba_wypozyczen; ?></td>
                                            <td>
                                                <?php if($ksiazka->ilosc_dostepnych > 0): ?>
                                                    <span class="badge bg-success"><?php echo $ksiazka->ilosc_dostepnych; ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Brak</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">Brak danych o popularności książek</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require VIEWROOT . '/templates/footer.php'; ?> 