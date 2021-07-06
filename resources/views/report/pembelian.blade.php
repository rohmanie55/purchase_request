<!DOCTYPE html>
<html>
<head>
	<title>Data Purchase Request</title>
</head>
<style type="text/css">
    body{
      margin-top: 3cm;
      margin-left: 2cm;
      margin-right: 2cm;
      margin-bottom: 2cm;
      font-family: Arial, Helvetica, sans-serif;
      font-size:15px;
    }
    header {
      position: fixed;
      margin-left: 2cm;
      margin-right: 2cm;
      top: 0cm;
      height: 3cm;
    }
    table tr td,
		table tr th{
			padding-top: 5px;
	}
    .collapse{
        border: 1px solid black;
        border-collapse: collapse;
    }
    p{
        text-align:justify;
    }
</style>
<body>
    <header>
        <table>
          <tr>
              <td style="width: 30%">
                  <img src="{{ asset('img/brand/hs.jpg') }}" style="max-height: 90px">
              </td>
              <td style="width: 70%;padding-left:10px;">
                  <h3>PT. Grahawita Santika </h3>
                  <span class="small">Jl. Raya Cikarang Cibarusah, Pasirsari, Cikarang Sel</span>
                  <span class="small">Telepon: (021) 89835533 Fax: (021) 89835533 Email: cikarang@reservation.santika.com</span>
              </td>
          </tr>
        </table>
        <hr>
      </header>
      <main>
        <div style="text-align: center;padding-top: 10px;"><h3>Laporan Pembelian</h3></div>
        <table style="width: 100%" class="collapse">
            <tr class="collapse">
                <td class="collapse">No</td>
                <td class="collapse">No Beli</td>
                <td class="collapse">Tgl Beli</td>
                <td class="collapse">No Faktur</td>
                <td class="collapse">No Order</td>
                <td class="collapse">Nama Barang</td>
                <td class="collapse">Harga Barang</td>
                <td class="collapse">Qty</td>
                <td class="collapse">Total</td>
            </tr>
            @php
                $no = 1;
            @endphp
            @foreach ($data as $beli)
                @foreach ($beli->details as $detail)
                <tr class="collapse">
                    <td class="collapse">{{ $no }}</td>
                    <td class="collapse">{{ $beli->no_beli }}</td>
                    <td class="collapse">{{ $beli->tgl_beli }}</td>
                    <td class="collapse">{{ $beli->no_faktur }}</td>
                    <td class="collapse">{{ $beli->order->no_order }}</td>
                    <td class="collapse">{{ $detail->barang->kd_barang }} - {{ $detail->barang->nm_brg }}</td>
                    <td class="collapse">@currency($detail->barang->harga)</td>
                    <td class="collapse">{{ $detail->qty_brg }} {{ $detail->barang->unit }}</td>
                    <td class="collapse">@currency($beli->total)</td>
                </tr>
                @php
                    $no++;
                @endphp
                @endforeach
            @endforeach
        </table>
      </main>
</body>