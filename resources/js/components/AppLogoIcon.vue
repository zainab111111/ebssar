<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" width="1600" height="1600" viewBox="0 0 1600 1600" role="img"
        aria-label="شعار منصة إبصار - عين مع مايكروفون ونص عربي، خلفية شفافة">
        <rect width="100%" height="100%" fill="none" />
        <!-- Mark -->
        <g transform="translate(800,560)">
            <!-- Eye -->
            <path d="M -460 0 C -270 -200, 70 -200, 260 0 C 70 200, -270 200, -460 0 Z" stroke="#E1BEE7"
                stroke-width="36" fill="none" stroke-linecap="round" stroke-linejoin="round" />
            <!-- Mic core -->
            <g transform="translate(-100,0)">
                <circle cx="0" cy="0" r="120" fill="#E1BEE7" opacity="0.18" />
                <rect x="-60" y="-150" width="120" height="210" rx="60" fill="#E1BEE7" />
                <g opacity="0.35">
                    <rect x="-46" y="-124" width="92" height="10" fill="#E1BEE7" />
                    <rect x="-46" y="-102" width="92" height="10" fill="#E1BEE7" />
                    <rect x="-46" y="-80" width="92" height="10" fill="#E1BEE7" />
                    <rect x="-46" y="-58" width="92" height="10" fill="#E1BEE7" />
                </g>
                <line x1="0" y1="70" x2="0" y2="160" stroke="#E1BEE7" stroke-width="36" stroke-linecap="round" />
                <line x1="-160" y1="210" x2="160" y2="210" stroke="#E1BEE7" stroke-width="36" stroke-linecap="round" />
            </g>
        </g>
        <!-- Wordmark -->
        <g transform="translate(800,1180)" text-anchor="middle">
            <text x="0" y="0" font-size="220" fill="#E1BEE7" font-family="Noto Kufi Arabic, Cairo, Tahoma, sans-serif"
                font-weight="800">منصة إبصار</text>
        </g>
    </svg>
</template>
