@extends('layouts.class')
@section('content')
<style>
.nav {
        font-size: 20px;
        font-family:   sans-serif;
    }
.nav-classlink {
    margin: 15px;
}
.rec {
    border: black 1px ;
    width: 100%;
    height: 150px;
    border-radius: 10px; 
    display: flex; 
    justify-content: space-between; 
    align-items: flex-end; 
    position: relative;
}

h2 {
    color: white;
    position: absolute;
    bottom: 0; 
    left: 0;
    margin: 10px; 
}

.sub-title  {
    color: white;
    
    bottom: 0; 
    left: -1;
    margin: 10px; 
}

.btn-circle {
    margin: 10px;
    position: absolute; 
    right: 0; 
}
.btn-customize {
    margin: 5px;
    position: absolute;
    top: 0;
    right: 0;
    border-radius:50%;
}
.textarea-container {
    position: relative;
    width: 100%;
    margin-top: 15px;

}
.textarea {
    width: 100%;
    height: 150px;
    border-radius: 5px;
    padding-right: 60px; 
    opacity: 0.5;
    font-size: 20px;
}
.title-input {
    width: 100%;
    height: 50px;
    border-radius: 5px;
    padding-right: 60px; 
    opacity: 0.5;
    font-size: 20px;
}
.files {
    position: absolute;
    right: 10px; 
    bottom: 10px;
    left: 0;
    margin: 10px;
}
.post-announce {
    float: right;
    height: 50px;
    width: 100px;
    border-radius: 5px;
}
.posts {
    margin-top: 20px;
}

.materials {
    margin: 50px;
    position: relative;
    width: 100%;
}
.post-materials {
    width: 100%;  

}
.accordion-item {
    border-radius: 5px;
    border: 1px solid #ddd;
    margin-bottom: 15px;
}

.accordion-title {
    background-color: #f5f5f5;
    padding: 15px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.accordion-title h4 {
    margin: 0;
}

.accordion-content {
    display: none;
    padding: 15px;
    background-color: #fff;
    border-top: 1px solid #ddd;
}

.accordion-dropdown {
    position: relative;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 120px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    right: 0;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.accordion-dropdown:hover .dropdown-content {
    display: block;
}

.contents-links {
    text-decoration: none;
    color: black;
    cursor: pointer;
}

.contents-links:hover {
    color: green;
}
.img-material {
    border: solid 1px black;
    max-width: 100%; 
    max-height: 150px;
    margin: 10px;
}
.facebook-post {
    border: 1px solid #ddd; 
    border-radius: 8px;
    margin-bottom: 20px; 
    background-color: #fff; 
    padding: 15px; 
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
}

.facebook-post-header {
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    margin-bottom: 10px; 
}

.facebook-post-header h4 {
    margin: 0;
    color: #333; 
    font-size: 18px; 
}
.accordion-dropdown {
    position: relative; 
}

.dropdown-content {
    display: none;
    position: absolute; 
    background-color: #f9f9f9; 
    min-width: 120px; 
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); 
    z-index: 1; 
    right: 0; 
}

.dropdown-content a {
    color: #333; 
    padding: 12px 16px; 
    text-decoration: none; 
    display: block; 
}
.dropdown-content a:hover {
    background-color: #f1f1f1; 
}
.accordion-dropdown:hover .dropdown-content {
    display: block; 
}

.facebook-post-content {
    line-height: 1.6;
}

.facebook-post-content img {
    max-width: 100%; 
    height: auto; 
    margin-bottom: 10px;
}
.facebook-post-content video {
    max-width: 100%; 
    height: auto; 
    margin-bottom: 10px; 
}
.facebook-post-content audio {
    max-width: 100%; 
    height: auto;
    margin-bottom: 10px; 
}
.facebook-post-content a {
    color: #007bff;
    text-decoration: none; 
}
.facebook-post-content a:hover {
    text-decoration: underline; 
}

</style>
<div class>
    <div class="nav-classlink">
     <div class="nav" style="margin-top: 20px;">
    <ul class="nav nav-tabs" style="background-color: #f8f9fa; border-radius: 8px; padding: 10px;">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('class-page', ['sport_id' => $materials->sport->id]) }}" style="color: #333; font-size: 16px;">Back to {{ $materials->sport->name }} </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page"  href="{{ route('material.page', ['id' => $materials->id]) }}" style="color: #333; font-size: 16px; font-weight: bold; ">{{ $materials->title }}  |  {{ $materials->sport->name }}</a>
        </li>
       <li class="nav-item">
            <a class="nav-link" aria-current="page"  href="{{ route('checklists.index', ['id' => $materials->id]) }}" style="color: #333; font-size: 16px;">{{ $materials->title }}  Checklist</a>
        </li>
        @auth
        @if (auth()->user()->hasRole('coach') || auth()->user()->hasRole('admin'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false" style="color: #333; font-size: 16px;"><i class="fa fa-cog"></i> Settings</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#customizeModal" style="font-size: 14px;">Change Cover Photo</a></li>
                <li> <a class="dropdown-item" href="#" onclick="editMaterial({{ $materials->id }})" style="font-size: 14px;"> Edit Content</a></li>
            </ul>
        </li>
        @endif
        @endauth
    </ul>
</div>

    @if($materials->sport->customize && $materials->sport->customize->photo_path)
    <div class="rec" style="background-image: url('{{ asset($materials->sport->customize->photo_path) }}');">
    @else
    <div class="rec" style="background-color: green;">
    @endif
     @auth
        @if (auth()->user()->hasRole('coach') || auth()->user()->hasRole('admin'))
    <a href="#" data-toggle="modal" data-target="#customizeModal" title="Customize">
        <button class="btn-customize btn-lg btn btn-light"><i class="fas fa-pencil"></i></button>
    </a>
    @endif @endauth
    <h2 class="title">{{ $materials->title }}</h2><br>
</div>


<!-- Main part -->
<div class="posts">
    <h5><i class="fas fa-file" style="color:blue;"></i> Posted Task </h5>
    <div class="post-materials">
        <hr>
        <div class="facebook-post" style="border: 1px solid #ccc; border-radius: 5px; padding: 10px; margin-bottom: 10px;">
            <div class="facebook-post-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h4 style="margin: 0;">{{ $materials->created_at->diffForHumans() }}</h4>
                <div class="dropdown-content" style="position: relative;">
                    <i class="fas fa-chevron-down" style="cursor: pointer; float: right;" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @auth
                            @if (auth()->user()->hasRole('coach') || auth()->user()->hasRole('admin')) 
                                <a class="dropdown-item" href="#" onclick="editMaterial({{ $materials->id }})" style="color:blue;"><i class="fa fa-edit"></i> Edit</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteMatModal" data-materialid="{{ $materials->id }}" onclick="setMaterialId({{ $materials->id }})" style="color:red;"><i class="fa fa-trash"></i> Delete</a>
                            @endif
                        @endauth
                    </div>
                </div>   
            </div>
            <div class="facebook-post-content" style="margin-top: 10px; display: flex; flex-wrap: wrap;">
                {!! nl2br(preg_replace('/https?:\/\/[^\s<]+/', '<a href="$0" target="_blank">$0</a>', $materials->content)) !!}<br>
                @foreach ($materials->files as $file)
                    @php
                        $extension = pathinfo($file->path, PATHINFO_EXTENSION);
                    @endphp
                    <div class="material-item" style="margin-right: 10px; margin-bottom: 10px;">
                        @if (in_array($extension, ['jpg', 'jpeg', 'png','webp', 'gif']))
                             <!-- Image -->
                            <a href="#" title="Click to enlarge">
                                <img class="img-material" src="{{ asset($file->path) }}" alt="Image Preview" data-src="{{ asset($file->path) }}" style="max-height: 150px;">
                            </a>
                        @elseif (in_array($extension, ['mp4', 'webm', 'ogg']))
                            <video controls style="max-width: 100%; height: 150px;">
                                <source src="{{ asset($file->path) }}" type="video/{{ $extension }}">
                                Your browser does not support the video tag.
                            </video>
                        @elseif (in_array($extension, ['mp3', 'wav', 'ogg']))
                            <audio controls style="max-width: 100%; height: 50px;">
                                <source src="{{ asset($file->path) }}" type="audio/{{ $extension }}">
                                Your browser does not support the audio tag.
                            </audio>
                        @elseif (in_array($extension, ['pdf', 'doc', 'docx', 'txt']))
                            <a href="{{ asset($file->path) }}" target="_blank">
                                <i class="fas fa-file-{{ $extension }}"></i> {{ $file->path }}
                            </a>
                        @else
                            <a href="{{ asset($file->path) }}" target="_blank">{{ $file->path }}</a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


<!-- Image preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img src="" id="zoomedImage" style="width: 100%; max-height: 80vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<!-- customize Modal -->
<div class="modal fade" id="customizeModal" tabindex="-1" role="dialog" aria-labelledby="customizeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customizeModalLabel">Change Cover Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{-- route('custom.class', ['id' => $sport->id]) --}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Choose an image file</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" onchange="loadFile(event)" accept="image/*" name="file" required>
                    </div>
                    <div class="text-center mt-3">
                        <img id="output" style="max-width: 100%; align-items: center;" class="img-thumbnail">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!--Edit Material Modal -->
<div class="modal fade" id="editMaterialModal" tabindex="-1" aria-labelledby="editMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMaterialModalLabel">Edit Task Title or Content</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for editing material content -->
                <form id="editMaterialForm" method="POST" action="{{ route('material.update') }}" enctype="multipart">
                    <!-- Form fields for editing content -->
                    <div class="mb-3">
                        @csrf
                         <input type="hidden" name="_method" value="PUT">
                        <label for="materialTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="materialTitle" name="title" placeholder="Enter title">
                    </div>
                    <div class="mb-3">
                        <label for="materialContent" class="form-label">Content</label>
                        <textarea class="form-control" id="materialContent" name="content" rows="5" placeholder="Enter content"></textarea>
                    </div>
                    <!-- Hidden input field for material ID -->
                    <input type="hidden" id="materialId" name="material_id">
                    <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                    
                </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
  document.addEventListener("DOMContentLoaded", function() {
    const accordionItems = document.querySelectorAll('.accordion-item');

    accordionItems.forEach(item => {
      const title = item.querySelector('.accordion-title');
      const content = item.querySelector('.accordion-content');

      title.addEventListener('click', function() {
        // Toggle the display of content for the clicked accordion item
        content.style.display = (content.style.display === 'block') ? 'none' : 'block';
      });
    });
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const accordionItems = document.querySelectorAll('.accordion-item');

    accordionItems.forEach(item => {
      const title = item.querySelector('.accordion-title');
      const content = item.querySelector('.accordion-content');

      title.addEventListener('click', function() {
        // Toggle the display of content for the clicked accordion item
        content.style.display = (content.style.display === 'block') ? 'none' : 'block';
      });
    });
  });
    function setMaterialId(materialId) {
        document.getElementById('materialzId').value = materialId;
    }

/// Function to handle AJAX request and open modal
function editMaterial(materialId) {
    // Get CSRF token value
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // AJAX request to fetch material details
    $.ajax({
        url: '/materials/' + materialId + '/edit',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            // Populate the form fields in the modal with material details
            $('#materialId').val(materialId);
            $('#materialTitle').val(response.material.title);
            $('#materialContent').val(response.material.content);

            // Show the modal
            $('#editMaterialModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Optionally, display an error message to the user
        }
    });
}

</script>

 <script>
    document.addEventListener('DOMContentLoaded', () => {
        setupImageZoomModal();
    });

    function setupImageZoomModal() {
        const images = document.querySelectorAll('.img-material');

        images.forEach(image => {
            image.addEventListener('click', () => {
                const zoomedImage = document.getElementById('zoomedImage');
                zoomedImage.src = image.dataset.src; // Use dataset.src to get the value of data-src

                // Show the Bootstrap modal using JavaScript
                const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                modal.show();
            });
        });
    }
</script>
@endsection
@section('title', $materials->title . ' | ' . $materials->sport->name)

