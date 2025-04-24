<!-- slider section -->
@php
    $sliders = App\Models\Slider::get();
@endphp

@if ($sliders->isNotEmpty())
    <section class="slider_section">
        <div id="customCarousel1" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                @foreach ($sliders as $slider)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-7 col-lg-6">
                                    <div class="detail-box">
                                        <h2 class="mb-3 fw-bold">
                                            {{ $slider->title }}
                                        </h2>
                                        <p>
                                            {{ $slider->body }}
                                        </p>

                                        <div class="btn-box">
                                            <a href="{{ $slider->link_address }}" class="btn1">
                                                {{ $slider->link_title }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="container">
                <ol class="carousel-indicators">
                    @foreach ($sliders as $slider)
                        <li data-bs-target="#customCarousel1" data-bs-slide-to="{{ $loop->index }}"
                            class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach

                </ol>
            </div>
        </div>
    </section>
@else
    <div class="container">
        <div class="row ">
            <div class="col-md-7 col-lg-6">
                <div class="position-absolute top-50 start-50 translate-middle text-center">
                    <h1 class="mb-4 fw-bold text-gold ">
                        Mezone
                    </h1>
                    <p class="text-light">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد
                    </p>

                </div>
            </div>
        </div>
    </div>
@endif

