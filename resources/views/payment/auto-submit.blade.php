<x-app-layout>

    <form id="redirectForm" method="POST" action="{{ route('packages.store') }}">
        @csrf
        <input type="hidden" name="package_id" value="{{ $package_id }}">
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('redirectForm').submit();
        });
    </script>

</x-app-layout>