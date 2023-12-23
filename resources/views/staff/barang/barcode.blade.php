
<html>
<head>
</head>
<body>

    <h1>Data Barcode Barang Lab Teknik Informatika</h1>

            @foreach ($barangData as $items)
            <p class="card-text">
                {!! DNS1D::getBarcodeHTML($items->kodebarcode, 'C128', 2, 50, 'black', true) !!}P - {{ $items->kodebarcode }} - {{ $items->kategori->namakategori }} {{ $items->kategori->jenis }} {{ $items->kategori->merk }}
            </p>
            <br>
            @endforeach


</body>
</html>
