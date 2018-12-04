<h4 class="text-primary text-center p-5">
    <p>LAPORAN MAN HOUR LOST KARYAWAN PT KRAKATAU STEEL</p>
    <p>BULAN SEPTEMBER - OKTOBER</p>
</h4>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr class="bg-primary">
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;" rowspan="2">Kode</th>
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;" rowspan="2">Nama Unit</th>
                
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;" colspan="4">September</th>
                <th class="text-center text-white" style="vertical-align : middle;text-align:center;" colspan="4">Oktober</th>
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

                    <td>{{ $item->sep_hari_krj }}</td>
                    <td>{{ $item->sep_jml_kry }}</td>
                    <td>{{ $item->sep_lost_menit }}</td>
                    <td>{{ $item->sep_lost_hari }}</td>

                    <td>{{ $item->okt_hari_krj }}</td>
                    <td>{{ $item->okt_jml_kry }}</td>
                    <td>{{ $item->okt_lost_menit }}</td>
                    <td>{{ $item->okt_lost_hari }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>