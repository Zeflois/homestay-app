@extends('admin.layout.app')

@section('heading', 'Edit Kamar')

@section('right_top_button')
<a href="{{ route('admin_room_view') }}" class="btn btn-primary"><i class="fa fa-eye"></i> Lihat Semua</a>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin_room_update',$room_data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label class="form-label">Ganti Foto Kamar</label>
                                    <input type="text" class="form-control" name="featured_photo" value="{{ $room_data->featured_photo }}">
                                    
                                <div class="mb-4">
                                    <label class="form-label">Nama *</label>
                                    <input type="text" class="form-control" name="name" value="{{ $room_data->name }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Deskripsi *</label>
                                    <textarea name="description" class="form-control snote" cols="30" rows="10">{{ $room_data->description }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Harga *</label>
                                    <input type="text" class="form-control" name="price" value="{{ $room_data->price }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Total Kamar *</label>
                                    <input type="text" class="form-control" name="total_rooms" value="{{ $room_data->total_rooms }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Kelengkapan</label>
                                    @php $i=0; @endphp
                                    @foreach($all_amenities as $item)

                                    @if(in_array($item->id,$existing_amenities))
                                    @php $checked_type = 'checked'; @endphp
                                    @else
                                    @php $checked_type = ''; @endphp
                                    @endif

                                    @php $i++; @endphp
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="defaultCheck{{ $i }}" name="arr_amenities[]" {{ $checked_type }}>
                                        <label class="form-check-label" for="defaultCheck{{ $i }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Ukuran Kamar</label>
                                    <input type="text" class="form-control" name="size" value="{{ $room_data->size }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Ranjang</label>
                                    <input type="text" class="form-control" name="total_beds" value="{{ $room_data->total_beds }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Kamar Mandi</label>
                                    <input type="text" class="form-control" name="total_bathrooms" value="{{ $room_data->total_bathrooms }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Balkoni</label>
                                    <input type="text" class="form-control" name="total_balconies" value="{{ $room_data->total_balconies }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Jumlah Tamu</label>
                                    <input type="text" class="form-control" name="total_guests" value="{{ $room_data->total_guests }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Vidio Preview</label>
                                    <div class="iframe-container1">
                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $room_data->video_id }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Vidio Id</label>
                                    <input type="text" class="form-control" name="video_id" value="{{ $room_data->video_id }}">
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