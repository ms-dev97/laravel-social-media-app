<script setup>
import {useForm} from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { ref } from 'vue';
import { watch } from 'vue';

const props = defineProps({
    id: Number,
    body: String,
});

const emit = defineEmits(['hideModal']);

const postForm = useForm({
    body: props.body,
});

// when opening a modal for another post update this content
const postBody = ref(props.body);
watch(() => props.body, (newVal, oldVal) => postBody.value = newVal);

function handleBodyChange(e) {
    postForm.body = e.target.value;
}

function submitPost() {
    postForm.put(route('post.update', props.id), {
        onSuccess: () => {
            postForm.body = '';
            emit('hideModal');
        },
    });
}

function hideModal() {
    emit('hideModal');
}
</script>

<template>
    <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-300 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
    >
    <div class="post-edit-modal">
        <div class="overlay" @click="hideModal"></div>
        <div class="box post-form">
            <textarea @change="handleBodyChange" v-model="postBody" class="post-body" name="post" id="post" placeholder="What's on your mind..."></textarea>
            <button @click="submitPost" class="btn submit">Post</button>
        </div>
    </div></Transition>
</template>