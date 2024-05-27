@foreach ($products as $key => $product)
<tr>
        <td>{{ $key + 1 }}</td>
        {{-- @if ($product->id === $assignment->product_id) --}}
        <td>{{ $product->name }}</td>
        <td>{{ $product->product_code }}</td>
        {{-- <td>
                @if ($product->status == 1)
                    <span class="badge badge-primary">Active</span>
                @else
                    <span class="badge badge-danger">Inactive</span>
                @endif
            </td> --}}
    
    <td>
        <span class="badge badge-warning">Pending</span>
    </td>
    <td>
        <div class="d-flex justify-content-center">
            <a href="{{ route('receive-request.accept', $transferRequests->id) }}" class="btn btn-sm btn-info"
                style="margin-right: 2px">Accepted
            </a>
        </div>
    </td>
</tr>
@endforeach
