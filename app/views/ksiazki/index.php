<?php require VIEWROOT . '/templates/header.php'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Książki</h1>
        <a href="<?php echo BASE_URL; ?>/ksiazki/dodaj" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj książkę
        </a>
    </div>

    <?php if(isset($dane['blad'])): ?>
        <div class="alert alert-danger"><?php echo $dane['blad']; ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tytuł</th>
                    <th>Autor</th>
                    <th>Rok wydania</th>
                    <th>ISBN</th>
                    <th>Dostępne</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dane['ksiazki'] as $ksiazka): ?>
                    <tr>
                        <td>
                            <a href="<?php echo BASE_URL; ?>/ksiazki/szczegoly/<?php echo $ksiazka->id; ?>">
                                <?php echo $ksiazka->tytul; ?>
                            </a>
                        </td>
                        <td><?php echo $ksiazka->autor; ?></td>
                        <td><?php echo $ksiazka->rok_wydania; ?></td>
                        <td><?php echo $ksiazka->isbn; ?></td>
                        <td>
                            <?php if($ksiazka->ilosc_dostepnych > 0): ?>
                                <span class="badge bg-success"><?php echo $ksiazka->ilosc_dostepnych; ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger">Brak</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>/ksiazki/edytuj/<?php echo $ksiazka->id; ?>" 
                               class="btn btn-sm btn-warning" title="Edytuj">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo BASE_URL; ?>/ksiazki/usun/<?php echo $ksiazka->id; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Czy na pewno chcesz usunąć tę książkę?')" 
                               title="Usuń">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require VIEWROOT . '/templates/footer.php'; ?> 