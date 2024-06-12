<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Loading.....' }}</title>
    <style>
        #preloaderz {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Ensure preloader appears above other content */
        }
        
        #loaderz {
            text-align: center;
        }
        
        .rect-loader {
            width: 200px;
            height: 40px;
            border: 1px solid blue;
            position: relative;
            overflow: hidden;
            margin-top: 20px;
            border-radius: 8px;
        }
        
        .load-image {
            height: 100px;
            width: 200px;
        }
        
        .fill-load {
            background-color: blue;
            height: 100%;
            width: 0;
            position: absolute;
            top: 0;
            left: 0;
            animation: fillAnimation 1.5s ease-in-out infinite; /* Changed animation duration to 1.5 seconds */
        }
        
        @keyframes fillAnimation {
            0% {
                width: 0;
            }
            50% {
                width: 100%;
            }
            100% {
                width: 0;
            }
        }
        
        #loaderz img {
            max-width: 100px;
        }
        
        /* Override all styles */
        #preloaderz #loaderz .rect-loader .fill-load,
        #preloaderz #loaderz .load-image,
        #preloaderz #loaderz img {
            /* Add your overriding styles here */
        }
    </style>
</head>
<body id="bodyWithPreloader"> <!-- Add ID to body tag -->
    <div id="preloaderz">
        <div id="loaderz">
            <img class="load-image" src="{{ asset('assets/img/Walk.gif') }}" alt="loading">
            <div class="rect-loader">
                <div class="fill-load"></div>
            </div>
             <h5>Loading...</h5>
        </div>
    </div> 

    <!-- Your page content here -->
    <script>
        // Display preloader while page is loading
        document.body.style.overflow = 'hidden'; // Prevent scrolling while loading
        window.addEventListener('load', function() {
            // Hide preloader when content is loaded
            document.body.style.overflow = ''; // Allow scrolling after loading
            document.getElementById('preloaderz').style.display = 'none';
        });
    </script>
</body>
</html>
