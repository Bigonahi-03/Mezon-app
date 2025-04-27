@php
    $aboutUs = App\Models\AboutUs::first();
@endphp
<section class="about_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6 ">
                <div class="">
                    <img src="images/about-img.jpg" width="350" alt="" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2>
                            {{ $aboutUs->title }}
                        </h2>
                    </div>
                    <p>
                        {{ $aboutUs->body }}
                    </p>
                    <a href="{{ route('about_us') }}">
                        مشاهده بیشتر
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>