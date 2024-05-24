@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sub Child</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sub Child</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Localization Form</h3>
                            </div>
                            <form action="{{ url('admin/catalogue/subchild-localization/'. $id . '/'. $locale) }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label>Title</label>
                                            <input type="text" value="{{ isset($data) ? $data->title : null }}" class="form-control" name="title" placeholder="Title" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label>Meta Title</label>
                                            <input  value="{{ isset($data) ? $data->meta_title : null }}" type="text" class="form-control" name="meta_title" placeholder="Meta Title">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label>Meta Description</label>
                                            <textarea class="form-control" id="meta_description" name="meta_description" placeholder="Meta Description">{{ isset($data) ? $data->meta_description : null }}</textarea>
                                        </div><div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Answer & Question</label>
                                                <textarea id="answer_question" name="answer_question">{{ isset($data) ? $data->answer_question : null }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $( document ).ready(function() {
        $('#cat_id').on('change', function(e){
            $.ajax({
                url: '{{ url("/admin/catalogue/sub-cat-load") }}/' + $(this).val(),
                type: 'GET',
                dataType: 'JSON',
                success: function(data){
                    var option = '<option value="">Select Sub Category</option>';
                    data.forEach((element, index) => {
                        option += '<option value="'+element.id+'">'+element.title+'</option>'
                    });
                    $('#sub_cat_id').html(option);
                }
            })
        });
        $('#answer_question').summernote({
            placeholder: 'Answer & Question',
            tabsize: 2,
            height: 100
        });
        $('#meta_description').summernote({
            placeholder: 'Meta Description',
            tabsize: 2,
            height: 100
        });
    });
</script>
@endsection
