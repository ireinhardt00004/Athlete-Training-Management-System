var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('output');
            output.style.display = 'block';
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
};