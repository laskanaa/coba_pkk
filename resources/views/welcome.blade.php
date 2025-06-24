@extends('layouts.app')

@section('content')
    <!-- ***** Main Banner Area Start ***** -->
    <section id="section-1">
        <div class="content-slider">
            <input type="radio" id="banner1" class="sec-1-input" name="banner" checked>
            <div class="slider">
                <div id="top-banner-1" class="banner">
                    <div class="banner-inner-wrapper header-text">
                        <div class="main-caption">
                            <h2>Selamat Datang di Website PKK Wonosobo</h2>
                        </div>
                        {{-- <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="more-info">
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6 col-6">
                                                <i class="fa fa-user"></i>
                                                <h4><span>Population:</span><br>44.48 M</h4>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-6">
                                                <i class="fa fa-globe"></i>
                                                <h4><span>Territory:</span><br>275.400 KM<em>2</em></h4>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-6">
                                                <i class="fa fa-home"></i>
                                                <h4><span>AVG Price:</span><br>$946.000</h4>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-6">
                                                <div class="main-button">
                                                    <a href="about.html">Explore More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Main Banner Area End ***** -->

    <div class="visit-country">
        <div class="container">
            <!-- Judul -->
            <div class="row">
                <div class="col-lg-5">
                    <div class="section-heading">
                        <h2>Berita</h2>
                    </div>
                </div>
            </div>

            <!-- Daftar Berita -->
            <div class="row">
                <div class="col-lg-12">
                    @foreach ($beritas as $berita)
                        <div class="item mb-4">
                            <div class="row">
                                <div class="col-lg-4 col-sm-5">
                                    <div class="image">
                                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-sm-7">
                                    <div class="right-content">
                                        <h4>{{ $berita->judul }}</h4>
                                        <div class="main-button">
                                            <a href="{{ route('berita.show', $berita->id) }}">Baca Selengkapnya</a>
                                        </div>
                                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 150) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pengumuman -->
            <div class="row mt-5">
                <div class="col-lg-5">
                    <div class="section-heading">
                        <h2>Pengumuman</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($pengumumans as $pengumuman)
                    <div class="col-lg-12">
                        <div class="item mb-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="right-content">
                                        <h4>{{ $pengumuman->judul }}</h4>
                                        <div class="main-button">
                                            <a href="{{ route('pengumuman.show', $pengumuman->id) }}">Detail</a>
                                        </div>
                                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($pengumuman->isi), 150) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Peta (dipindah ke bawah) -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="side-bar-map">
                        <div id="map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12469.776493332698!2d-80.14036379941481!3d25.907788681148624!2m3!1f357.26927939317244!2f20.870722720054623!3f0!3m2!1i1024!2i768!4f35!3m3!1m2!1s0x88d9add4b4ac788f%3A0xe77469d09480fcdb!2sSunny%20Isles%20Beach!5e1!3m2!1sen!2sth!4v1642869952544!5m2!1sen!2sth"
                                width="100%" height="550px" frameborder="0" style="border:0; border-radius: 23px;"
                                allowfullscreen="">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h2>Are You Looking To Travel ?</h2>
                    <h4>Make A Reservation By Clicking The Button</h4>
                </div>
                <div class="col-lg-4">
                    <div class="border-button">
                        <a href="reservation.html">Book Yours Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function bannerSwitcher() {
            next = $('.sec-1-input').filter(':checked').next('.sec-1-input');
            if (next.length) next.prop('checked', true);
            else $('.sec-1-input').first().prop('checked', true);
        }

        var bannerTimer = setInterval(bannerSwitcher, 5000);

        $('nav .controls label').click(function() {
            clearInterval(bannerTimer);
            bannerTimer = setInterval(bannerSwitcher, 5000)
        });
    </script>
@endsection
