function createSlug () {
    let title = $('#title').val();
    $('#slug').val(string_to_slug(title));
}
function string_to_slug(str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();
  
    // remove accents, swap ñ for n, etc
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to   = "aaaaeeeeiiiioooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return str;
}


function logout() {
    const $logoutForm = $('#logout-form');
    if ($logoutForm.length) {
        $logoutForm.submit();
    } else {
        console.error('Logout form not found.');
    }
}


document.getElementById('image').addEventListener('change', function (event) {
    const previewContainer = document.getElementById('image-preview');
    previewContainer.innerHTML = ''; // Reset container preview

    const files = event.target.files;

    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100px'; // Atur gaya gambar
                img.style.margin = '5px';
                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });
});