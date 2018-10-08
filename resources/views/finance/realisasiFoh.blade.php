@extends('layout.app')

@section('menu_active')
    @php($active = 'Finance')
@endsection

@section('style')
<style type="text/css">
</style>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('th').addClass('p-5');
    $('td').addClass('p-5');
  });
</script>
@endsection

@section('content')
<h1 class="page-header">Dashboard Operation Excellence </h1>

    @component('component.panel')
      @slot('title')
        <span class="fa fa-money"></span>
        REALISASI FOH vs ANGGARAN
      @endslot
      <div class="row">
        <div class="col-sm-12">
          <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Last Update : </strong> {{ $lastUpdate }}
          </div>
        </div>
        <div class="col-sm-4 p-5">
          <form action="{{ url('/daily_report/realisasi_foh/show') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="input-group p-5">
              <select name="tahun" class="form-control">
                <option value=""> -- Pilih Tahun -- </option>
                @foreach( $pilih_tahun as $key => $value )
                <option value="{{ $value->tahun }}"> {{ $value->tahun }} </option>
                @endforeach
              </select>
              <span class="input-group-btn">
                <button class="btn btn-primary">Cari Tahun</button>      
              </span>
            </div>
          </form>
        </div>

      </div>
      <div class="table-responsive" style="height: 450px">
        @foreach( $pk as $key => $valuepk )
          @if($valuepk->pk != '-')
            <table class="table table-hover table-bordered" style="width: 5000px;margin-bottom: 30px">
                <thead>
                    <tr class="info">
                      <th colspan="24">{{ $valuepk->pk }} - {{ $valuepk->deskripsi }}</th>
                    </tr>
                    <tr class="bg-primary">
                        <th class="text-white">REKENING</th>
                        <th class="text-white" style="width: 500px">NAMA REKENING</th>
                        <th class="text-white text-right">REALISASI {{ $tahun_lama }}</th>
                        <th class="text-white text-right">REALISASI RATA-RATA {{ $tahun_lama }}</th>
                        <th class="text-white text-right">REALISASI JANUARI {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI FEBRUARI {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI MARET {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI APRIL {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI MEI {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI JUNI {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI SEMSTER 1 {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI JULI {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI AGUSTUS {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI SEPTEMBER</th>
                        <th class="text-white text-right">REALISASI Q I,II & III {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI OKTOBER {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI NOVEMBER {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI DESEMBER {{ $tahun }}</th>
                        <th class="text-white text-right">REALISASI JAN-DES {{ $tahun }}</th>
                        <th class="text-white text-right">ANGGARAN SEMESTER I {{ $tahun }}</th>
                        <th class="text-white text-right">ANGGARAN PER BULAN {{ $tahun }}</th>
                        <th class="text-white text-right">ANGGARAN JAN-DES {{ $tahun }}</th>
                        <th class="text-white text-right">RKAP {{ $tahun }}</th>
                        <th class="text-white text-right">SISA ANGGARAN {{ $tahun }}</th>
                    </tr>
                </thead>
                <tbody id="hutang_lc">
                  
                    @foreach( $foh as $key => $value )
                      @if($valuepk->pk == $value->pk)
                        <tr>
                            <td>{{ $value->rekening }}</td>
                            <td>{{ $value->nama_rekening }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_lama) }}</td>
                            <td class="text-right">{{ number_format($value->rata_rata_lama) }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_januari) }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_februari) }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_maret) }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_april) }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_mei) }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_juni) }}</td>
                            <td class="text-right">{{ number_format($value->real_smt_1) }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_juli) }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_agustus) }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_september) }}</td>
                            <td class="text-right">{{ number_format($value->real_q123) }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_oktober) }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_november) }}</td>
                            <td class="text-right">{{ number_format($value->realisasi_desember) }}</td>
                            <td class="text-right">{{ number_format($value->real_jan_des) }}</td>
                            <td class="text-right">{{ number_format($value->anggaran_smt_1) }}</td>
                            <td class="text-right">{{ number_format($value->anggaran_per_bulan) }}</td>
                            <td class="text-right">{{ number_format($value->anggaran_jan_des) }}</td>
                            <td class="text-right">{{ number_format($value->rkap) }}</td>
                            <td class="text-right">{{ number_format($value->sisa_anggaran) }}</td>
                        </tr>
                      @endif
                    @endforeach
                        <tr class="warning">
                          <td class="text-center" colspan="2">Sub Total</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_lama) }}</td>
                          <td class="text-right">{{ number_format($valuepk->rata_rata_lama) }}</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_januari) }}</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_februari) }}</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_maret) }}</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_april) }}</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_mei) }}</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_juni) }}</td>
                          <td class="text-right">{{ number_format($valuepk->real_smt_1) }}</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_juli) }}</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_agustus) }}</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_september) }}</td>
                          <td class="text-right">{{ number_format($valuepk->real_q123) }}</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_oktober) }}</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_november) }}</td>
                          <td class="text-right">{{ number_format($valuepk->realisasi_desember) }}</td>
                          <td class="text-right">{{ number_format($valuepk->real_jan_des) }}</td>
                          <td class="text-right">{{ number_format($valuepk->anggaran_smt_1) }}</td>
                          <td class="text-right">{{ number_format($valuepk->anggaran_per_bulan) }}</td>
                          <td class="text-right">{{ number_format($valuepk->anggaran_jan_des) }}</td>
                          <td class="text-right">{{ number_format($valuepk->rkap) }}</td>
                          <td class="text-right">{{ number_format($valuepk->sisa_anggaran) }}</td>
                        </tr>
                </tbody>
            </table>
          @endif
        @endforeach
      </div>
    @endcomponent

    
@endsection
