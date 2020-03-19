@extends('template.default')
@section('breadcrumb')
@if (Auth::user()->hasRole('kasir'))
{{ Breadcrumbs::render('transaction') }}
@endif
@endsection
@section('content')
@include('sweetalert::alert')
@if (Auth::user()->hasRole('kasir'))
<div class="container">
    <div class="row">
        <div class="col-12">
            <div id="custom-search-input">
                <div class="input-group">
                    <input type="text" id="product" placeholder="Search" name="product" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('addProduct') }}" method="POST" >
        @csrf
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="">Nama Menu</label>
                    <input type="text" name="menu" id="menu" class="form-control">
                    <input type="hidden" name="id" id="id" class="form-control">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="">Harga</label>
                    <input type="text" name="price" id="price" class="form-control">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="">QTY</label>
                    <input type="text" name="qty" id="qty" class="form-control">
                </div>
            </div>
            <div class="col-3">
                <button type="submit" class="btn btn-success btn-sm mt-4">Tambah</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar menu yang dipesan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>NAma Menu</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Sub Total</th>
                                <th style="width: 40px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=0;
                                $total=0;
                            @endphp
                            @foreach ($cart_order as $order)
                            @php
                                $no++;
                                $subtotal=$order->subtotal;
                                $total = $total+$subtotal;
                            @endphp
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$order->product_name}}</td>
                                <td>{{number_format($order->product_price)}}</td>
                                <td>{{$order->qty}}</td>
                                <td>{{number_format($order->subtotal)}}</td>
                                <td>
                                    <form action="{{route('cart_order.destroy',$order->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Total : </b></td>
                                <td>
                                    <b>{{ number_format($total) }}</b>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Transaksi</h3>
                </div>
                <form action="{{route('process')}}" method="post">
                    @csrf
                    <input type="hidden" name="total" id="total" value="{{$total}}" onkeyup="sum();">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group {{$errors->has('customer')? 'invalid' :'' }}">
                                <label for="">Nama Customer</label>
                                <input type="text" class="form-control" name="customer" id="">
                                @if ($errors->has('customer'))
                                <span class="help-block">
                                    {{ $errors->first('customer') }}
                                </span>
                                    
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">JUmlah Bayar</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" name="pay" id="pay" class="form-control" onkeyup="sum();">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">JUmlah Kembalian</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" name="back" id="back" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Catatan</label>
                                <textarea name="note" id="note" cols="50" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-primary">Proses Transaksi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>Rp. {{number_format($income_today)}}</h3>

          <p>Pendapatan Hari Ini</p>
        </div>
        <div class="icon">
            <i class="fas fa-hand-holding-usd"></i>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>Rp. {{number_format($income_yesterday)}}</h3>

            <p>Pendapatan Kemarin</p>
          </div>
          <div class="icon">
            <i class="fas fa-dollar-sign"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $categories->count()}}</h3>

            <p>Jumlah Kategori</p>
          </div>
          <div class="icon">
            <i class="fas fa-list"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{$product}}</h3>

            <p>Jumlah Product</p>
          </div>
          <div class="icon">
            <i class="fas fa-list-ol"></i>
          </div>
        </div>
      </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i>
                    Penjualan Bulan Ini</h3>
            </div>
            <div class="card-body">
                <div class="app">
                    <center>
                      {!! $chart_daily->container() !!}
        
                    </center>
                </div>
                {!! $chart_daily->script() !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i>
                    Penjualan Per Bulan</h3>
            </div>
            <div class="card-body">
                <div class="app">
                    <center>
                      {!! $chart_monthly->container() !!}
        
                    </center>
                </div>
                {!! $chart_monthly->script() !!}
            </div>
        </div>
    </div>
</div>
@endif


@push('styles')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    
@endpush
@push('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
    $('#product').autocomplete({
        source: "{{route('search') }}",
        minlength : 1,
        autofocus :true,
        select:function(e,ui){
            $('#menu').val(ui.item.value);
            $('#price').val(ui.item.price);
            $('#id').val(ui.item.id);
        }
    });
</script>
<script>
    function sum() {
        var pay = document.getElementById('pay').value;
        var total = document.getElementById('total').value;
        var result = parseInt(pay) - parseInt(total);
        if (!isNaN(result)){
            document.getElementById('back').value = result;
        }
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
@endpush
@endsection