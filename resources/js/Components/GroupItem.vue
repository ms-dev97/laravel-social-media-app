<script setup>
defineProps({
    // avatar,
    name
})
</script>

<template>
    <div class="group-item">
        <div class="avatar"></div>
        <div class="name">{{ name }}</div>
    </div>
</template>