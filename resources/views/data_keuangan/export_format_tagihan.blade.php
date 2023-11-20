<table border="1">
    <thead>
        <tr>
            <td style="background-color:#E78F5E; text-align:center; vertical-align:center;">No.</td>
            <td style="background-color:#E78F5E; text-align:center; vertical-align:center;">Nis</td>
            <td style="background-color:#E78F5E; text-align:center; vertical-align:center;">Jumlah Tagihan (Bulan)</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($siswa as $key => $item )
            <tr>
                <td>{{$key +1}}</td>
                <td>{{$item->nis}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>