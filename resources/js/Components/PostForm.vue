<script setup>
import {useForm} from '@inertiajs/vue3';

const postForm = useForm({
    body: '',
});

function submitPost() {
    postForm.post(route('post.store'), {
        onSuccess: () => postForm.body = '',
    });
}
</script>

<template>
    <div class="box post-form">
        <textarea v-model="postForm.body" class="post-body" name="post" id="post" placeholder="What's on your mind..."></textarea>
        <button @click="submitPost" class="btn submit">Post</button>
    </div>
</template>