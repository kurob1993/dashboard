<h4 class="text-primary text-center p-5">
    <p>LAPORAN DEMOGRAFI KARYAWAN PT KRAKATAU STEEL</p>
    <p>JUMLAH KARYAWAN BERDASARKAN PENDIDIKAN</p>
</h4>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr class="bg-primary">
                <th rowspan="2" class="text-center text-white">NO</th>
                <th rowspan="2" class="text-center text-white">PENDIDIKAN<br>( PT KS INTI )</th>
                <th rowspan="2" class="text-center text-white">DES 2017</th>
                <th colspan="12" class="text-center text-white">BULAN</th>
            </tr>
            <tr class="bg-primary">
                <th class="text-white">JAN</th>
                <th class="text-white">FEB</th>
                <th class="text-white">MAR</th>
                <th class="text-white">APR</th>
                <th class="text-white">MEI</th>
                <th class="text-white">JUN</th>
                <th class="text-white">JUL</th>
                <th class="text-white">AUG</th>
                <th class="text-white">SEP</th>
                <th class="text-white">OKT</th>
                <th class="text-white">NOV</th>
                <th class="text-white">DES</th>
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
            @foreach($demo_pendidikan as $key => $value)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $value->deskripsi }}</td>
                    <td class="text-right">{{ number_format($value->des_lama)      }}</td>
                    <td class="text-right">{{ number_format($value->januari)       }}</td>
                    <td class="text-right">{{ number_format($value->februari)      }}</td>
                    <td class="text-right">{{ number_format($value->maret)         }}</td>
                    <td class="text-right">{{ number_format($value->april)         }}</td>
                    <td class="text-right">{{ number_format($value->mei)           }}</td>
                    <td class="text-right">{{ number_format($value->juni)          }}</td>
                    <td class="text-right">{{ number_format($value->juli)          }}</td>
                    <td class="text-right">{{ number_format($value->agustus)       }}</td>
                    <td class="text-right">{{ number_format($value->september)     }}</td>
                    <td class="text-right">{{ number_format($value->oktober)       }}</td>
                    <td class="text-right">{{ number_format($value->november)      }}</td>
                    <td class="text-right">{{ number_format($value->desember)      }}</td>
                    @php
                        $total_desLama = $total_desLama+$value->des_lama;
                        $total_januari      = $total_januari   + $value->januari  ;
                        $total_februari     = $total_februari  + $value->februari ;
                        $total_maret        = $total_maret     + $value->maret    ;
                        $total_april        = $total_april     + $value->april    ;
                        $total_mei          = $total_mei       + $value->mei      ;
                        $total_juni         = $total_juni      + $value->juni     ;
                        $total_juli         = $total_juli      + $value->juli     ;
                        $total_agustus      = $total_agustus   + $value->agustus  ;
                        $total_september    = $total_september + $value->september;
                        $total_oktober      = $total_oktober   + $value->oktober  ;
                        $total_november     = $total_november  + $value->november ;
                        $total_desember     = $total_desember  + $value->desember ;
                    @endphp
                </tr>
            @endforeach
                <tr>
                    <td colspan="2" class="text-center">Total</td>
                    <td class="text-right">{{ number_format($total_desLama) }}</td>

                    <td class="text-right">{{ number_format($total_januari)    }}</td>
                    <td class="text-right">{{ number_format($total_februari)   }}</td>
                    <td class="text-right">{{ number_format($total_maret)      }}</td>
                    <td class="text-right">{{ number_format($total_april)      }}</td>
                    <td class="text-right">{{ number_format($total_mei)        }}</td>
                    <td class="text-right">{{ number_format($total_juni)       }}</td>
                    <td class="text-right">{{ number_format($total_juli)       }}</td>
                    <td class="text-right">{{ number_format($total_agustus)    }}</td>
                    <td class="text-right">{{ number_format($total_september)  }}</td>
                    <td class="text-right">{{ number_format($total_oktober)    }}</td>
                    <td class="text-right">{{ number_format($total_november)   }}</td>
                    <td class="text-right">{{ number_format($total_desember)   }}</td>
                </tr>
        </tbody>
    </table>
</div> 