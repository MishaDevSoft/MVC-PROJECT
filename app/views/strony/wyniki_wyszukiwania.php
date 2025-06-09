<?php require VIEWROOT . '/templates/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Wyniki wyszukiwania dla: "<?php echo htmlspecialchars($dane['fraza']); ?>"</h2>
            
            <?php if(empty($dane['ksiazki']) && empty($dane['czytelnicy']) && empty($dane['wypozyczenia'])): ?>
                <div class="alert alert-info">
                    Nie znaleziono żadnych wyników.
                </div>
            <?php else: ?>
                <!-- Książki -->
                <?php if(!empty($dane['ksiazki'])): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Książki</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tytuł</th>
                                            <th>Autor</th>
                                            <th>Rok wydania</th>
                                            <th>Dostępne</th>
                                            <th>Akcje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($dane['ksiazki'] as $ksiazka): ?>
                                            <tr>
                                                <td><?php echo $ksiazka->tytul; ?></td>
                                                <td><?php echo $ksiazka->autor; ?></td>
                                                <td><?php echo $ksiazka->rok_wydania; ?></td>
                                                <td>
                                                    <?php if($ksiazka->ilosc_dostepnych > 0): ?>
                                                        <span class="badge bg-success"><?php echo $ksiazka->ilosc_dostepnych; ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Brak</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo BASE_URL; ?>/ksiazki/szczegoly/<?php echo $ksiazka->id; ?>" 
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-info-circle"></i> Szczegóły
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Czytelnicy -->
                <?php if(!empty($dane['czytelnicy'])): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Czytelnicy</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Imię i nazwisko</th>
                                            <th>Email</th>
                                            <th>Telefon</th>
                                            <th>Akcje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($dane['czytelnicy'] as $czytelnik): ?>
                                            <tr>
                                                <td><?php echo $czytelnik->imie . ' ' . $czytelnik->nazwisko; ?></td>
                                                <td><?php echo $czytelnik->email; ?></td>
                                                <td><?php echo $czytelnik->telefon; ?></td>
                                                <td>
                                                    <a href="<?php echo BASE_URL; ?>/czytelnicy/szczegoly/<?php echo $czytelnik->id; ?>" 
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-info-circle"></i> Szczegóły
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Wypożyczenia -->
                <?php if(!empty($dane['wypozyczenia'])): ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Wypożyczenia</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Książka</th>
                                            <th>Czytelnik</th>
                                            <th>Data wypożyczenia</th>
                                            <th>Termin zwrotu</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($dane['wypozyczenia'] as $wypozyczenie): ?>
                                            <tr>
                                                <td><?php echo $wypozyczenie->tytul; ?></td>
                                                <td><?php echo $wypozyczenie->imie . ' ' . $wypozyczenie->nazwisko; ?></td>
                                                <td><?php echo date('d.m.Y', strtotime($wypozyczenie->data_wypozyczenia)); ?></td>
                                                <td><?php echo date('d.m.Y', strtotime($wypozyczenie->data_wypozyczenia . ' +30 days')); ?></td>
                                                <td>
                                                    <?php if($wypozyczenie->status == 'wypozyczone'): ?>
                                                        <span class="badge bg-warning">Wypożyczone</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">Zwrócone</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require VIEWROOT . '/templates/footer.php'; ?> 