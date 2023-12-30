@extends('front.layout.app')

@section('main_content')
<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $single_room_data->name }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content room-detail">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-12 left">
                <div>
                    <iframe width="600" height="400" allowfullscreen style="border-style:none;" src="https://cdn.pannellum.org/2.5/pannellum.htm#panorama=https://i.ibb.co/pn7tmbz/PANO-20230810-174638-0.jpg"></iframe>
                </div>
                
                <div class="description">
                    {!! $single_room_data->description !!}
                </div>

                <div class="amenity">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Fasilitas</h2>
                        </div>
                    </div>
                    <div class="row">
                        @php
                        $arr = explode(',',$single_room_data->amenities);
                        for($j=0;$j<count($arr);$j++) {
                            $temp_row = \App\Models\Amenity::where('id',$arr[$j])->first();
                            echo '<div class="col-lg-6 col-md-12">';
                            echo '<div class="item"><i class="fa fa-check-circle"></i> '.$temp_row->name.'</div>';
                            echo '</div>';
                        }
                        @endphp
                    </div>
                </div>


                <div class="feature">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Fitur</h2>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Ukuran Ruangan</th>
                                <td>{{ $single_room_data->size }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Kasur</th>
                                <td>{{ $single_room_data->total_beds }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Kamar Mandi</th>
                                <td>{{ $single_room_data->total_bathrooms }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Balkon</th>
                                <td>{{ $single_room_data->total_balconies }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($single_room_data->video_id != '')
                <div class="video">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $single_room_data->video_id }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                @endif


            </div>
            <div class="col-lg-4 col-md-5 col-sm-12 right">

                <div class="sidebar-container" id="sticky_sidebar">

                    <div class="widget">
                        <h2>Harga per Malam</h2>
                        <div class="price">
                            ${{ $single_room_data->price }}
                        </div>
                    </div>
                    <div class="widget">
                        <h2>Pesan Homestay</h2>
                        <form action="{{ route( 'cart_submit') }}" method="post">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $single_room_data->id }}">
                            <div class="form-group mb_20">
                                <label for="">Check-in dan Check-out</label>
                                <input type="text" name="checkin_checkout" class="form-control daterange1" placeholder="Check-in dan Check-out">
                            </div>
                            <div class="form-group mb_20">
                                <label for="">Dewasa</label>
                                <input type="number" name="adult" class="form-control" min="1" max="30" placeholder="Dewasa">
                            </div>
                            <div class="form-group mb_20">
                                <label for="">Anak-anak</label>
                                <input type="number" name="children" class="form-control" min="0" max="30" placeholder="Anak-anak">
                            </div>
                            <button type="submit" class="book-now">Tambahkan ke Keranjang</button>
                        </form>
                  
                </div>


            </div>
        </div>
    </div>
</div>

@if($errors->any())
    @foreach($errors->all() as $error)
        <script>
            iziToast.error({
                title: '',
                position: 'topRight',
                message: '{{ $error }}',
            });
        </script>
    @endforeach
@endif

@endsection