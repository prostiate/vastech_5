<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Company Name</th>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Fax Number</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($contacts as $contact)
        <tr>
            <td style="text-align: center">{{ $no++ }}</td>
            <td>{{ $contact->company_name }}</td>
            <td>{{ $contact->display_name }}</td>
            <td>{{ $contact->billing_address }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->telephone }}</td>
            <td>{{ $contact->npwp }}</td>
        </tr>
        @endforeach
    </tbody>
</table>