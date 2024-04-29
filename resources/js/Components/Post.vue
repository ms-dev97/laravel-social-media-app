<script setup>
    defineProps([
        'name',
        'avatar',
        'body',
        'createdAt'
    ])
</script>

<template>
    <div class="box post">
        <div class="post-header">
            <div class="avatar">
                <img :src="'/storage/'+avatar" alt="">
            </div>
            <div class="name">
                <div>{{ name }}</div>
                <div>{{ createdAt }}</div>
            </div>
        </div>

        <div class="body">{{ body }}</div>

        <div class="post-interactions">
            <button class="interaction like">Like</button>
            <button class="interaction Comment">Comment</button>
        </div>
    </div>
</template>