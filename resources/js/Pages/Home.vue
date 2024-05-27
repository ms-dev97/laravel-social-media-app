<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PostForm from '@/Components/PostForm.vue';
import GroupItem from '@/Components/GroupItem.vue';
import PostList from '@/Components/PostList.vue';

defineProps({
    'posts': Object,
})

</script>

<template>
    <Head title="Welcome" />
    
    <AppLayout>
        <div class="wrapper home-page">

            <div>
                <div class="box">
                    <h4 class="title">My Groups</h4>
                    <GroupItem name="Laravel Community" />
                </div>
            </div>

            <main>
                <PostForm />
                
                <PostList
                    v-if="posts.data.length"
                    :posts="posts.data"
                />

                <div class="box" v-else>
                    There are no posts yet.
                </div>
            </main>
            
            <div>
                col2
            </div>
        </div>
    </AppLayout>
</template>
