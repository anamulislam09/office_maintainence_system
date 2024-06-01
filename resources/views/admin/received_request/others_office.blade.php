<thead>
  <tr>
    <th>transferred from</th>
    <th>transferred Date</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
</thead>
<tbody>

  <td>{{ $office->title }}</td>
  <td>{{ $transferRequests->updated_date }}</td>
  <td>
    @if ($transferRequests->status == 1)
      <span class="badge badge-primary">Pending</span>
    @elseif ($transferRequests->status == 2)
      <span class="badge badge-info">Approved </span>
    @elseif ($transferRequests->status == 3)
      <span class="badge badge-success">Accepted</span>
    @else
      <span class="badge badge-danger">Rejected</span>
    @endif
  </td>
  </td>
  {{-- @if (Auth::guard('admin')->user()->office_id !== '0' || Auth::guard('admin')->user()->office_id !== '1') --}}
  <td>
    <div class="d-flex justify-content-center">
      <a href="#" id="transferRequest" data-id="{{ $transferRequests->id }}" data-toggle="modal" data-target="#myModal"
        class="btn btn-sm btn-success" style="margin-right: 2px">
        <i class="fas fa fa-eye"></i>
      </a>
      <a href="{{ route('transfer-request.approve', $transferRequests->id) }}" class="btn btn-sm btn-info"
        style="margin-right: 2px">
        Approved
      </a>
    </div>
  </td>
</tbody>
