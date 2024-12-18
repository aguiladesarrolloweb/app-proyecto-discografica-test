<x-app-layout>
    <h2>Track: {{ $track->track_name }}</h2>
    <div>Genre: {{ $track->genre }}</div>
    <div>Duration:{{ $track->duration }}</div>
    <div>Creado: {{ $track->created_at }}</div>
    <div>Modificado: {{ $track->updated_at }}</div>

    <form action="{{ route('tracks.update') }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <input type="hidden" name="id" value="{{$track->id}}">
        
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $track->title) }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Genre -->
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" id="genre" name="genre" class="form-control" value="{{ old('genre', $track->genre) }}" required>
            @error('genre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Completion Date -->
        <div class="mb-3">
            <label for="completion_date" class="form-label">Completion Date</label>
            <input type="datetime-local" id="completion_date" name="completion_date" class="form-control" value="{{ old('completion_date', optional($track->completion_date)->format('Y-m-d\TH:i')) }}">
            @error('completion_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Final File -->
        <div class="mb-3">
            <label for="final_file" class="form-label">Final File</label>
            <input type="file" id="final_file" name="final_file" class="form-control">
            <small>Current file: {{ $track->final_file }}</small>
            @error('final_file')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Comments -->
        <div class="mb-3">
            <label for="comments" class="form-label">Comments</label>
            <textarea id="comments" name="comments" class="form-control" rows="3">{{ old('comments', $track->comments) }}</textarea>
            @error('comments')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select" required>
                @foreach(\App\Enums\FileStatusEnum::options() as $status)
                    <option value="{{ $status }}" @if(old('status', $track->status) == $status) selected @endif>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- File Format -->
        <div class="mb-3">
            <label for="file_format" class="form-label">File Format</label>
            <select id="file_format" name="file_format" class="form-select" required>
                @foreach(\App\Enums\FileFormatEnum::options() as $format)
                    <option value="{{ $format }}" @if(old('file_format', $track->file_format) == $format) selected @endif>{{ strtoupper($format) }}</option>
                @endforeach
            </select>
            @error('file_format')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Current Version -->
        <div class="mb-3">
            <label for="current_version" class="form-label">Current Version</label>
            <input type="number" id="current_version" name="current_version" class="form-control" value="{{ old('current_version', $track->current_version) }}" required>
            @error('current_version')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Limit Version -->
        <div class="mb-3">
            <label for="limit_version" class="form-label">Limit Version</label>
            <input type="number" id="limit_version" name="limit_version" class="form-control" value="{{ old('limit_version', $track->limit_version) }}" required>
            @error('limit_version')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Track</button>
    </form>
    



</div>

</x-app-layout>