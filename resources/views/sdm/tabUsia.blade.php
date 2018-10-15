<h4 class="text-primary text-center p-5">
    <p>LAPORAN DEMOGRAFI KARYAWAN PT KRAKATAU STEEL</p>
    <p>JUMLAH KARYAWAN BERDASARKAN USIA TAHUN {{ $select_tahun }}</p>
</h4>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr class="bg-primary">
                <th rowspan="2" class="text-center text-white" style="vertical-align : middle;text-align:center;" >NO</th>
                <th rowspan="2" class="text-center text-white" style="vertical-align : middle;text-align:center;">RANG USIA</th>
                <th colspan="6" class="text-center text-white">GOLONGAN</th>
            </tr>
            <tr class="bg-primary">
                <th class="text-white">A</th>
                <th class="text-white">B</th>
                <th class="text-white">C</th>
                <th class="text-white">D</th>
                <th class="text-white">E</th>
                <th class="text-white">F</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_desLama = 0;
                $total_januari = 0;
                $total_februari = 0;
                $total_maret = 0;
                $total_april = 0;
                $total_mei = 0;
                $total_juni = 0;
                $total_juli = 0;
                $total_agustus = 0;
                $total_september = 0;
                $total_oktober = 0;
                $total_november = 0;
                $total_desember = 0;
            @endphp
            <tr class="bg-info">
                <td colspan="8">AKTIF</td>
            </tr>
            @foreach($demo_usia as $key => $value)
                @if (strtolower($value->inti) == 'aktif')
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->range_usia }}</td>
                    <td class="text-right">{{ number_format($value->gol_a) }}</td>
                    <td class="text-right">{{ number_format($value->gol_b) }}</td>
                    <td class="text-right">{{ number_format($value->gol_c) }}</td>
                    <td class="text-right">{{ number_format($value->gol_d) }}</td>
                    <td class="text-right">{{ number_format($value->gol_e) }}</td>
                    <td class="text-right">{{ number_format($value->gol_f) }}</td>
                </tr>
                @endif
            @endforeach

            <tr class="bg-info">
                <td colspan="8">Program Transfer Knowledge</td>
            </tr>
            @foreach($demo_usia as $key => $value)
                @if (strtolower($value->inti) == 'program transfer knowledge')
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->range_usia }}</td>
                    <td class="text-right">{{ number_format($value->gol_a) }}</td>
                    <td class="text-right">{{ number_format($value->gol_b) }}</td>
                    <td class="text-right">{{ number_format($value->gol_c) }}</td>
                    <td class="text-right">{{ number_format($value->gol_d) }}</td>
                    <td class="text-right">{{ number_format($value->gol_e) }}</td>
                    <td class="text-right">{{ number_format($value->gol_f) }}</td>
                </tr>
                @endif
            @endforeach

            <tr class="bg-info">
                <td colspan="8">PKWT</td>
            </tr>
            @foreach($demo_usia as $key => $value)
                @if (strtolower($value->inti) == 'pkwt')
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->range_usia }}</td>
                    <td class="text-right">{{ number_format($value->gol_a) }}</td>
                    <td class="text-right">{{ number_format($value->gol_b) }}</td>
                    <td class="text-right">{{ number_format($value->gol_c) }}</td>
                    <td class="text-right">{{ number_format($value->gol_d) }}</td>
                    <td class="text-right">{{ number_format($value->gol_e) }}</td>
                    <td class="text-right">{{ number_format($value->gol_f) }}</td>
                </tr>
                @endif
            @endforeach

            <tr class="bg-info">
                <td colspan="8">Pbt/Png. Ke AP dan PP</td>
            </tr>
            @foreach($demo_usia as $key => $value)
                @if (strtolower($value->inti) == 'pbt/png. ke ap dan pp')
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->range_usia }}</td>
                    <td class="text-right">{{ number_format($value->gol_a) }}</td>
                    <td class="text-right">{{ number_format($value->gol_b) }}</td>
                    <td class="text-right">{{ number_format($value->gol_c) }}</td>
                    <td class="text-right">{{ number_format($value->gol_d) }}</td>
                    <td class="text-right">{{ number_format($value->gol_e) }}</td>
                    <td class="text-right">{{ number_format($value->gol_f) }}</td>
                </tr>
                @endif
            @endforeach

            <tr class="bg-info">
                <td colspan="8">Pbt/Png. Dari AP dan PP</td>
            </tr>
            @foreach($demo_usia as $key => $value)
                @if (strtolower($value->inti) == 'pbt/png. dari ap dan pp')
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->range_usia }}</td>
                    <td class="text-right">{{ number_format($value->gol_a) }}</td>
                    <td class="text-right">{{ number_format($value->gol_b) }}</td>
                    <td class="text-right">{{ number_format($value->gol_c) }}</td>
                    <td class="text-right">{{ number_format($value->gol_d) }}</td>
                    <td class="text-right">{{ number_format($value->gol_e) }}</td>
                    <td class="text-right">{{ number_format($value->gol_f) }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>