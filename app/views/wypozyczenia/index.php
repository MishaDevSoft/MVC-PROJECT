<?php require VIEWROOT . '/templates/header.php'; ?>

<div class="container">
    <?php if(isset($dane['blad'])): ?>
        <div class="alert alert-danger">
            <?php echo $dane['blad']; ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?php echo $dane['title']; ?></h1>
        <div>
            <a href="<?php echo BASE_URL; ?>/wypozyczenia/wypozycz" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nowe wypożyczenie
            </a>
            <a href="<?php echo BASE_URL; ?>/wypozyczenia/raport" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> Raport
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if(!empty($dane['wypozyczenia'])): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Książka</th>
                                <th>Czytelnik</th>
                                <th>Data wypożyczenia</th>
                                <th>Pozostało dni</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dane['wypozyczenia'] as $wypozyczenie): ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>/ksiazki/szczegoly/<?php echo $wypozyczenie->ksiazka_id; ?>">
                                            <?php echo htmlspecialchars($wypozyczenie->tytul); ?>
                                        </a>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars($wypozyczenie->autor); ?></small>
                                    </td>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>/czytelnicy/szczegoly/<?php echo $wypozyczenie->czytelnik_id; ?>">
                                            <?php echo htmlspecialchars($wypozyczenie->imie . ' ' . $wypozyczenie->nazwisko); ?>
                                        </a>
                                    </td>
                                    <td><?php echo date('d.m.Y', strtotime($wypozyczenie->data_wypozyczenia)); ?></td>
                                    <td>
                                        <?php
                                        $dni = 30 - floor((time() - strtotime($wypozyczenie->data_wypozyczenia)) / (60 * 60 * 24));
                                        if($dni > 0): ?>
                                            <span class="badge bg-success"><?php echo $dni; ?> dni</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Przeterminowane (<?php echo abs($dni); ?> dni)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo BASE_URL; ?>/wypozyczenia/zwroc/<?php echo $wypozyczenie->id; ?>" 
                                               class="btn btn-sm btn-success" 
                                               data-bs-toggle="tooltip" 
                                               title="Zwróć">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    Brak aktywnych wypożyczeń.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require VIEWROOT . '/templates/footer.php'; ?> 