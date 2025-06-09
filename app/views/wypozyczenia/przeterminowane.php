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
            <a href="<?php echo BASE_URL; ?>/wypozyczenia" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Powrót
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
                                <th>Dni po terminie</th>
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
                                        <span class="badge bg-danger">
                                            <?php echo $wypozyczenie->dni_po_terminie; ?> dni
                                        </span>
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
                <div class="alert alert-success">
                    Brak przeterminowanych wypożyczeń.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require VIEWROOT . '/templates/footer.php'; ?> 