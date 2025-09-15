<script setup lang="ts">
import { CircuitInterface } from '@/interfaces/custom';

defineProps<{
        itineraires: Array<CircuitInterface[]>
    }>();
</script>

<template>
<h1>Itineraires</h1>
<p>
    {{ itineraires }}
</p>
</template>