@extends('admin.layout.app')

@section('heading', 'Edit Halaman Foto')

@section('right_top_button')
<a href="{{ route('admin_photo_view') }}" class="btn btn-primary"><i class="fa fa-eye"></i> Lihat Semua</a>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin_photo_update',$photo_data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label class="form-label">Foto Yang Telah Ada</label>
                                    <div>
                                        <img src="{{ asset('uploads/'.$photo_data->photo) }}" alt="" class="w_200">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Ganti Foto</label>
                                    <div>
                                        <input type="file" name="photo">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" name="caption" value="{{ $photo_data->caption }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label"></label>
                                    <button type="submit" class="btn btn-primary">Perbaharui</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection