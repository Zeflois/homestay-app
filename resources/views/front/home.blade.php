@extends('front.layout.app')

@section('main_content')
<div class="slider">
    <div class="slide-carousel owl-carousel">
        @foreach($slide_all as $item)
        <div class="item" style="background-image:url({{ asset('uploads/'.$item->photo) }});background-size: 100% 100%;">
            <div class="bg"></div>
            <div class="text">
                <h2>{{ $item->heading }}</h2>
                <p>
                    {!! $item->text !!}
                </p>
                @if($item->button_text != '')
                <div class="button">
                    <a href="{{ $item->button_url }}">{{ $item->button_text }}</a>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

 
<div class="search-section">
    <div class="container">
        <form action="{{ route('cart_submit') }}" method="post">
            @csrf
            <div class="inner">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <select name="room_id" class="form-select">
                                <option value="">Pilih Kamar</option>
                                @foreach($room_all as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="text" name="checkin_checkout" class="form-control daterange1" placeholder="Check-in dan Check-out">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <input type="number" name="adult" class="form-control" min="1" max="30" placeholder="Dewasa" value="1">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <input type="number" name="children" class="form-control" min="0" max="30" placeholder="Anak-anak" value="0">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



@if($global_setting_data->home_feature_status == 'Show')
<div class="home-feature">
    <div class="container">
        <div class="row">
            
            @foreach($feature_all as $item)
            <div class="col-md-3">
                <div class="inner">
                    <div class="icon"><i class="{{ $item->icon }}"></i></div>
                    <div class="text">
                        <h2>{{ $item->heading }}</h2>
                        <p>
                            {!! $item->text !!}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endif



@if($global_setting_data->home_room_status == 'Show')
<div class="home-rooms">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="main-header">Kamar</h2>
            </div>
        </div>
        <div class="row">
        <div class="row justify-content-center">
            @foreach($room_all as $item)
            @if($loop->iteration>$global_setting_data->home_room_total) 
            @break
            @endif
            <div class="col-md-3">
                <div class="inner">
                    <div class="photo">
                        <iframe width="300" height="200" allowfullscreen style="border-style:none;" src="https://cdn.pannellum.org/2.5/pannellum.htm#panorama={{$item->featured_photo ?? 'https://i.ibb.co/pn7tmbz/PANO-20230810-174638-0.jpg'}}"></iframe>
                    </div>
                    <div class="text">
                        <h2><a href="{{ route('room_detail',$item->id) }}">{{ $item->name }}</a></h2>
                        <div class="price">
                            Rp {{ $item->price }}/malam
                        </div>
                        <div class="button">
                            <a href="{{ route('room_detail',$item->id) }}" class="btn btn-primary">Lihat Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>  
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="big-button">
                    <a href="{{ route('room') }}" class="btn btn-primary">Lihat Semua Kamar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif


@if($global_setting_data->home_testimonial_status == 'Show')
<div class="testimonial" style="background-image: url(uploads/slide2.jpg)">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="main-header">Testimoni Tamu</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="testimonial-carousel owl-carousel">
                    @foreach($testimonial_all as $item)
                    <div class="item">
                        <div class="photo">
                            <img src="{{ asset('uploads/'.$item->photo) }}" alt="">
                        </div>
                        <div class="text">
                            <h4>{{ $item->name }}</h4>
                            <p>{{ $item->designation }}</p>
                        </div>
                        <div class="description">
                            <p>
                                {!! $item->comment !!}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif


@if($global_setting_data->home_latest_post_status == 'Show')
<div class="blog-item">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="main-header">Postingan Terbaru</h2>
            </div>
        </div>
        <div class="row">

            @foreach($post_all as $item)
            @if($loop->iteration>$global_setting_data->home_latest_post_total) 
            @break
            @endif
            <div class="col-md-4">
                <div class="inner">
                    <div class="photo">
                        <img src="{{ asset('uploads/'.$item->photo) }}" alt="">
                    </div>
                    <div class="text">
                        <h2><a href="{{ route('post',$item->id) }}">{{ $item->heading }}</a></h2>
                        <div class="short-des">
                            <p>
                                {!! $item->short_content !!}
                            </p>
                        </div>
                        <div class="button">
                            <a href="{{ route('post',$item->id) }}" class="btn btn-primary">Lihat Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
</div>
@endif



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