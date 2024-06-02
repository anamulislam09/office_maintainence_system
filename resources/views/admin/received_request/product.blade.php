<style>
  table, tbody, tr,td{
      font-size: 14px;
  }
</style>
<div class="table-responsive">

    <table id="example1" class="table table-striped table-bordered table-centre">
      <thead>
        <tr>
          <th>SN</th>
          <th>Product Name</th>
          <th>Product Code</th>
          <th>Category Name</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $key => $product)
        @php
           $cat_name = App\Models\Category::where('id', $product->cat_id)->value('name')
        @endphp
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->product_code }}</td>
            <td>{{ $cat_name }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>