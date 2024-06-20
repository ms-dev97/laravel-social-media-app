<script setup>
import {useForm} from '@inertiajs/vue3';
import { PaperClipIcon, FolderIcon } from '@heroicons/vue/16/solid';
import { ref } from 'vue';

const postForm = useForm({
    body: '',
    files: [],
});

const files = ref([]);

async function attachFile(e) {
    for (const file of e.target.files) {
        files.value.push({
            file,
            url: await readFile(file)
        });
    }
}

async function readFile(file) {
    return new Promise((res, rej) => {
        const fr = new FileReader();
        fr.onload = () => res(fr.result);
        fr.onerror = rej;
        fr.readAsDataURL(file);
    });
}

function removeFile(file) {
    files.value = files.value.filter(item => item != file);
}

function submitPost() {
    postForm.files = files.value.map(file => file.file);

    postForm.post(route('post.store'), {
        onSuccess: () => {
            postForm.body = '';
            postForm.files = [];
            files.value = [];
        },
    });
}
</script>

<template>
    <div class="box post-form">
        <textarea v-model="postForm.body" class="post-body" name="post" id="post" placeholder="What's on your mind..."></textarea>
        
        <label for="attachment-input">
            <PaperClipIcon class="attatch-icon" />
            <input type="file" id="attachment-input" @change="attachFile" multiple>
        </label>

        <div class="attachments" v-if="files.length">
            <div class="attachment" v-for="(file, index) of files">
                <div class="delete" @click="removeFile(file)">x</div>

                <div class="img" v-if="file.file.type.split('/')[0] === 'image'">
                    <img :src="file.url" alt=""/>
                </div>

                <div class="file" v-else>
                    <FolderIcon class="file-icon" />
                    <div>
                        {{ file.file.name }}
                    </div>
                </div>
            </div>
        </div>
        <button @click="submitPost" class="btn submit">Post</button>
    </div>
</template>