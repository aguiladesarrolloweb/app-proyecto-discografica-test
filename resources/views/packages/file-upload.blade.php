<x-app-layout>


    <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        <div class="mb-3">
            <input type="hidden" name="package_id" value="{{$package->id}}">
            <label for="file" class="form-label">Choose a file</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

</x-app-layout>