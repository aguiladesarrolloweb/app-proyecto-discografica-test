<x-app-layout>
    <div class="container">
        <h2>Track Details</h2>
        <!-- Title -->
        <div class="mb-3">
            <label class="form-label"><strong>Title:</strong></label>
            <p class="form-control-plaintext">{{ $track->title }}</p>
        </div>
    
        <!-- Genre -->
        <div class="mb-3">
            <label class="form-label"><strong>Genre:</strong></label>
            <p class="form-control-plaintext">{{ $track->genre }}</p>
        </div>

    
        <!-- Completion Date -->
        <div class="mb-3">
            <label class="form-label"><strong>Completion Date:</strong></label>
            <p class="form-control-plaintext">
                {{ optional($track->completion_date)->format('Y-m-d H:i') ?? 'N/A' }}
            </p>
        </div>
    
    
        <!-- Comments -->
        <div class="mb-3">
            <label class="form-label"><strong>Comments:</strong></label>
            <p class="form-control-plaintext">{{ $track->comments ?? 'No comments' }}</p>
        </div>
    
        <!-- Status -->
        <div class="mb-3">
            <label class="form-label"><strong>Status:</strong></label>
            <p class="form-control-plaintext">{{ ucfirst($track->status) }}</p>
        </div>

        <!-- Final file -->
        <p class="form-control-plaintext">
            @if ($track->final_file)
                <a href="{{ asset($track->final_file) }}" target="_blank">{{ basename($track->final_file) }}</a>
            @else
                N/A
            @endif
        </p>
        
    
    
        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('packages.show', $track->package_id) }}" class="btn btn-info btn-sm">Back Package</a>
        </div>
    </div>
</x-app-layout>
