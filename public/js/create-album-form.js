document.addEventListener('DOMContentLoaded', function () {
    const isAlbumCheckbox = document.getElementById('is_album');
    const albumFields = document.getElementById('album-fields');

    if (isAlbumCheckbox.checked) {
        albumFields.style.display = 'block';
    }

    isAlbumCheckbox.addEventListener('change', function () {
        albumFields.style.display = this.checked ? 'block' : 'none';
    });
});
