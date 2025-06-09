<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0"><?php echo $dane['ksiazka']->tytul; ?></h2>
                <div class="btn-group">
                    <a href="<?php echo BASE_URL; ?>/ksiazki/edytuj/<?php echo $dane['ksiazka']->id; ?>" 
                       class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edytuj
                    </a>
                    <button type="button" 
                            class="btn btn-danger" 
                            data-bs-toggle="modal" 
                            data-bs-target="#usunModal">
                        <i class="fas fa-trash"></i> Usuń
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Autor:</strong> <?php echo $dane['ksiazka']->autor; ?></p>
                        <p><strong>Rok wydania:</strong> <?php echo $dane['ksiazka']->rok_wydania; ?></p>
                        <p><strong>ISBN:</strong> <?php echo $dane['ksiazka']->isbn; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            <strong>Status:</strong>
                            <?php if($dane['ksiazka']->ilosc_dostepnych > 0): ?>
                                <span class="badge bg-success">Dostępna</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Wypożyczona</span>
                            <?php endif; ?>
                        </p>
                        <p><strong>Ilość dostępnych:</strong> <?php echo $dane['ksiazka']->ilosc_dostepnych; ?></p>
                        <p><strong>Data dodania:</strong> <?php echo date('d.m.Y', strtotime($dane['ksiazka']->data_dodania)); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Historia wypożyczeń</h3>
            </div>
            <div class="card-body">
                <?php if(!empty($dane['wypozyczenia'])): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Czytelnik</th>
                                    <th>Data wypożyczenia</th>
                                    <th>Data zwrotu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dane['wypozyczenia'] as $wypozyczenie): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/czytelnicy/szczegoly/<?php echo $wypozyczenie->czytelnik_id; ?>">
                                                <?php echo $wypozyczenie->imie . ' ' . $wypozyczenie->nazwisko; ?>
                                            </a>
                                        </td>
                                        <td><?php echo date('d.m.Y', strtotime($wypozyczenie->data_wypozyczenia)); ?></td>
                                        <td>
                                            <?php 
                                            if($wypozyczenie->data_zwrotu) {
                                                echo date('d.m.Y', strtotime($wypozyczenie->data_zwrotu));
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if($wypozyczenie->status == 'wypozyczone'): ?>
                                                <span class="badge bg-info">Wypożyczona</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Zwrócona</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Brak historii wypożyczeń dla tej książki.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Szybkie akcje</h3>
            </div>
            <div class="card-body">
                <?php if($dane['ksiazka']->ilosc_dostepnych > 0): ?>
                    <a href="<?php echo BASE_URL; ?>/wypozyczenia/wypozycz?ksiazka_id=<?php echo $dane['ksiazka']->id; ?>" 
                       class="btn btn-success btn-lg w-100 mb-3">
                        <i class="fas fa-book"></i> Wypożycz książkę
                    </a>
                <?php endif; ?>
                <a href="<?php echo BASE_URL; ?>/ksiazki" class="btn btn-secondary w-100">
                    <i class="fas fa-arrow-left"></i> Wróć do listy
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal potwierdzenia usunięcia -->
<div class="modal fade" id="usunModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Potwierdź usunięcie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Czy na pewno chcesz usunąć książkę "<?php echo $dane['ksiazka']->tytul; ?>"?
                <?php if(!empty($dane['wypozyczenia'])): ?>
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Uwaga: Ta książka ma historię wypożyczeń. Usunięcie może wpłynąć na integralność danych.
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <a href="<?php echo BASE_URL; ?>/ksiazki/usun/<?php echo $dane['ksiazka']->id; ?>" 
                   class="btn btn-danger">Usuń</a>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/templates/footer.php'; ?> 