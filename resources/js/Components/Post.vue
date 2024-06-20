<script setup>
import { EllipsisVerticalIcon } from "@heroicons/vue/24/solid";
import { PencilSquareIcon, FolderIcon } from "@heroicons/vue/16/solid";
import { ref } from "vue";

const props = defineProps({
    post: Object
});

const emit = defineEmits(['showEditModal']);

function showEditModal() {
    emit('showEditModal', props.post);
}

const showMenu = ref(false);
</script>

<template>
    <div class="box post">
        <div class="post-header">
            <div class="avatar">
                <img :src="'/storage/'+post.user.avatar" alt="">
            </div>
            <div class="name">
                <div>{{ post.user.name }}</div>
                <div>{{ post.created_at }}</div>
            </div>
            <div class="post-menu">
                <EllipsisVerticalIcon class="menu-icon" @click="showMenu = !showMenu" />

                <ul class="menu" v-if="showMenu">
                    <li class="menu-item" @click="showEditModal">
                        <PencilSquareIcon />
                        <span>Edit</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="body">{{ post.body }}</div>

        <!-- Attachments -->
        <div v-if="post.attachments.length" class="attachments">
            <div 
                class="attachment"
                :class="{full: post.attachments.length == 1, half: post.attachments.length == 2}"
                v-for="file of post.attachments"
            >
                <div class="img" v-if="file.mime.split('/')[0] === 'image'">
                    <img :src="'/storage/' + file.path" alt=""/>
                </div>

                <div class="file" v-else>
                    <FolderIcon class="file-icon" />
                    <div>
                        {{ file.name }}
                    </div>
                </div>
            </div>
        </div>

        <div class="post-interactions">
            <button class="interaction like">Like</button>
            <button class="interaction Comment">Comment</button>
        </div>
    </div>
</template>