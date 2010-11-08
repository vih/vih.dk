<table id="table-okonomi" summary="Ugepriser på Vejle Idrætshøjskole, økonomi">
    <caption>Elevbetaling</caption>
    <thead>
        <tr>
            <th scope="col" id="kursusth">Kursus</th>
            <th scope="col" id="ugepristh">Ugepris</th>
            <th scope="col" id="gebyrth">Materialegebyr</th>
            <th scope="col" id="rejseth">Rejsepris</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="5">Ret til ændringer forbeholdes. Alle skal på en rejse af kortere varighed. Der opkræves et ekstra beløb til rejser.</td>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach ($kurser AS $kursus): ?>
        <tr>
            <th scope="row" headers="kursusth"><?php e($kursus->getKursusNavn()); ?></th>
            <td headers="ugepristh"><?php e(number_format($kursus->get("pris_uge"), 0, ',', '.')); ?></td>
            <td headers="gebyrth"><?php e(number_format($kursus->get("pris_materiale"), 0, ',', '.')); ?></td>
            <td scope="row" headers="rejseth"><?php e(number_format($kursus->get("pris_rejsedepositum"), 0, ',', '.')); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>