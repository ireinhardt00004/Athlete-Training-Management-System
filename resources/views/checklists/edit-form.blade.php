@extends('layouts.class')
@section('content')
<style>
     .nav {
        font-size: 20px;
        font-family:   sans-serif;
    }
 
    /* Checklist preview container */
    .checklist-preview {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 10px;
    }

    /* Checklist item */
    .checklist-item {
        margin-bottom: 20px;
    }

    /* Label styling */
    label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    /* Form control styling */
    .form-control {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }
    /* File input styling */
    input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        text-transform: uppercase;
    }

    .custom-file-upload:hover {
        background-color: #0056b3;
    }
    /* Range input styling */
    input[type="range"] {
        width: 100%;
        height: 20px;
        margin-top: 5px;
        -webkit-appearance: none;
        background-color: #f8f9fa;
        border-radius: 10px;
        outline: none;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        background-color: #007bff;
        border-radius: 50%;
        cursor: pointer;
    }

    /* Form check input styling */
    .form-check-input {
        margin-right: 10px;
    }

    /* Form check label styling */
    .form-check-label {
        display: inline-block;
        margin-right: 15px;
    }

    /* Submit button styling */
    .btn-primaries {
        display: block;
        width: 100%;
        padding: 10px;
        margin-top: 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        text-transform: uppercase;
        font-weight: bold;
    }
</style>

<div class="nav-classlink">
  <div class="nav" style="margin-top: 20px;">
    <ul class="nav nav-tabs" style="background-color: #f8f9fa; border-radius: 8px; padding: 10px;">
        <li class="nav-item">
            <a class="nav-link " aria-current="page"  href="{{ route('class-page', ['sport_id' => $material->sport->id]) }}"style="color: #333; font-size: 16px;">Back to {{ $material->sport->name }} </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('material.page', ['id' => $material->id]) }}"style="color: #333; font-size: 16px;">{{ $material->title }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page"  href="{{ route('checklists.index', ['id' => $material->id]) }}" style="color: #333; font-size: 16px; font-weight: bold;">{{ $checklist->title}} | Checklist</a>
        </li>
    </ul>
</div>

         <!-- Page Heading -->
            
  @if($tableExists)
    <a href="#AlreadySavedForm">
        <button class="btn btn-success" style="margin:5px; float: right;" title="Form already Saved">Saved <i class="fa fa-check"></i></button>
    </a>
@else
    <a href="#" data-target="#saveFormModal" data-toggle="modal">
        <button class="btn btn-success" style="margin:5px; float: right;"><i class="fa fa-send"></i> Save Form</button>
    </a>
    <a href="#" data-toggle="modal" data-target="#createModal"><button class="btn btn-info" style="margin:5px; float: right;  color:white;"><i class="fa fa-pencil"></i>  Insert Field</button></a>
@endif
<a href="#" data-toggle="modal" data-target="#deleteModal"><button class="btn btn-danger" style="margin:5px; float: right; "><i class="fa fa-trash"></i>  Reset Field</button></a>

<br>
<!-- Checklist Preview -->
<h1>Checklist Preview</h1><br>

<!-- Checklist Preview -->
<h1></h1><br>
<form action="{{ route('submit-checklist', ['id' => $checklist->id]) }}" method="POST" enctype="multipart/form-data">
<div class="checklist-preview">
    @csrf
   <center> <h2 class=" mb-2 text-gray-800">{{ $checklist->title}}</h2></center>
    @if($processedItems)
        @foreach($processedItems as $item)
            <div class="checklist-item">
                @if($item->field_type === 'file')
                    <!-- File input type -->
                    <div class="form-group">
                    <label for="{{ $item->field_name }}">{{ $item->field_name }}</label>
                    <label class="custom-file-upload">
                        Choose File
                        <input type="file" name="{{ $item->field_name }}" accept="{{ $item->options }}/*">
                    </label>
                </div>
                <hr>

                @elseif($item->field_type === 'range')
                    <!-- Slider input type -->
                    <div class="form-group">
                        <label for="{{ $item->field_name }}">{{ $item->field_name }}</label>
                        <input class="form-control" type="range" name="{{ $item->field_name }}" min="{{ $item->minimum_threshold }}" max="{{ $item->maximum_threshold }}" onchange="updateSliderValue(this)">
                        <div id="{{ $item->field_name }}_values">Min: {{ $item->minimum_threshold }} | Range: <span id="{{ $item->field_name }}_option">0</span> | Max: {{ $item->maximum_threshold }}</div><hr>
                    </div>
                    <script>
                        function updateSliderValue(slider) {
                            var optionValue = document.getElementById('{{ $item->field_name }}_option');
                            optionValue.textContent = slider.value;
                        }
                    </script>
                @elseif(in_array($item->field_type, ['text', 'textarea', 'label']))
                    <!-- Other input types -->
                    <label for="{{ $item->field_name }}">{{ $item->field_name }}</label>
                    @if($item->field_type === 'textarea')
                        <textarea class="form-control" name="{{ $item->field_name }}"></textarea>
                    @elseif($item->field_type === 'label')
                        <!-- Render label -->
                        <p>{{ $item->options }}</p>
                    @else
                        <input class="form-control" type="{{ $item->field_type }}" name="{{ $item->field_name }}">
                    @endif<hr>
                @elseif($item->field_type === 'radio' || $item->field_type === 'checkbox')
                    <!-- Radio or checkbox input type -->
                    <label>{{ $item->field_name }}</label>
                    @foreach(explode(',', $item->options) as $option)
                        @if ($option !== null)
                            <div class="form-check">
                                <input class="form-check-input" type="{{ $item->field_type }}" name="{{ $item->field_name }}[]" id="{{ $item->field_name }}_{{ $loop->index }}" value="{{ $option }}">
                                <label class="form-check-label" for="{{ $item->field_name }}_{{ $loop->index }}">{{ $option }}</label>
                            </div>
                        @endif
                    @endforeach<hr>
                @endif

            </div>
        @endforeach
    
 <button type="submit" class="btn btn-primaries btn-success" style="margin-top: 20px; left: 0;"><i class="fa fa-send"></i> Submit</button>
    </form>
@else
    <p>No checklist items available.</p>
@endif
</div>

 <!-- Save form  Modal -->
<div class="modal fade" id="saveFormModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Save Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('save.checklistform', ['id' => $checklist->id]) }}">
                    @csrf
                    Are you sure you want to save this form?
                    <div class="form-group">
               Notify Athletes Via Email<input type="checkbox" id="notify-athlete" name="notify_athletes" style="width: 20px; height: 20px; margin-left: 5px;" value="">
             </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>  Cancel</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i>  Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="customizeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customizeModalLabel">Insert Field</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('checklists.store', ['id' => $checklist->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="descr">Please choose on the fields.</label>
                    </div>
                    <div style="width:101%;height: 120px; border: 1px solid black;">
                        <center><h6>Preview</h6></center>
                        <div class="form-group" id="preview-container" style="margin:5px;">
                            <!-- Preview will be appended here -->
                        </div> 
                    </div>
                    <div class="form-group" >
                        <label for="field_type">Input type of the Field</label><br>
                        <select class="form-control" id="field_type" name="field_type" required style="font-size:18px; padding: 0;">
                            <option disabled selected>Select Input Type</option>
                            <option class="form-control" value="label">Label</option>
                            <option value="text">Text</option>
                            <option value="textarea">Text Area</option>
                            <option value="radio">Radio buttons</option>
                            <option value="checkbox">Check box</option>
                            <option value="range">Slider</option>
                            <option value="file">File Upload</option>
                        </select>
                    </div>
                    <div class="form-group" id="file-options" style="display: none;">
                        <label for="file_options">File Options</label>
                        <select class="form-control" id="file_options" name="file_options">
                            <option value="selected" disabled selected>Select type of file to upload</option>
                            <option value="document">Document</option>
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                    <div id="options-container" class="mb-3">
                        <label for="options" class="form-label">(For Checkbox and Radio Buttons):<br>
                        Options B</label>
                        <div class="option-inputs">
                            <input type="text" name="options[]" class="form-control" placeholder="Example: Yes or No .. etc">
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" id="addOptionBtn"><i class="fa fa-plus"></i> Add more Option</button>
                    </div>
                    <div id="range-container" class="mb-3">
                        <label for="range" class="form-label">Threshold Number (For Slider):</label>
                        <div class="range-inputs">
                            <div class="range-threshold">
                                <input type="text" name="range[]" class="form-control mt-2" placeholder="Minimum Number">
                            </div>
                            <div class="range-threshold">
                                <input type="text" name="range[]" class="form-control mt-2" placeholder="Maximum Number">
                            </div>
                        </div>
                       {{-- <button type="button" class="btn btn-secondary mt-2" id="addRangeBtn"><i class="fa fa-plus"></i> Add more Threshold</button>--}}
                    </div>
                    <div class="form-group">
                        <label for="field_name">Name of the Field</label>
                        <input type="text" class="form-control" id="field_name" name="field_name" value="{{ old('field_name') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Is it required to fill up? </label>
                        <select for="is_required" name="is_required" style="width: 100%;">
                            <option class="form-check-input" id="is_required"  value="1">YES</option>
                            <option class="form-control" id="is_required"  value="0">NO</option>
                        </select>
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

 <!-- Deleting Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Reset Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('reset.checklistform', ['id' => $checklist->id]) }}">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    Are you sure you want to delete and reset this form?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        // Function to handle the field type selection
        function updateFieldType() {
            var fieldType = $('#field_type').val();

            if (fieldType === 'file') {
                $('#file-options').show();
                // Enable the file options select
                $('#file_options').prop('disabled', false);
            } else {
                $('#file-options').hide();
                // Disable the file options select and reset its value
                $('#file_options').prop('disabled', true);
                $('#file_options').val('selected'); // Default to 'document' when hidden
            }

            if (fieldType === 'checkbox' || fieldType === 'radio') {
                $('#options-container').show();
            } else {
                $('#options-container').hide();
            }

            if (fieldType === 'range') {
                $('#range-container').show();
                $('#addRangeBtn').show();
            } else {
                $('#range-container').hide();
                $('#addRangeBtn').hide();
            }
        }

        // Show/hide additional options based on selected field type
        $('#field_type').change(function () {
            updateFieldType();
            updatePreview(); // Also update the preview when the field type changes
        });

        // Show/hide additional options based on selected field type on page load
        updateFieldType();

        // Function to update the preview based on the selected field type
        function updatePreview() {
            var fieldType = $('#field_type').val();
            var previewHTML = '';

            switch (fieldType) {
                case 'label':
                    previewHTML = '<label for="preview_field">Labels</label>';
                    break;
                case 'text':
                    previewHTML = '<input type="text" class="form-control" id="preview_field" placeholder="Enter text here">';
                    break;
                case 'textarea':
                    previewHTML = '<textarea class="form-control" id="preview_field" placeholder="Enter text here"></textarea>';
                    break;
                case 'file':
                    previewHTML = '<input type="file" class="form-control" id="preview_field" placeholder="Choose file to upload">';
                    break;
                case 'radio':
                    previewHTML = '<div class="form-check">';
                    previewHTML += '<input class="form-check-input" type="radio" name="preview_radio" id="radio_option1" value="option1" checked>';
                    previewHTML += '<label class="form-check-label" for="radio_option1">Option 1</label>';
                    previewHTML += '</div>';
                    previewHTML += '<div class="form-check">';
                    previewHTML += '<input class="form-check-input" type="radio" name="preview_radio" id="radio_option2" value="option2">';
                    previewHTML += '<label class="form-check-label" for="radio_option2">Option 2</label>';
                    previewHTML += '</div>';
                    break;
                case 'checkbox':
                    previewHTML = '<div class="form-check">';
                    previewHTML += '<input class="form-check-input" type="checkbox" id="checkbox_option1" value="option1">';
                    previewHTML += '<label class="form-check-label" for="checkbox_option1">Option 1</label>';
                    previewHTML += '</div>';
                    previewHTML += '<div class="form-check">';
                    previewHTML += '<input class="form-check-input" type="checkbox" id="checkbox_option2" value="option2">';
                    previewHTML += '<label class="form-check-label" for="checkbox_option2">Option 2</label>';
                    previewHTML += '</div>';
                    break;
                case 'range':
                    previewHTML = '<input type="range" class="form-control-range" id="preview_field">';
                    break;
                // Add cases for other field types as needed
                default:
                    break;
            }

            // Update the preview container with the generated HTML
            $('#preview-container').html(previewHTML);
        }

        // Show preview based on selected field type when the page loads
        updatePreview();
       // Add event listener to add more options
        $('#addOptionBtn').click(function () {
    var fieldType = $('#field_type').val();
    var numExistingOptions = $('[id^=' + fieldType + '_option]').not('.preview [id^=' + fieldType + '_option]').length;
    var numNewOptions = $('.option-inputs input[type=' + fieldType + ']').not('.preview input[type=' + fieldType + ']').length;
    var numOptions = numExistingOptions + numNewOptions;

    // Convert the number to a letter starting from A
    var optionLetter = String.fromCharCode(65 + numOptions);

    var newOptionHTML = '<div class="form-group">';
    newOptionHTML += '<label for="' + fieldType + '_option' + optionLetter + '">Option ' + optionLetter + '</label>';
    newOptionHTML += '<input type="text" name="options[]" class="form-control" id="' + fieldType + '_option' + optionLetter + '" placeholder="Option ' + optionLetter + '">';
    newOptionHTML += '</div>';

    // Append the new option directly to the options-container div
    $('#options-container').append(newOptionHTML);
});
     // Add event listener to add more range inputs
        $('#addRangeBtn').click(function () {
            var newInputHTML = '<div class="range-threshold">';
            newInputHTML += '<input type="text" name="options[]" class="form-control mt-2" placeholder="Threshold">';
            newInputHTML += '</div>';
            $('.range-inputs').append(newInputHTML);
        });
    });
</script>

@endsection

@section('title', $checklist->title . ' | Checklist')
