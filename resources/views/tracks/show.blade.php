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
    
        <!-- Duration -->
        <div class="mb-3">
            <label class="form-label"><strong>Duration:</strong></label>
            <p class="form-control-plaintext">{{ $track->duration }}</p>
        </div>
    
        <!-- Completion Date -->
        <div class="mb-3">
            <label class="form-label"><strong>Completion Date:</strong></label>
            <p class="form-control-plaintext">
                {{ optional($track->completion_date)->format('Y-m-d H:i') ?? 'N/A' }}
            </p>
        </div>
    
        <!-- Original File -->
        <div class="mb-3">
            <label class="form-label"><strong>Original File:</strong></label>
            <p class="form-control-plaintext">
                {{ $track->final_file }}
            </p>
        </div>
    
        <!-- Final File -->
        <div class="mb-3">
            <label class="form-label"><strong>Final File:</strong></label>
            <p class="form-control-plaintext">
                {{ $track->final_file }}
            </p>
        </div>

        <div>
            {{ $file['name'] }}
            <a href="{{ $file['url'] }}" download>Descargar</a>
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
    
        <!-- File Format -->
        <div class="mb-3">
            <label class="form-label"><strong>File Format:</strong></label>
            <p class="form-control-plaintext">{{ strtoupper($track->file_format) }}</p>
        </div>
    
        <!-- Current Version -->
        <div class="mb-3">
            <label class="form-label"><strong>Current Version:</strong></label>
            <p class="form-control-plaintext">{{ $track->current_version }}</p>
        </div>
    
        <!-- Limit Version -->
        <div class="mb-3">
            <label class="form-label"><strong>Limit Version:</strong></label>
            <p class="form-control-plaintext">{{ $track->limit_version }}</p>
        </div>
    
        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('packages.show', $track->package_id) }}" class="btn btn-info btn-sm">Back Package</a>
        </div>
    </div>
</x-app-layout>
