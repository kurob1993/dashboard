@extends('layout.app')

@section('menu_active')
    @php($active = 'Finance')
@endsection

@section('style')
  <link href="{{ asset('plugins/bootstrap-datepicker/css/datepicker.css') }}" rel="stylesheet" />
@endsection

@section('script')
<script type="text/javascript" src="{{ url('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
      $('#date').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true,
          endDate :"{{ date('d/m/Y') }}",
      }).datepicker("update", "{{ date('d/m/Y') }}");

      show('{{ date('Y-m-d') }}');
  });

  function show() {
    var date = $("#date").val();
    $.get('{{ url('/invoice/show') }}',{date : date},function (data) {

        if(data){
          $('#posisiInvoice').html(data.POSISI_INVOICE);
          $('#lastUpdate').html(data.LAST_UPDATE);
          //DOMESTIK
          $('.DOM_HRC_TON').html(data.DOM_HRC.TON);
          $('.DOM_HRC_NILAI').html(data.DOM_HRC.NILAI);
          $('.DOM_HRC_AVG').html(data.DOM_HRC.AVG);
          $('.DOM_HRC_RKAP').html(data.DOM_HRC.RKAP);

          $('.DOM_HRT_TON').html(data.DOM_HRT.TON);
          $('.DOM_HRT_NILAI').html(data.DOM_HRT.NILAI);
          $('.DOM_HRT_AVG').html(data.DOM_HRT.AVG);
          $('.DOM_HRT_RKAP').html(data.DOM_HRT.RKAP);

          $('.DOM_HRPO_TON').html(data.DOM_HRPO.TON);
          $('.DOM_HRPO_NILAI').html(data.DOM_HRPO.NILAI);
          $('.DOM_HRPO_AVG').html(data.DOM_HRPO.AVG);
          $('.DOM_HRPO_RKAP').html(data.DOM_HRPO.RKAP);

          $('.DOM_CRC_TON').html(data.DOM_CRC.TON);
          $('.DOM_CRC_NILAI').html(data.DOM_CRC.NILAI);
          $('.DOM_CRC_AVG').html(data.DOM_CRC.AVG);
          $('.DOM_CRC_RKAP').html(data.DOM_CRC.RKAP);

          $('.DOM_WR_TON').html(data.DOM_WR.TON);
          $('.DOM_WR_NILAI').html(data.DOM_WR.NILAI);
          $('.DOM_WR_AVG').html(data.DOM_WR.AVG);
          $('.DOM_WR_RKAP').html(data.DOM_WR.RKAP);

          $('.DOM_BLT_TON').html(data.DOM_BLT.TON);
          $('.DOM_BLT_NILAI').html(data.DOM_BLT.NILAI);
          $('.DOM_BLT_AVG').html(data.DOM_BLT.AVG);
          $('.DOM_BLT_RKAP').html(data.DOM_BLT.RKAP);

          $('.DOM_SUBTOTAL_TON').html(data.DOM_SUBTOTAL.TON);
          $('.DOM_SUBTOTAL_NILAI').html(data.DOM_SUBTOTAL.NILAI);
          
          // EKSPOR
          $('.EKS_HRC_TON').html(data.EKS_HRC.TON);
          $('.EKS_HRC_NILAI').html(data.EKS_HRC.NILAI);
          $('.EKS_HRC_AVG').html(data.EKS_HRC.AVG);
          $('.EKS_HRC_RKAP').html(data.EKS_HRC.RKAP);

          $('.EKS_CRC_TON').html(data.EKS_CRC.TON);
          $('.EKS_CRC_NILAI').html(data.EKS_CRC.NILAI);
          $('.EKS_CRC_AVG').html(data.EKS_CRC.AVG);
          $('.EKS_CRC_RKAP').html(data.EKS_CRC.RKAP);

          $('.EKS_WR_TON').html(data.EKS_WR.TON);
          $('.EKS_WR_NILAI').html(data.EKS_WR.NILAI);
          $('.EKS_WR_AVG').html(data.EKS_WR.AVG);
          $('.EKS_WR_RKAP').html(data.EKS_WR.RKAP);

          $('.EKS_SUBTOTAL_TON').html(data.EKS_SUBTOTAL.TON);
          $('.EKS_SUBTOTAL_NILAI').html(data.EKS_SUBTOTAL.NILAI);

          $('.TOTAL_TON').html(data.TOTAL.TON);
          $('.TOTAL_NILAI').html(data.TOTAL.NILAI);
        }
        
    });
  }
  
</script>
@endsection

@section('content')
    <!-- begin page-header -->
    <h1 class="page-header">Dashboard Operation Excellence </h1>
    <!-- end page-header -->
    <section>
        <div class="panel panel-inverse" >
          <div class="panel-heading">
            <div class="panel-heading-btn">
              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h4 class="panel-title"><span class="fa fa-dashboard"></span> PENERBITAN INVOICE </h4>
          </div>
          <div class="panel-body p-5">

            <div class="col-md-6 p-10">

              <div class="input-group p-5">
                <input type="text" name="tanggal" class="form-control" id="date">
                <span class="input-group-btn">
                  <button class="btn btn-primary" onclick="show()">Cari</button>      
                </span>
              </div>

            </div>

            <div class="col-md-6 p-10">
              <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 
                <strong>Last Update Data : </strong> <span id="lastUpdate"></span><br>
                <strong>Posisi Invoice : </strong> <span id="posisiInvoice"></span>
              </div>
            </div>

            <div class="panel panel-primary col-md-6">
              <div class="panel-heading">
                <h3 class="panel-title">
                  <span class="fa fa-globe"></span>
                  DOMESTIK
                </h3>
              </div>
              <div class="panel-body p-0">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Product</th>
                        <th>Ton</th>
                        <th>Nilai (USD)</th>
                        <th>Harga Rata2 Inv</th>
                        <th>Target RKAP</th>
                        {{-- <th>Target R.Operasi</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      <tr  align="right">
                        <td>HRC</td>
                        <td class="DOM_HRC_TON"></td>
                        <td class="DOM_HRC_NILAI"></td>
                        <td class="DOM_HRC_AVG"></td>
                        <td class="DOM_HRC_RKAP"></td>
                      </tr>
                      <tr align="right">
                        
                        <td>HR-PO</td> 
                        <td class="DOM_HRPO_TON"></td>
                        <td class="DOM_HRPO_NILAI"></td>
                        <td class="DOM_HRPO_AVG"></td>
                        <td class="DOM_HRPO_RKAP"></td>
                      </tr>
                      <tr align="right">
                        <td>HR TRADING KP</td>
                        <td class="DOM_HRT_TON"></td>
                        <td class="DOM_HRT_NILAI"></td>
                        <td class="DOM_HRT_AVG"></td>
                        <td class="DOM_HRT_RKAP"></td>
                      </tr>
                      <tr align="right">
                        <td>CRC</td>
                        <td class="DOM_CRC_TON"></td>
                        <td class="DOM_CRC_NILAI"></td>
                        <td class="DOM_CRC_AVG"></td>
                        <td class="DOM_CRC_RKAP"></td>
                      </tr>
                      <tr align="right">
                        <td>WR</td>
                        <td class="DOM_WR_TON"></td>
                        <td class="DOM_WR_NILAI"></td>
                        <td class="DOM_WR_AVG"></td>
                        <td class="DOM_WR_RKAP"></td>
                      </tr>
                      <tr align="right">
                        <td>BILLET</td>
                        <td class="DOM_BLT_TON"></td>
                        <td class="DOM_BLT_NILAI"></td>
                        <td class="DOM_BLT_AVG"></td>
                        <td class="DOM_BLT_RKAP"></td>
                      </tr>
                      <tr align="right" class="bg-primary">
                        <td>SUB TOTAL</td>
                        <td class="DOM_SUBTOTAL_TON"></td>
                        <td class="DOM_SUBTOTAL_NILAI"></td>
                        <td class="">-</td>
                        <td class="">-</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="panel panel-primary col-md-6">
              <div class="panel-heading">
                <h3 class="panel-title">
                  <span class="fa fa-plane"></span>
                  EKSPOR
                </h3>
              </div>
              <div class="panel-body p-0">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="panel-heading">
                        <th>Product</th>
                        <th>Ton</th>
                        <th>Nilai (USD)</th>
                        <th>Harga Rata2 Inv</th>
                        <th>Target RKAP</th>
                        {{-- <th>Target R.Operasi</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      <tr align="right">
                        <td>HRC</td>
                        <td class="EKS_HRC_TON"></td>
                        <td class="EKS_HRC_NILAI"></td>
                        <td class="EKS_HRC_AVG"></td>
                        <td class="EKS_HRC_RKAP"></td>
                      </tr>
                      <tr align="right">
                        <td>CRC</td> 
                        <td class="EKS_CRC_TON"></td>
                        <td class="EKS_CRC_NILAI"></td>
                        <td class="EKS_CRC_AVG"></td>
                        <td class="EKS_CRC_RKAP"></td>
                      </tr>
                      <tr align="right">
                        <td>WR</td>
                        <td class="EKS_WR_TON"></td>
                        <td class="EKS_WR_NILAI"></td>
                        <td class="EKS_WR_AVG"></td>
                        <td class="EKS_WR_RKAP"></td>
                      </tr>
                      <tr align="right" class="bg-primary">
                        <td>SUB TOTAL</td>
                        <td class="EKS_SUBTOTAL_TON"></td>
                        <td class="EKS_SUBTOTAL_NILAI"></td>
                        <td class="">-</td>
                        <td class="">-</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="panel panel-primary col-md-12">
              <div class="panel-heading">
                <h3 class="panel-title">
                  <span class="fa fa-bars"></span>
                  TOTAL PRODUK BAJA
                </h3>
              </div>
              <div class="panel-body p-0">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="panel-heading">
                        <th>TON</th>
                        <th>NILAI (USD)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr align="right">
                        <td class="TOTAL_TON">0</td>
                        <td class="TOTAL_NILAI">0</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
    </section>
@endsection
