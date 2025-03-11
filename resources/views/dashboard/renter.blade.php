@extends('layout.master')

@section('content')

{{-- @dd($rentedProperties) --}}

    @if(auth()->check())
        <div class="text-center my-4">
            <h1>Welcome, {{ auth()->user()->fullname }}!</h1>
            <p>Here are your rented properties.</p>
        </div>

        <h2 class="text-center my-4">My Rented Properties</h2>
        <div class="d-flex justify-content-center mb-4">
            <input type="text" id="propertySearch" class="form-control w-50" placeholder="Search by property name..." onkeyup="filterProperties()">
        </div>

        <div id="noPropertiesMessage" class="text-center text-danger" style="display: none;">No rented properties found.</div>
{{-- @dd($rentedProperties) --}}

        @if($rentedProperties->isEmpty())

            <p class="text-center">No rented properties found.</p>
        @else
            <div class="slider-container">
                <div class="slider">
                    @foreach($rentedProperties as $property)
                        <div class="slider-item">
                            <a href="{{ route('rented-properties.show', $property->id) }}">
                                <img src="{{ Storage::url($property->image) }}" alt="{{ $property->title }}">
                            </a>
                            <div class="property-info">
                                <h5>{{ $property->title }}</h5>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="prev" onclick="moveSlider(-1)">&#10094;</button>
                <button class="next" onclick="moveSlider(1)">&#10095;</button>
            </div>
        @endif
    @else
        <p class="text-danger">You must be logged in to view this page.</p>
        <a href="{{ route('auth.signin') }}" class="btn btn-secondary">Login</a>
    @endif
@endsection

<style>
    .slider-container {
        position: relative;
        overflow: hidden;
        width: 80%;
        max-width: 1000px;
        margin: auto;
    }
    .slider {
        display: flex;
        flex-wrap: nowrap;
        transition: transform 0.5s ease-in-out;
    }
    .slider-item {
        min-width: 20%;
        max-width: 20%;
        flex: 0 0 auto;
        box-sizing: border-box;
        padding: 10px;
        text-align: center;
    }
    .slider-item a {
        display: block;
        text-decoration: none;
    }
    .slider-item img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 10px;
        transition: transform 0.3s ease-in-out;
    }
    .slider-item img:hover {
        transform: scale(1.05);
    }
    .property-info {
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 10px;
        margin-top: -30px;
        position: relative;
    }
    .prev, .next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 20px;
    }
    .prev { left: 10px; }
    .next { right: 10px; }
</style>

<script>
    let index = 0;

    function moveSlider(step) {
        const slider = document.querySelector('.slider');
        const items = document.querySelectorAll('.slider-item');
        const totalItems = items.length;
        const visibleItems = Math.min(5, totalItems);

        index = Math.max(0, Math.min(index + step, totalItems - visibleItems));
        slider.style.transform = `translateX(-${index * (100 / visibleItems)}%)`;
    }

    function filterProperties() {
        let input = document.getElementById("propertySearch").value.toLowerCase();
        let items = document.querySelectorAll(".slider-item");
        let found = false;

        items.forEach(item => {
            let title = item.querySelector(".property-info h5").innerText.toLowerCase();
            let isVisible = title.includes(input);
            item.style.display = isVisible ? "block" : "none";
            if (isVisible) found = true;
        });

        document.getElementById("noPropertiesMessage").style.display = found ? "none" : "block";
    }
</script>
