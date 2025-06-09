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
            <button onclick="window.print()" class="btn btn-info">
                <i class="fas fa-print"></i> Drukuj
            </button>
        </div>
    </div>

    <!-- Общая статистика -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Wszystkie wypożyczenia</h5>
                    <p class="card-text display-4"><?php echo $dane['statystyki']->wszystkie_wypozyczenia; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Aktywne wypożyczenia</h5>
                    <p class="card-text display-4"><?php echo $dane['statystyki']->aktywne_wypozyczenia; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Przeterminowane</h5>
                    <p class="card-text display-4"><?php echo $dane['statystyki']->przeterminowane; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Średni czas wypożyczenia</h5>
                    <p class="card-text display-4"><?php echo round($dane['statystyki']->sredni_czas_wypozyczenia); ?> dni</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Статистика за месяц -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Statystyki za <?php echo date('m.Y'); ?></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h5 class="card-title">Nowe wypożyczenia</h5>
                            <p class="card-text display-4"><?php echo $dane['miesiac']['wypozyczenia']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body">
                            <h5 class="card-title">Nowe książki</h5>
                            <p class="card-text display-4"><?php echo $dane['miesiac']['ksiazki']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-info">
                        <div class="card-body">
                            <h5 class="card-title">Nowi czytelnicy</h5>
                            <p class="card-text display-4"><?php echo $dane['miesiac']['czytelnicy']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Последние выдачи -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Ostatnie wypożyczenia</h5>
        </div>
        <div class="card-body">
            <?php if(!empty($dane['ostatnie'])): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Książka</th>
                                <th>Czytelnik</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dane['ostatnie'] as $wypozyczenie): ?>
                                <tr>
                                    <td><?php echo date('d.m.Y', strtotime($wypozyczenie->data_wypozyczenia)); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($wypozyczenie->tytul); ?>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars($wypozyczenie->autor); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($wypozyczenie->imie . ' ' . $wypozyczenie->nazwisko); ?></td>
                                    <td>
                                        <?php if($wypozyczenie->data_zwrotu): ?>
                                            <span class="badge bg-success">Zwrócone</span>
                                        <?php else: 
                                            $dni = 30 - floor((time() - strtotime($wypozyczenie->data_wypozyczenia)) / (60 * 60 * 24));
                                            if($dni > 0): ?>
                                                <span class="badge bg-primary"><?php echo $dni; ?> dni</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Przeterminowane</span>
                                            <?php endif;
                                        endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-0">
                    Brak wypożyczeń.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Просроченные выдачи -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Przeterminowane wypożyczenia</h5>
        </div>
        <div class="card-body">
            <?php if(!empty($dane['przeterminowane'])): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Książka</th>
                                <th>Czytelnik</th>
                                <th>Data wypożyczenia</th>
                                <th>Dni po terminie</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dane['przeterminowane'] as $wypozyczenie): ?>
                                <tr>
                                    <td>
                                        <?php echo htmlspecialchars($wypozyczenie->tytul); ?>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars($wypozyczenie->autor); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($wypozyczenie->imie . ' ' . $wypozyczenie->nazwisko); ?></td>
                                    <td><?php echo date('d.m.Y', strtotime($wypozyczenie->data_wypozyczenia)); ?></td>
                                    <td>
                                        <span class="badge bg-danger">
                                            <?php echo $wypozyczenie->dni_po_terminie; ?> dni
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-success mb-0">
                    Brak przeterminowanych wypożyczeń.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require VIEWROOT . '/templates/footer.php'; ?> 