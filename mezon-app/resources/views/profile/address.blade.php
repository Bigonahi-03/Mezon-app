    @extends('profile.layouts.master')

    @section('title', 'Profile | Address')
    @section('main')
        <div class="col-md-8 mt-5 mt-md-0">
            @error('message')
                <div class="text-danger">{{ $message }}50505</div>
            @enderror

            <form action="{{ route('profile.address.store') }}" method="POST">
                @csrf
                <div class="card card-body">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div id="map" style="height: 400px;"></div>
                            <input type="hidden" name="lat" id="lat"
                                value="{{ $userAddress->latitude ?? old('lat') }}">
                            <input type="hidden" name="lng" id="lng"
                                value="{{ $userAddress->longitude ?? old('lng') }}">
                        </div>
                        <button type="button" id="fillAddressBtn" class="btn btn-info">دریافت آدرس از نقشه</button>

                        <div class="col-12 col-md-6">
                            <label class="form-label">شماره تماس</label>
                            <input type="text" name="cellphone" value="{{ $userAddress->cellphone ?? old('cellphone') }}"
                                class="form-control" />
                            <div class="text-danger">
                                @error('cellphone')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 ">
                            <label class="form-label">استان</label>
                            <input type="text" name="province" id="province"
                                value="{{ $userAddress->province ?? old('province') }}" class="form-control" readonly />
                            <div class="text-danger">
                                @error('province')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">شهر</label>
                            <input type="text" name="city" id="city"
                                value="{{ $userAddress->city ?? old('city') }}" class="form-control" />
                            <div class="text-danger">
                                @error('city')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">کد پستی</label>
                            <input type="text" name="postal_code"
                                value="{{ $userAddress->postal_code ?? old('postal_code') }}" class="form-control" />
                            <div class="text-danger">
                                @error('postal_code')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 ">
                            <label class="form-label">آدرس دقیق</label>
                            <textarea name="address" id="address" rows="5" class="form-control">{{ $userAddress->address ?? old('address') }}</textarea>
                            <div class="text-danger">
                                @error('address')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="mt-4">

                        <button type="submit" class="btn btn-info">ذخیره </button>
                    </div>
                </div>
            </form>
        </div>
    @endsection

    @section('script')
        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>

        <script>
            var map; // تعریف متغیر نقشه در سطح جهانی

            function initializeMap() {
                // بررسی اینکه آیا نقشه قبلاً مقداردهی شده است
                if (typeof map !== 'undefined' && map !== null) {
                    map.remove();
                }

                map = L.map('map').setView([35.6892, 51.3890], 13);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18
                }).addTo(map);

                var marker = L.marker([35.6892, 51.3890], {
                    draggable: true
                }).addTo(map);

                // تنظیم موقعیت اولیه مارکر اگر مختصات قبلی وجود داشته باشد
                var lat = document.getElementById('lat').value ? parseFloat(document.getElementById('lat').value) : 35.6892;
                var lng = document.getElementById('lng').value ? parseFloat(document.getElementById('lng').value) : 51.3890;

                marker.setLatLng([lat, lng]);
                map.setView([lat, lng], 13);

                // دریافت مختصات هنگام کلیک روی نقشه
                map.on('click', function(event) {
                    lat = event.latlng.lat;
                    lng = event.latlng.lng;
                    marker.setLatLng([lat, lng]);
                    document.getElementById('lat').value = lat;
                    document.getElementById('lng').value = lng;
                });

                // دریافت مختصات هنگام جابجایی مارکر
                marker.on('dragend', function(event) {
                    lat = event.target.getLatLng().lat;
                    lng = event.target.getLatLng().lng;
                    document.getElementById('lat').value = lat;
                    document.getElementById('lng').value = lng;
                });

                // دکمه دریافت شهر و استان از API نشان
                document.getElementById("fillAddressBtn").addEventListener("click", function() {
                    getLocationNeshan(lat, lng);
                });
            }

            async function getLocationNeshan(lat, lng) {
                const apiKey = '{{ config('services.neshan.key') }}';
                const url = `https://api.neshan.org/v5/reverse?lat=${lat}&lng=${lng}`;

                try {
                    const response = await fetch(url, {
                        headers: {
                            'Api-Key': apiKey
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`خطا در دریافت موقعیت: ${response.status}`);
                    }

                    const data = await response.json();

                    // بررسی شهر و استفاده از نزدیک‌ترین مکان ممکن
                    let city = data.city;
                    if (!city || city.trim() === "" || city === "نامشخص") {
                        city = data.district || data.formatted_address.split(',')[0] || data.state || 'نامشخص';
                    }

                    document.getElementById('city').value = city;
                    document.getElementById('province').value = data.state || 'نامشخص';

                    // ذخیره آدرس دقیق‌تر
                    document.getElementById('address').value = data.formatted_address || 'نامشخص';

                } catch (error) {
                    console.error('خطا در دریافت موقعیت:', error);
                }
            }



            document.addEventListener("DOMContentLoaded", initializeMap);
        </script>
    @endsection
