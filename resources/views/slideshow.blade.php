<!DOCTYPE html>
<html>
<head>
    <title>Event Slideshow</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            background: black;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        #slideshow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 1s ease-in-out;
        }
    </style>
</head>
<body>

    <img id="slideshow" src="" alt="Event Image">

    <script>
        let images = @json($images);
        let index = 0;
        let slideshowEl = document.getElementById('slideshow');

        function showNextImage() {
            if (images.length > 0) {
                slideshowEl.style.opacity = 0; // fade out
                setTimeout(() => {
                    slideshowEl.src = images[index];
                    slideshowEl.style.opacity = 1; // fade in
                    index = (index + 1) % images.length;
                }, 1000); // match transition duration
            }
        }

        function fetchUpdatedImages() {
            fetch("{{ route('slideshow.data') }}")
                .then(response => response.json())
                .then(data => {
                    images = data;
                    index = 0; // reset to first image
                })
                .catch(err => console.error("Error fetching images:", err));
        }

        // Show first image
        showNextImage();

        // Change image every 5 seconds
        setInterval(showNextImage, 5000);

        // Refresh images from server every 60 seconds
        setInterval(fetchUpdatedImages, 60000);
    </script>

</body>
</html>
