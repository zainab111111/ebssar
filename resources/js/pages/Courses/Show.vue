<template>
    <Head
        :title="
            props.currentLesson ? `${props.currentLesson.title} - ${props.course?.name}` : props.course ? `${props.course.name} - Courses` : 'Courses'
        "
    />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <SidebarProvider>
                <CourseSidebar :course="props.course" :lessons="props.lessons" :currentLesson="props.currentLesson" />
                <main class="flex-1 p-6">
                    <!-- Display lesson content if a lesson is selected -->
                    <div v-if="props.currentLesson" class="space-y-6">
                        <div class="border-b pb-4">
                            <h1 class="text-3xl font-bold text-gray-900">
                                {{ props.currentLesson.title }}
                            </h1>
                        </div>

                        <!-- Debug information (remove in production) -->
                        <!-- <div class="rounded-lg bg-yellow-50 p-4 text-xs">
                            <strong>Debug Info:</strong><br />
                            Audio field: {{ props.currentLesson.audio }}<br />
                            Audio URL: {{ props.currentLesson.audio_url }}<br />
                            Has audio field: {{ !!props.currentLesson.audio }}<br />
                            Has audio_url: {{ !!props.currentLesson.audio_url }}
                        </div> -->

                        <!-- Audio player if audio exists -->
                        <div v-if="props.currentLesson.audio_url || props.currentLesson.audio" class="rounded-lg bg-gray-50 p-4">
                            <div class="space-y-2">
                                <h3 class="text-sm font-medium text-gray-700">Lesson Audio</h3>

                                <audio
                                    controls
                                    preload="metadata"
                                    class="w-full"
                                    @error="handleAudioError"
                                    @loadstart="handleAudioLoadStart"
                                    @canplay="handleAudioCanPlay"
                                >
                                    <!-- Try audio_url first -->
                                    <source
                                        v-if="props.currentLesson.audio_url"
                                        :src="props.currentLesson.audio_url"
                                        :type="getAudioType(props.currentLesson.audio_url)"
                                    />
                                    <!-- Fallback to audio field -->
                                    <source
                                        v-else-if="props.currentLesson.audio"
                                        :src="getAudioUrl(props.currentLesson.audio)"
                                        :type="getAudioType(props.currentLesson.audio)"
                                    />
                                    Your browser does not support the audio element.
                                </audio>

                                <!-- Direct download link as fallback -->
                                <div class="mt-2">
                                    <a
                                        :href="props.currentLesson.audio_url || getAudioUrl(props.currentLesson.audio)"
                                        download
                                        class="text-sm text-blue-600 underline hover:text-blue-800"
                                    >
                                        Download Audio File
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Show message if no audio -->
                        <div v-else class="rounded-lg bg-gray-100 p-4 text-center text-gray-500">No audio available for this lesson.</div>

                        <!-- Lesson content -->
                        <div class="prose max-w-none" v-html="props.currentLesson.content"></div>
                    </div>

                    <!-- Default content when no lesson is selected -->
                    <div v-else-if="props.course" class="py-12 text-center">
                        <div class="space-y-4">
                            <img :src="props.course.image_url" :alt="props.course.name" class="mx-auto h-48 w-auto rounded-lg shadow-lg" />
                            <h1 class="text-3xl font-bold text-gray-900">
                                {{ props.course.name }}
                            </h1>
                            <p class="mx-auto max-w-2xl text-lg text-gray-600">
                                {{ props.course.description }}
                            </p>
                            <p class="text-gray-500">Select a lesson from the sidebar to get started.</p>
                        </div>
                    </div>

                    <!-- Fallback content -->
                    <slot v-else />
                </main>
            </SidebarProvider>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

import CourseSidebar from '@/components/CourseSidebar.vue';
import { SidebarProvider } from '@/components/ui/sidebar';

interface Course {
    id: number | string;
    name: string;
    description: string;
    image_url: string;
    is_completed: boolean;
}

interface Lesson {
    id: number | string;
    title: string;
    index: number;
    audio: string;
    audio_url: string;
    content: string;
    is_completed: boolean;
}

const props = defineProps<{
    course?: Course;
    lessons?: Lesson[];
    currentLesson?: Lesson;
}>();

const breadcrumbs: BreadcrumbItem[] = props.course
    ? [
          {
              title: 'Course',
              href: `/courses/${props.course.id}`,
          },
          ...(props.currentLesson
              ? [
                    {
                        title: props.currentLesson.title,
                        href: `/courses/${props.course.id}/lessons/${props.currentLesson.id}`,
                    },
                ]
              : []),
      ]
    : [];

// Helper function to generate audio URL manually
const getAudioUrl = (audioPath: string): string => {
    if (!audioPath) return '';

    // If already a full URL, return as is
    if (audioPath.startsWith('http')) {
        return audioPath;
    }

    // Generate storage URL manually
    const baseUrl = window.location.origin;
    return `${baseUrl}/storage/${audioPath}`;
};

// Helper function to determine audio MIME type
const getAudioType = (url: string): string => {
    const extension = url.split('.').pop()?.toLowerCase();
    switch (extension) {
        case 'mp3':
            return 'audio/mpeg';
        case 'wav':
            return 'audio/wav';
        case 'ogg':
            return 'audio/ogg';
        case 'm4a':
            return 'audio/mp4';
        case 'aac':
            return 'audio/aac';
        default:
            return 'audio/mpeg'; // Default fallback
    }
};

// Debug functions
const handleAudioError = (event: Event) => {
    console.error('Audio error:', event);
    const audio = event.target as HTMLAudioElement;
    console.error('Audio error details:', {
        error: audio.error,
        networkState: audio.networkState,
        readyState: audio.readyState,
        src: audio.src,
    });
};

const handleAudioLoadStart = () => {
    console.log('Audio load started');
};

const handleAudioCanPlay = () => {
    console.log('Audio can play');
};
</script>
