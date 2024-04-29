<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import {useForm} from '@inertiajs/vue3';
import { computed } from 'vue';

const updateCoverForm = useForm({
    cover: null
});

const updateAvatarForm = useForm({
    avatar: null
});

const authUser = usePage().props.auth.user;
const isMyProfile = computed(() => authUser?.id == props.user.id);


const props = defineProps({
    user: {
        type: Object
    }
});

const coverImgSrc = ref(null);
const avatarImgSrc = ref(null)

function updateCover(e) {
    const cover = e.target.files[0];
    updateCoverForm.cover = cover;
    const reader = new FileReader();
    reader.readAsDataURL(cover);
    reader.onload = () => {
        coverImgSrc.value = reader.result;
    };
}

function updateAvatar(e) {
    const avatar = e.target.files[0];
    updateAvatarForm.avatar = avatar;
    const reader = new FileReader();
    reader.readAsDataURL(avatar);
    reader.onload = () => {
        avatarImgSrc.value = reader.result;
    };
}

function cancleUpdateCover() {
    coverImgSrc.value = null;
}

function cancleUpdateAvatar() {
    avatarImgSrc.value = null;
}

function submitCoverImage() {
    updateCoverForm.post(route('profile.updateCover'), {
        onSuccess: () => {
            coverImgSrc.value = null;
            updateCoverForm.cover = null;
        }
    });
}

function submitAvatarImage() {
    updateAvatarForm.post(route('profile.updateAvatar'), {
        onSuccess: () => {
            avatarImgSrc.value = null;
            updateAvatarForm.avatar = null;
        }
    });
}

</script>

<template>
    <Head title="Profile" />

    <AppLayout>
        <div class="profile-page container">
            <div class="user-cover">
                <img class="cover-img" :src="coverImgSrc || '/storage/' + user.cover" alt="">
                <template v-if="isMyProfile">
                    <label for="cover" class="cover-upload" v-if="coverImgSrc == null">
                        Upload image
                        <input type="file" name="cover" id="cover" accept="image/*" @change="updateCover">
                    </label>

                    <div class="cover-upload-action" v-else>
                        <button class="cancle" @click="cancleUpdateCover">Cancle</button>
                        <button class="save" @click="submitCoverImage">Save</button>
                    </div>
                </template>
            </div>

            <div class="user-info">
                <div class="avatar">
                    <img class="avatar-img" :src="avatarImgSrc || '/storage/' + user.avatar" alt="">

                    <div class="update-avatar" v-if="isMyProfile">
                        <label for="avatar" class="avatar-upload" v-if="avatarImgSrc == null">
                            Upload
                            <input type="file" name="avatar" id="avatar" accept="image/*" @change="updateAvatar">
                        </label>

                        <div v-else class="avatar-upload-action">
                            <button class="cancle" @click="cancleUpdateAvatar">Cancle</button>
                            <button class="save" @click="submitAvatarImage">Save</button>
                        </div>
                    </div>
                </div>

                <div class="user-name">
                    <div class="name">{{ user.name }}</div>
                    <div class="followers">100 Followers</div>
                </div>

                <a v-if="isMyProfile" :href="route('profile.edit')" class="user-edit">Edit profile</a>
            </div>
        </div>
    </AppLayout>
</template>