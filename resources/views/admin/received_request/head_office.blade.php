<thead>
    <tr>
        <th>Sl</th>
        <th>Product Name</th>
        <th>Product Code</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
@foreach ($assignments as $key => $assignment)
    <tr>
        <td>{{ $key + 1 }}</td>
        @php
            $product = $products->get($assignment->product_id);
        @endphp
        <td>{{ $product->name ?? 'N/A' }}</td>
        <td>{{ $product->product_code ?? 'N/A' }}</td>
        <td>
            <span class="badge badge-warning">Pending</span>
        </td>
        <td>
            <div class="d-flex justify-content-center">
                <a href="{{ route('receive-request.accept', $assignment->id) }}" class="btn btn-sm btn-info" style="margin-right: 2px">Accepted</a>
                <a href="{{ route('receive-request.cancel', $assignment->id) }}" class="btn btn-sm btn-danger" style="margin-right: 2px">Cancel</a>
            </div>
        </td>
    </tr>
@endforeach
</tbody>


