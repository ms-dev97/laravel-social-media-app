<script setup>
import { ref } from "vue";
import Post from "./Post.vue";
import PostEditModal from "./PostEditModal.vue";

defineProps(['posts']);

const showModal = ref(false);
const postEdit = ref({});

function showEditModal(post) {
    postEdit.value = post;
    showModal.value = true;
}

function hideModal() {
    postEdit.value = {};
    showModal.value = false;
}

</script>

<template>
    <div class="posts">
        <Post
            v-for="post of posts"
            :key="post.id"
            :post="post"
            @showEditModal="showEditModal"
        />
    </div>

    <PostEditModal
        v-if="showModal"
        :id="postEdit.id"
        :body="postEdit.body"
        @hideModal="hideModal"
    />
</template>