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
                  <h3>Hotel Santika Cikarang </h3>
                  <span class="small">Jl. Raya Cikarang Cibarusah, Pasirsari, Cikarang Sel</span>
                  <span class="small">Telepon: (021) 89835533 Fax: (021) 89835533 Email: cikarang@reservation.santika.com</span>
              </td>
          </tr>
        </table>
        <hr>
      </header>
      <main>
        <div style="text-align: center;padding-top: 10px;"><h3>Laporan Purchase Request</h3></div>
        <table style="width: 100%" class="collapse">
            <tr class="collapse">
                <td class="collapse">No</td>
                <td class="collapse">No Request</td>
                <td class="collapse">Tgl Request</td>
                <td class="collapse">Tgl Butuh</td>
                <td class="collapse">Nama Barang</td>
                <td class="collapse">Harga Barang</td>
                <td class="collapse">Qty Request</td>
                <td class="collapse">User Request</td>
            </tr>
            @php
                $no = 1;
            @endphp
            @foreach ($data as $request)
                @foreach ($request->details as $detail)
                <tr class="collapse">
                    <td class="collapse">{{ $no }}</td>
                    <td class="collapse">{{ $request->no_request }}</td>
                    <td class="collapse">{{ $request->tgl_request }}</td>
                    <td class="collapse">{{ $request->tgl_butuh }}</td>
                    <td class="collapse">{{ $detail->barang->kd_barang }} - {{ $detail->barang->nm_brg }}</td>
                    <td class="collapse">@currency($detail->barang->harga)</td>
                    <td class="collapse">{{ $detail->qty_request }} {{ $detail->barang->unit }}</td>
                    <td class="collapse">{{ $request->user->name }}</td>
                </tr>
                @php
                    $no++;
                @endphp
                @endforeach
            @endforeach
        </table>
      </main>
</body>