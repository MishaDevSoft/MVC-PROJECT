<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container mt-4">
    <h1>Statystyki biblioteki</h1>
    <div class="row">
        <div class="col-md-12 mb-4">
            <form class="form-inline">
                <select name="miesiac" class="form-control mr-2">
                    <?php
                    $nazwy_miesiecy = [
                        '01' => 'Styczeń', '02' => 'Luty', '03' => 'Marzec',
                        '04' => 'Kwiecień', '05' => 'Maj', '06' => 'Czerwiec',
                        '07' => 'Lipiec', '08' => 'Sierpień', '09' => 'Wrzesień',
                        '10' => 'Październik', '11' => 'Listopad', '12' => 'Grudzień'
                    ];
                    foreach ($nazwy_miesiecy as $nr => $nazwa) {
                        $selected = $nr == $miesiac ? 'selected' : '';
                        echo "<option value=\"$nr\" $selected>$nazwa</option>";
                    }
                    ?>
                </select>
                <select name="rok" class="form-control mr-2">
                    <?php
                    $rok_biezacy = date('Y');
                    for ($r = $rok_biezacy; $r >= $rok_biezacy - 5; $r--) {
                        $selected = $r == $rok ? 'selected' : '';
                        echo "<option value=\"$r\" $selected>$r</option>";
                    }
                    ?>
                </select>
                <button type="submit" class="btn btn-primary">Pokaż</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Wypożyczenia w miesiącu</h5>
                </div>
                <div class="card-body">
                    <p>Liczba wypożyczeń: <?php echo $statystyki['wypozyczenia']['liczba']; ?></p>
                    <p>Średni czas wypożyczenia: <?php echo $statystyki['wypozyczenia']['sredni_czas']; ?> dni</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Nowi czytelnicy</h5>
                </div>
                <div class="card-body">
                    <p>Liczba nowych czytelników: <?php echo $statystyki['nowi_czytelnicy']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Nowe książki</h5>
                </div>
                <div class="card-body">
                    <p>Dodano nowych książek: <?php echo $statystyki['nowe_ksiazki']; ?></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Najpopularniejsze kategorie</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($statystyki['top_kategorie'])): ?>
                        <ul class="list-unstyled">
                            <?php foreach ($statystyki['top_kategorie'] as $kategoria): ?>
                                <li><?php echo $kategoria['nazwa']; ?> - <?php echo $kategoria['liczba']; ?> wypożyczeń</li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Brak danych o kategoriach w tym miesiącu.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/templates/footer.php'; ?> 