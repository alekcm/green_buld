<textarea class="" name="{{ $name }}" id="{{ $name }}">{!! $value !!}</textarea>

<script>

    class UploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }))
        }

        abort() {
            if (this.xhr) {
                this.xhr.abort();
            }
        }

        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();
            xhr.open('POST', "{{ route('admin.pages.upload-image') }}", true);
            xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
            xhr.responseType = 'json';
        }

        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${file.name}.`;

            xhr.addEventListener('error', () => reject(genericErrorText));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const response = xhr.response;

                if (!response || response.error) {
                    return reject(response && response.error ? response.error.message : genericErrorText);
                }

                resolve({
                    default: response.data.url
                });
            });

            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }

        _sendRequest(file) {
            const data = new FormData();
            data.append('image', file);
            this.xhr.send(data);
        }
    }

    function SimpleUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new UploadAdapter(loader);
        };
    }

    ClassicEditor
        .create(document.querySelector('#{{ $name }}'), {
            extraPlugins: [SimpleUploadAdapterPlugin,],
            height: 400,
            htmlSupport: {
                allow: [{
                    name: 'div',
                    classes: ['js-slider', 'js-image-caption',],
                    styles: true,
                }, {
                    name: 'iframe',
                    classes: true,
                    styles: true,
                    attributes: true,
                }
                ],
            },

            image: {
                insert: {
                    type: 'inline',
                },
            },

            heading: {
                options: [
                    {model: 'paragraph', title: 'Paragraph', class: ''},
                    {model: 'heading1', view: 'h2', title: 'Heading 1', class: ''},
                    {model: 'heading2', view: 'h3', title: 'Heading 2', class: ''},
                    {
                        model: 'divSlider',
                        view: {
                            name: 'div',
                            classes: 'js-slider'
                        },
                        title: 'Слайдер',
                        class: 'js-slider',
                        converterPriority: 'high'
                    },
                    {
                        model: 'divImageCaption',
                        view: {
                            name: 'div',
                            classes: 'js-image-caption'
                        },
                        title: 'Подпись изображения',
                        class: 'js-image-caption',
                        converterPriority: 'high'
                    },
                ]
            }

        })
        .catch(error => {
            console.log(error);
        });
</script>
