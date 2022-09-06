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

@error($name)
<div class="validation-error">
    {{ $message }}
</div>
@enderror

<script>
    Dropzone.autoDiscover = false;

    $(document).ready(function () {
        $('#dropzone{{ $name }}').dropzone({
            url: "{{ route('admin.selection_info.upload') }}",
            headers: {
                'x-csrf-token': "{{ csrf_token() }}",
            },
            paramName: "{{ $name }}",
            autoProcessQueue: true,
            uploadMultiple: false,
            maxFiles: 1,
            maxFilesize: 15, // megabytes
            acceptedFiles: "{{ '.xlsx' }}",
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
                document.getElementById("{{ $name }}").value = response.data.filename;
            }
        });
    })
</script>
