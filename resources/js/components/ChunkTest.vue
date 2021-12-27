
<template>
    <div>
        <input type="file" @change="select">
        <progress :value="progress"></progress>
    </div>
</template>

<script>
    export default {
        watch: {
            chunks(n, o) {
                if (n.length > 0) {
                    this.upload();
                }
            }
        },

        data() {
            return {
                file: null,
                chunks: [],
                uploaded: 0
            };
        },

        computed: {
            progress() {
                if(this.file != null){
                    return Math.floor((this.uploaded * 100) / this.file.size);
                }
                
            },
            formData() {
                let formData = new FormData;

                formData.set('is_last', this.chunks.length === 1);
                formData.set('file', this.chunks[0], `${this.file.name}.part`);

                return formData;
            },
            config() {
                return {
                    method: 'POST',
                    data: this.formData,
                    url: 'api/chunkUploadTest',
                    headers: {
                        'Content-Type': 'application/octet-stream'
                    },
                    onUploadProgress: event => {
                        this.uploaded += event.loaded;
                    }
                };
            }
        },

        methods: {
            select(event) {
                this.file = event.target.files.item(0);
                this.createChunks();
            },
            upload() {
                axios(this.config).then(response => {
                    this.chunks.shift();
                }).catch(error => {});
            },
            createChunks() {
                alert(this.file.size)
                let size = 10000000, chunks = Math.ceil(this.file.size / size);

                for (let i = 0; i < chunks; i++) {
                    this.chunks.push(this.file.slice(
                        i * size, Math.min(i * size + size, this.file.size), this.file.type
                    ));
                }
            }
        }
    }
</script>
