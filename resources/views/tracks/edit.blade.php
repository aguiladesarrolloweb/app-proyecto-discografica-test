<x-app-layout>
    <h2>Track: {{ $track->title }}</h2>
    <div>Genre: {{ $track->genre }}</div>
    <div>Duration:{{ $track->duration }}</div>
    <div>Creado: {{ $track->created_at }}</div>
    @if ($track->created_at != $track->updated_at)
    <div>Modificado: {{ $track->updated_at }}</div>
    @endif

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

        <!-- Comments -->
        <div class="mb-3">
            <label for="comments" class="form-label">Comments</label>
            <textarea id="comments" name="comments" class="form-control" rows="3">{{ old('comments', $track->comments) }}</textarea>
            @error('comments')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>



        @can('updateAdmin',App\Models\Track::class)
    
        <!-- Final File -->
        <div class="mb-3">
            <label for="final_file" class="form-label">Final File</label>
            <textarea id="final_file" name="final_file" class="form-control" rows="3">{{ old('final_file', $track->final_file) }}</textarea>
            @error('final_file')
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
    
        <!-- Current Version -->
        <div class="mb-3">
            <label for="current_version" class="form-label">Current Version</label>
            <input type="number" id="current_version" name="current_version" class="form-control" value="{{ old('current_version', $track->current_version) }}">
            @error('current_version')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <!-- Limit Version -->
        <div class="mb-3">
            <label for="limit_version" class="form-label">Limit Version</label>
            <input type="number" id="limit_version" name="limit_version" class="form-control" value="{{ old('limit_version', $track->limit_version) }}">
            @error('limit_version')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        @endcan

        <script type="text/javascript">
            var mf_dropbox_width = 100; // Cambia a tu preferencia
            var mf_dropbox_id = "aae0b94881ea4781778e1e68b5aa07009d94f98dc6ea047c3502f905ad89a9f9";
        </script>
        <script type="text/javascript" src="https://www.mediafire.com/dropbox/dropbox.js"></script>
    
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Track</button>
    </form>


</div>


</x-app-layout>
