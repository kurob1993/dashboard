<h4 class="text-primary text-center p-5">
    <p>PENCAPAIAN KPI PERUSAHAAN  TAHUN {{ $select_tahun }}</p>
    <p>Periode : Sampai Dengan 
        @foreach ($bulan as $item)
            @if ($item['bulan'] == $select_bulan)
                {{ $item['nama'] }}
            @endif
        @endforeach
    {{ $select_tahun }}</p>
</h4>
<div class="table-responsive">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="bg-primary">
                    <th class="myStyle text-white" style="vertical-align : middle;text-align:center;" rowspan="2">No</th>
                    <th class="text-center text-white" style="vertical-align : middle;text-align:center;" rowspan="2">KPI</th>
                    <th class="text-center text-white" style="vertical-align : middle;text-align:center;" rowspan="2">BOBOT</th>
                    <th class="text-center text-white" style="vertical-align : middle;text-align:center;" rowspan="2">TARGET {{ $select_tahun }}</th>
                    <th class="text-center text-white" style="vertical-align : middle;text-align:center;" rowspan="2">SATUAN</th>
                    <th class="text-center text-white" style="vertical-align : middle;text-align:center;" colspan="3">AKUMULASI s.d {{ $select_tahun }}</th>
                    <th class="text-center text-white" style="vertical-align : middle;text-align:center;" rowspan="2">STATUS</th>
                </tr>
                <tr class="bg-primary">
                    <th class="text-center text-white" style="vertical-align : middle;text-align:center;">TARGET</th>
                    <th class="text-center text-white" style="vertical-align : middle;text-align:center;">REAL</th>
                    <th class="text-center text-white" style="vertical-align : middle;text-align:center;">CAPAIAN</th>
                </tr>
            </thead>
            <tbody> 
                @foreach ($data_hcdlc as $grup=>$hcdlc)
                    @php($bobot = 0 )
                    @foreach ($hcdlc as $key=>$item)
                        <tr>
                            <td>{{ $key+1}}</td>
                            <td>{{ $item->kpi}}</td>
                            <td class="text-right">{{ $ini->formatNumber($item->bobot) }}</td>
                            <td class="text-right">{{ $ini->formatNumber($item->target_tahun) }}</td>
                            <td class="text-right">{{ $item->satuan}}</td>
                            <td class="text-right">{!! $ini->formatNumber($item->target) !!}</td>
                            <td class="text-right">{!! $ini->formatNumber($item->real) !!}</td>
                            <td class="text-right">{!! $ini->formatNumber($item->capaian) !!}</td>
                            <td class="text-right"> - </td>
                        </tr>
                        @php( $x = (int) $item->bobot )
                        @php( $bobot = (int) $item->bobot+$bobot )
                    @endforeach
                    <tr>
                        <td colspan="2"></td>
                        <td class="text-righ text-white" style="background-color: #dc3545!important;">
                            {{ $ini->formatNumber($bobot) }}
                        </td>
                        <td colspan="6"></td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>