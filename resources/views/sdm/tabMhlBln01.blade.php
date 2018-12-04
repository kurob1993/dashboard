<h4 class="text-primary text-center p-5">
    <p>LAPORAN MAN HOUR LOST KARYAWAN PT KRAKATAU STEEL</p>
    <p>BULAN JANUARI - FEBRUARI</p>
</h4>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr class="bg-primary">
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;" rowspan="2">Kode</th>
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;" rowspan="2">Nama Unit</th>
                
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;" colspan="4">Januari</th>
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;" colspan="4">Februari</th>
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

                    <td>{{ $item->jan_hari_krj }}</td>
                    <td>{{ $item->jan_jml_kry }}</td>
                    <td>{{ $item->jan_lost_menit }}</td>
                    <td>{{ $item->jan_lost_hari }}</td>

                    <td>{{ $item->feb_hari_krj }}</td>
                    <td>{{ $item->feb_jml_kry }}</td>
                    <td>{{ $item->feb_lost_menit }}</td>
                    <td>{{ $item->feb_lost_hari }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>