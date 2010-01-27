<table id="table-okonomi" summary="Ugepriser p� Vejle Idr�tsh�jskole, �konomi">
    <caption>Elevbetaling</caption>
    <thead>
        <tr>
            <th scope="col" id="kursusth">Kursus</th>
            <th scope="col" id="ugepristh">Ugepris</th>
            <th scope="col" id="gebyrth">Materialegebyr</th>
            <th scope="col" id="rejseth">Rejsedepositum</th>
            <th scope="col" id="noegleth">N�gledepositum</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="5">Ret til �ndringer forbeholdes. Alle skal p� en rejse af kortere varighed. Der opkr�ves et ekstra bel�b til rejser. Ugeprisen for rejselinjen g�lder kun i den tid, rejselinjen er p� h�jskolen. Hvad betalingen er for selve rejsen, afh�nger af       valutakurserne, men du kan altid ringe til skolen og f� oplyst den forventede pris p� n�ste �rs rejselinje.
            </td>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach ($kurser AS $kursus): ?>
        <tr>
            <th scope="row" headers="kursusth"><?php e($kursus->getKursusNavn()); ?></th>
            <td headers="ugepristh"><?php e(number_format($kursus->get("pris_uge"), 0, ',', '.')); ?></td>
            <td headers="gebyrth"><?php e(number_format($kursus->get("pris_materiale"), 0, ',', '.')); ?></td>
            <td scope="row" headers="rejseth"><?php e(number_format($kursus->get("pris_rejsedepositum"), 0, ',', '.')); ?></td>
            <td scope="row" headers="noegleth"><?php e(number_format($kursus->get("pris_noegledepositum"), 0, ',', '.')); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>