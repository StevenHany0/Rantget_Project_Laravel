
@extends('layout.master')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">History Log</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row justify-content-start">
        @foreach($histories as $history)
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm border-0" 
                    style="max-width: 250px; padding: 10px; border-radius: 10px; cursor: pointer;" 
                    data-bs-toggle="modal" data-bs-target="#historyModal{{$history->id}}">
                    
                    <div class="card-body text-center p-2">
                        <h6 class="card-title mb-1" style="font-size: 1rem; font-weight: bold; color: #333;">
                            Contract ID: {{ $history->contract_id }}
                        </h6>

                        @if($history->contract && $history->contract->tenant && $history->contract->tenant->image)
                            <img src="{{ asset('storage/'.$history->contract->tenant->image) }}" 
                                alt="Tenant Image" 
                                class="rounded-circle" 
                                style="width: 60px; height: 60px; object-fit: cover; margin-bottom: 8px;">
                        @else
                            <span>No Image</span>
                        @endif

                        @if($history->contract && $history->contract->tenant)
                            <p class="mt-1" style="font-size: 0.9rem;">
                                <strong>Tenant:</strong> {{ $history->contract->tenant->fullname }}
                            </p>
                        @else
                            <span>No Tenant</span>
                        @endif

                        <p class="mt-1">
                            <span class="badge 
                                @if($history->action_type == 'created') bg-success 
                                @elseif($history->action_type == 'updated') bg-warning 
                                @elseif($history->action_type == 'deleted') bg-danger 
                                @elseif($history->action_type == 'expired') bg-secondary
                                @endif">
                                {{ ucfirst($history->action_type) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- مودال التفاصيل -->
    @foreach($histories as $history)
        <div class="modal fade" id="historyModal{{$history->id}}" tabindex="-1" aria-labelledby="historyModalLabel{{$history->id}}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="historyModalLabel{{$history->id}}">Contract Details - History ID: {{ $history->contract_id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if($history->contract && $history->contract->contract_image)
                            <img src="{{ asset('storage/'.$history->contract->contract_image) }}" 
                                alt="Contract Image" 
                                style="width: 100%; height: auto; object-fit: cover; margin-bottom: 10px;">
                        @else
                            <span>No Contract Image</span>
                        @endif

                        @if($history->contract && $history->contract->tenant)
                            <p><strong>Tenant:</strong> {{ $history->contract->tenant->fullname }}</p>
                        @else
                            <p>No Tenant</p>
                        @endif

                        <p><strong>Status:</strong> 
    <span class="badge 
    @if($history->action_type == 'deleted' || ($history->contract && $history->contract->status == 'expired')) 
        bg-secondary 
    @elseif($history->action_type == 'updated' || ($history->contract && $history->contract->status == 'active')) 
        bg-success 
    @else 
        bg-warning 
    @endif">
        @if($history->action_type == 'deleted')
            Expired
        @elseif($history->action_type == 'updated')
            Active
        @else
            {{ ucfirst($history->contract->status ?? 'Unknown') }}
        @endif
    </span>
</p>


                        <h5>Old Data</h5>
                        @if($history->old_data)
                            @php $oldData = json_decode($history->old_data, true); @endphp
                            <p><strong>Start Date:</strong> {{ $oldData['start_date'] ?? 'N/A' }}</p>
                            <p><strong>End Date:</strong> {{ $oldData['end_date'] ?? 'N/A' }}</p>
                            <p><strong>Total Amount:</strong> {{ $oldData['total_amount'] ?? 'N/A' }}</p>
                            <p><strong>Insurance Amount:</strong> {{ $oldData['insurance_amount'] ?? 'N/A' }}</p>
                        @else
                            <p>No Old Data</p>
                        @endif

                        <h5>New Data</h5>
                        @if($history->new_data)
                            @php $newData = json_decode($history->new_data, true); @endphp
                            <p><strong>Start Date:</strong> {{ $newData['start_date'] ?? 'N/A' }}</p>
                            <p><strong>End Date:</strong> {{ $newData['end_date'] ?? 'N/A' }}</p>
                            <p><strong>Total Amount:</strong> {{ $newData['total_amount'] ?? 'N/A' }}</p>
                            <p><strong>Insurance Amount:</strong> {{ $newData['insurance_amount'] ?? 'N/A' }}</p>
                        @else
                            <p>No New Data</p>
                        @endif

                        <p><strong>Timestamp:</strong> {{ $history->created_at->format('d-m-Y H:i:s') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
