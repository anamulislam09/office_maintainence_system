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
    @foreach ($products as $product)
        @if ($product->id === $assignment->product_id)
            <td>{{ $product->name }}</td>
            <td>{{ $product->product_code }}</td>
            {{-- <td>
                @if ($product->status == 1)
                    <span class="badge badge-primary">Active</span>
                @else
                    <span class="badge badge-danger">Inactive</span>
                @endif
            </td> --}}
        @break
    @endif
@endforeach
<td>
    <span class="badge badge-warning">Pending</span>
</td>
<td>
    <div class="d-flex justify-content-center">
        <a href="{{ route('receive-request.accept', $assignment->id) }}" class="btn btn-sm btn-info"
            style="margin-right: 2px">Accepted
        </a>
        <a href="{{ route('receive-request.cancel', $assignment->id) }}" class="btn btn-sm btn-danger"
            style="margin-right: 2px">Cancel
        </a>
    </div>
</td>
</tr>
@endforeach
</tbody>

