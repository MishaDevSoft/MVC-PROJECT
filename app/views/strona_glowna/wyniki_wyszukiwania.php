<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container mt-4">
    <h1>Wyniki wyszukiwania dla: "<?php echo htmlspecialchars($fraza); ?>"</h1>

    <?php if (!empty($wyniki['ksiazki']) || !empty($wyniki['czytelnicy'])): ?>
        
        <?php if (!empty($wyniki['ksiazki'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="h5 mb-0">Znalezione książki</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tytuł</th>
                                    <th>Autor</th>
                                    <th>ISBN</th>
                                    <th>Dostępność</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($wyniki['ksiazki'] as $ksiazka): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($ksiazka->tytul); ?></td>
                                        <td><?php echo htmlspecialchars($ksiazka->autor); ?></td>
                                        <td><?php echo htmlspecialchars($ksiazka->isbn); ?></td>
                                        <td>
                                            <?php if ($ksiazka->ilosc_dostepnych > 0): ?>
                                                <span class="badge badge-success">Dostępna</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Wypożyczona</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/ksiazki/szczegoly/<?php echo $ksiazka->id; ?>" 
                                               class="btn btn-sm btn-info">
                                                Szczegóły
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

        <?php if (!empty($wyniki['czytelnicy'])): ?>
            <div class="card">
                <div class="card-header">
                    <h2 class="h5 mb-0">Znalezieni czytelnicy</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Imię i nazwisko</th>
                                    <th>Email</th>
                                    <th>Telefon</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($wyniki['czytelnicy'] as $czytelnik): ?>
                                    <tr>
                                        <td>
                                            <?php echo htmlspecialchars($czytelnik->imie . ' ' . $czytelnik->nazwisko); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($czytelnik->email); ?></td>
                                        <td><?php echo htmlspecialchars($czytelnik->telefon); ?></td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/czytelnicy/szczegoly/<?php echo $czytelnik->id; ?>" 
                                               class="btn btn-sm btn-info">
                                                Szczegóły
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

    <?php else: ?>
        <div class="alert alert-info">
            Nie znaleziono żadnych wyników dla podanej frazy wyszukiwania.
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="<?php echo BASE_URL; ?>" class="btn btn-secondary">Powrót do strony głównej</a>
    </div>
</div>

<?php require APPROOT . '/views/templates/footer.php'; ?> 