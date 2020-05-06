<table>
    <thead>
    <tr>
        <th>Kode Dealer</th>
        <th>Nama Dealer</th>
        <th>Cabang</th>
        <th>Area</th>
        <th>Final Reward</th>
        <th>Kategori Dealer</th>
        <th>Next Kategori Dealer</th>
        <th>Current Month</th>
        <th>Periode Start</th>
        <th>Periode End</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $failed)
        <tr>
            <td>{{ $failed->kode_dealer }}</td>
            <td>{{ $failed->nama_dealer }}</td>
            <td>{{ $failed->cabang }}</td>
            <td>{{ $failed->area }}</td>
            <td>{{ $failed->final_reward }}</td>
            <td>{{ $failed->kategori_dealer }}</td>
            <td>{{ $failed->next_kategori_dealer }}</td>
            <td>{{ $failed->current_month }}</td>
            <td>{{ $failed->periode_start }}</td>
            <td>{{ $failed->periode_end }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
