<h4 class="text-primary text-center p-5">
    <p>LAPORAN MAN HOUR LOST KARYAWAN PT KRAKATAU STEEL</p>
    <p>BULAN MEI - JUNI</p>
</h4>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr class="bg-primary">
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;" rowspan="2">Kode</th>
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;" rowspan="2">Nama Unit</th>
                
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;" colspan="4">Mei</th>
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;" colspan="4">Juni</th>
            </tr>
            <tr class="bg-primary">
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;">Hari Kerja</th>
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;">Jumlah Kry</th>
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;">Lost Menit</th>
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;">Lost Hari</th>

                <th class="text-center text-white" style="vertical-align : middle;text-align:center;">Hari Kerja</th>
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;">Jumlah Kry</th>
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;">Lost Menit</th>
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;">Lost Hari</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->namaunit }}</td>

                    <td>{{ $item->mei_hari_krj }}</td>
                    <td>{{ $item->mei_jml_kry }}</td>
                    <td>{{ $item->mei_lost_menit }}</td>
                    <td>{{ $item->mei_lost_hari }}</td>

                    <td>{{ $item->jun_hari_krj }}</td>
                    <td>{{ $item->jun_jml_kry }}</td>
                    <td>{{ $item->jun_lost_menit }}</td>
                    <td>{{ $item->jun_lost_hari }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>