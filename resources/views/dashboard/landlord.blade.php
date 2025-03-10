@extends('layout.master')

@section('content')
    @if(auth()->check())
    <div class="text-center my-4">
        <h1>Welcome, Owner {{ auth()->user()->fullname ?? auth()->user()->name }}!</h1>
        <p>You have access to manage properties and renters.</p>
    </div>

    <h2 class="text-center my-4">Your Properties</h2>

    @if($properties->isEmpty())
        <p class="text-center">No properties found.</p>
    @else
        <div class="slider-container">
            <div class="slider">
                @foreach($properties as $property)
                    <div class="slider-item">
                        <a href="{{ route('properties.show', $property->id) }}">
                            <img src="{{ $property->image ? asset('storage/' . $property->image) : asset('default-property.jpg') }}" alt="{{ $property->title }}">
                            <div class="property-info">
                                <h5>{{ $property->title }}</h5>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            @if($properties->count() >= 5)
                <button class="prev" onclick="moveSlider(-1)">&#10094;</button>
                <button class="next" onclick="moveSlider(1)">&#10095;</button>
            @endif
        </div>
    @endif

    <div class="d-flex gap-3 mt-5 mb-3 justify-content-center">
        <a href="{{ route('properties.create') }}" class="btn btn-primary">Create New Property</a>
    </div>
    @else
        <p class="text-danger">You must be logged in to view this page.</p>
        <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
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
    .slider-item img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 10px;
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
</script>
