<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0"><?php echo $dane['czytelnik']->imie . ' ' . $dane['czytelnik']->nazwisko; ?></h2>
                <div class="btn-group">
                    <a href="<?php echo BASE_URL; ?>/czytelnicy/edytuj/<?php echo $dane['czytelnik']->id; ?>" 
                       class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edytuj
                    </a>
                    <?php if(!isset($dane['czytelnik']->aktywne_wypozyczenia) || $dane['czytelnik']->aktywne_wypozyczenia == 0): ?>
                        <button type="button" 
                                class="btn btn-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#usunModal">
                            <i class="fas fa-trash"></i> Usuń
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Email:</strong> <?php echo $dane['czytelnik']->email; ?></p>
                        <p><strong>Telefon:</strong> <?php echo $dane['czytelnik']->telefon; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Data rejestracji:</strong> <?php echo date('d.m.Y', strtotime($dane['czytelnik']->data_rejestracji)); ?></p>
                        <p>
                            <strong>Status:</strong>
                            <?php if(isset($dane['czytelnik']->aktywne_wypozyczenia) && $dane['czytelnik']->aktywne_wypozyczenia > 0): ?>
                                <span class="badge bg-info">
                                    <?php echo $dane['czytelnik']->aktywne_wypozyczenia; ?> aktywnych wypożyczeń
                                </span>
                            <?php else: ?>
                                <span class="badge bg-success">Brak aktywnych wypożyczeń</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#aktywne">
                            Aktywne wypożyczenia
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#historia">
                            Historia wypożyczeń
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="aktywne">
                        <?php if(!empty($dane['wypozyczenia'])): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Książka</th>
                                            <th>Data wypożyczenia</th>
                                            <th>Status</th>
                                            <th>Akcje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($dane['wypozyczenia'] as $wypozyczenie): ?>
                                            <?php if($wypozyczenie->status == 'wypozyczone'): ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo BASE_URL; ?>/ksiazki/szczegoly/<?php echo $wypozyczenie->ksiazka_id; ?>">
                                                            <?php echo $wypozyczenie->tytul; ?>
                                                        </a>
                                                        <br>
                                                        <small class="text-muted"><?php echo $wypozyczenie->autor; ?></small>
                                                    </td>
                                                    <td><?php echo date('d.m.Y', strtotime($wypozyczenie->data_wypozyczenia)); ?></td>
                                                    <td>
                                                        <?php
                                                        $dni = floor((time() - strtotime($wypozyczenie->data_wypozyczenia)) / (60 * 60 * 24));
                                                        if($dni > 30): ?>
                                                            <span class="badge bg-danger">Przeterminowane (<?php echo $dni; ?> dni)</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-success">Aktywne (<?php echo $dni; ?> dni)</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="<?php echo BASE_URL; ?>/wypozyczenia/zwroc/<?php echo $wypozyczenie->id; ?>" 
                                                               class="btn btn-sm btn-success">
                                                                <i class="fas fa-check"></i> Zwróć
                                                            </a>
                                                            <a href="<?php echo BASE_URL; ?>/wypozyczenia/przedluz/<?php echo $wypozyczenie->id; ?>" 
                                                               class="btn btn-sm btn-info">
                                                                <i class="fas fa-clock"></i> Przedłuż
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Brak aktywnych wypożyczeń.</p>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="historia">
                        <?php if(!empty($dane['historia'])): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Książka</th>
                                            <th>Data wypożyczenia</th>
                                            <th>Data zwrotu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($dane['historia'] as $wypozyczenie): ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo BASE_URL; ?>/ksiazki/szczegoly/<?php echo $wypozyczenie->ksiazka_id; ?>">
                                                        <?php echo $wypozyczenie->tytul; ?>
                                                    </a>
                                                    <br>
                                                    <small class="text-muted"><?php echo $wypozyczenie->autor; ?></small>
                                                </td>
                                                <td><?php echo date('d.m.Y', strtotime($wypozyczenie->data_wypozyczenia)); ?></td>
                                                <td><?php echo date('d.m.Y', strtotime($wypozyczenie->data_zwrotu)); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Brak historii wypożyczeń.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Szybkie akcje</h3>
            </div>
            <div class="card-body">
                <a href="<?php echo BASE_URL; ?>/wypozyczenia/wypozycz?czytelnik_id=<?php echo $dane['czytelnik']->id; ?>" 
                   class="btn btn-success btn-lg w-100 mb-3">
                    <i class="fas fa-book"></i> Nowe wypożyczenie
                </a>
                <a href="<?php echo BASE_URL; ?>/czytelnicy" class="btn btn-secondary w-100">
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
                Czy na pewno chcesz usunąć czytelnika "<?php echo $dane['czytelnik']->imie . ' ' . $dane['czytelnik']->nazwisko; ?>"?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <a href="<?php echo BASE_URL; ?>/czytelnicy/usun/<?php echo $dane['czytelnik']->id; ?>" 
                   class="btn btn-danger">Usuń</a>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/templates/footer.php'; ?> 