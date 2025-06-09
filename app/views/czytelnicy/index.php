<?php require VIEWROOT . '/templates/header.php'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?php echo $dane['title']; ?></h1>
        <a href="<?php echo BASE_URL; ?>/czytelnicy/dodaj" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj czytelnika
        </a>
    </div>

    <?php if(isset($dane['blad'])): ?>
        <div class="alert alert-danger">
            <?php echo $dane['blad']; ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imię i nazwisko</th>
                            <th>Email</th>
                            <th>Telefon</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($dane['czytelnicy']) && !empty($dane['czytelnicy'])): ?>
                            <?php foreach($dane['czytelnicy'] as $czytelnik): ?>
                                <tr>
                                    <td><?php echo $czytelnik->id; ?></td>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>/czytelnicy/szczegoly/<?php echo $czytelnik->id; ?>">
                                            <?php echo $czytelnik->imie . ' ' . $czytelnik->nazwisko; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $czytelnik->email; ?></td>
                                    <td><?php echo $czytelnik->telefon; ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?php echo BASE_URL; ?>/czytelnicy/szczegoly/<?php echo $czytelnik->id; ?>" 
                                               class="btn btn-info" 
                                               title="Szczegóły">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/czytelnicy/edytuj/<?php echo $czytelnik->id; ?>" 
                                               class="btn btn-warning" 
                                               title="Edytuj">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/czytelnicy/usun/<?php echo $czytelnik->id; ?>" 
                                               class="btn btn-danger" 
                                               title="Usuń"
                                               onclick="return confirm('Czy na pewno chcesz usunąć tego czytelnika?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Brak czytelników w bazie danych</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require VIEWROOT . '/templates/footer.php'; ?> 