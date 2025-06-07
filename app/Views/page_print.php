<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
<table>
    <tr>
        <th>No</th>
        <th>tipe test</th>
        <th>hasil</th>
        <th>tanggal test</th>
    </tr>
    <?php $no = 1;
    foreach ($riwayat as $b) : ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $b['id_test']; ?></td>
            <td><?= $b['hasil']; ?></td>
            <td><?= dateFormat('Y/m/d h:i:s', $b['created_at']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>