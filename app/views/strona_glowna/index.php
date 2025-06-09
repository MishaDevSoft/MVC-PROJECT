<?php require VIEWROOT . '/templates/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Książki</h5>
                <p class="card-text display-6"><?php echo $dane['statystyki']['liczba_ksiazek']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Czytelnicy</h5>
                <p class="card-text display-6"><?php echo $dane['statystyki']['liczba_czytelnikow']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Aktywne wypożyczenia</h5>
                <p class="card-text display-6"><?php echo $dane['statystyki']['aktywne_wypozyczenia']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Przeterminowane</h5>
                <p class="card-text display-6"><?php echo $dane['statystyki']['przeterminowane']; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Ostatnio dodane książki</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <?php foreach($dane['ostatnie_ksiazki'] as $ksiazka): ?>
                        <a href="<?php echo BASE_URL; ?>/ksiazki/szczegoly/<?php echo $ksiazka->id; ?>" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><?php echo $ksiazka->tytul; ?></h6>
                                <small><?php echo $ksiazka->autor; ?></small>
                            </div>
                            <small>Dodano: <?php echo date('d.m.Y', strtotime($ksiazka->data_dodania)); ?></small>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Ostatnie wypożyczenia</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <?php foreach($dane['ostatnie_wypozyczenia'] as $wypozyczenie): ?>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><?php echo $wypozyczenie->tytul; ?></h6>
                                <small><?php echo date('d.m.Y', strtotime($wypozyczenie->data_wypozyczenia)); ?></small>
                            </div>
                            <p class="mb-1">Czytelnik: <?php echo $wypozyczenie->imie . ' ' . $wypozyczenie->nazwisko; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Najpopularniejsze książki</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tytuł</th>
                                <th>Autor</th>
                                <th>Liczba wypożyczeń</th>
                                <th>Dostępność</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dane['najpopularniejsze'] as $ksiazka): ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>/ksiazki/szczegoly/<?php echo $ksiazka->id; ?>">
                                            <?php echo $ksiazka->tytul; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $ksiazka->autor; ?></td>
                                    <td><?php echo $ksiazka->liczba_wypozyczen; ?></td>
                                    <td>
                                        <?php if($ksiazka->ilosc_dostepnych > 0): ?>
                                            <span class="badge bg-success">Dostępna</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Wypożyczona</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require VIEWROOT . '/templates/footer.php'; ?> 