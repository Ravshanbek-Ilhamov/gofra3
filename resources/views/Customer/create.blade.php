@extends('Layout.main')

@section('title', 'Create Customer')

@section('contents')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add New Customer</h3>
                </div>
                <form action="{{ route('customer.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Customer Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                        </div>

                        <div class="form-group">
                            <label for="balance">Balance</label>
                            <input type="number" step="0.01" class="form-control" id="balance" name="balance" placeholder="Enter balance">
                        </div>

                        <div class="form-group">
                            <label>Select Location</label>
                            <div id="map" style="height: 300px;"></div>
                        </div>

                        <!-- Latitude va Longitude yashirin maydon -->
                        <input type="hidden" id="longitude" name="longitude">
                        <input type="hidden" id="latitude" name="latitude">
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('customer.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Yandex Maps API -->
<script src="https://api-maps.yandex.ru/2.1/?lang=en_US" type="text/javascript"></script>
<script>
    ymaps.ready(init);
    function init() {
        var map = new ymaps.Map("map", {
            center: [41.2995, 69.2401], // Default: Tashkent
            zoom: 13
        });

        var placemark = new ymaps.Placemark(map.getCenter(), {}, { draggable: true });
        map.geoObjects.add(placemark);

        function updateCoordinates(coords) {
            document.getElementById("latitude").value = coords[0];
            document.getElementById("longitude").value = coords[1];
        }

        placemark.events.add("dragend", function () {
            var coords = placemark.geometry.getCoordinates();
            updateCoordinates(coords);
        });

        map.events.add('click', function (e) {
            var coords = e.get('coords');
            placemark.geometry.setCoordinates(coords);
            updateCoordinates(coords);
        });

        // Birinchi bosishda koordinatalarni olish
        updateCoordinates(placemark.geometry.getCoordinates());
    }
</script>
@endsection
