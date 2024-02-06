@extends('admin.layout.app')

@section('heading', 'Halaman Galeri Vidio')

@section('right_top_button')
<a href="{{ route('admin_video_add') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Baru</a>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Vidio</th>
                                    <th>Keterangan</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($videos as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="iframe-container1">
                                            <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $row->video_id }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                    </td>
                                    <td>{{ $row->caption }}</td>
                                    <td class="pt_10 pb_10">
                                        <a href="{{ route('admin_video_edit',$row->id) }}" class="btn btn-primary">Edit</a>
                                        <a href="{{ route('admin_video_delete',$row->id) }}" class="btn btn-danger" onClick="return confirm('Are you sure?');">Hapus</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection