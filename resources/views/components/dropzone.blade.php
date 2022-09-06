<div class="dropzone" id="dropzone{{ $name }}">
    <div class="dz-message" data-dz-message>
        <span class="dz-message__span--main">{{ $dropzoneConfig['label'] }}</span>
        <span class="dz-message__span--description">{{ $dropzoneConfig['description'] }}</span>
        <div class="dz-message__button-container">
            <button type="button" class="dz-message__button">{{ $dropzoneConfig['uploadButton'] }}</button>
        </div>
    </div>
</div>
<input
    type="text"
    name="{{ $name }}"
    id="{{ $name }}"
    hidden
>
<div class="image-preview-container" id="imagePreviewContainer">
    @if(!is_null($value))
        <div class="image-preview" id="imagePreview{{ $pageId }}">
            <div class="image-preview__inner">
                <div class="image-preview__delete js-delete-image" data-id="{{ $pageId }}"></div>
                <img src="{{ asset(Storage::url($value)) }}" alt="">
            </div>
        </div>
    @endif
</div>

<script>
    Dropzone.autoDiscover = false;

    $(document).ready(function () {

        document.querySelectorAll('.js-delete-image').forEach(x => {
            x.addEventListener('click', function (e) {
                console.log(this.dataset.id);

                $.ajax({
                    url: "{{ route('admin.pages.delete-icon') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': this.dataset.id,
                    },
                    success: function (response) {
                        $('#imagePreview{{ $pageId }}').remove();
                    },
                })
            });
        });

        $('#dropzone{{ $name }}').dropzone({
            url: "{{ route('admin.pages.save-icon') }}",
            headers: {
                'x-csrf-token': "{{ csrf_token() }}",
            },
            paramName: "{{ $name }}",
            autoProcessQueue: true,
            uploadMultiple: false,
            maxFiles: 1,
            maxFilesize: 2, // megabytes
            acceptedFiles: "{{ '.' . config('app.page.icon.mimes') }}",
            addRemoveLinks: true,
            dictRemoveFile: "Отменить",
            removedfile: function (file) {
                document.getElementById("{{ $name }}").value = null;
                $(file.previewElement).remove();
                return true;
            },
            init: function () {

                // to allow only one file upload
                // if file is already selected, then when choose another file - previous file will be removed
                this.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });

            },
            success: function (file, response) {
                document.getElementById("{{ $name }}").value = response.data.icon;
            }
        });
    })
</script>
