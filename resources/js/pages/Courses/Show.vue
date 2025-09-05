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
    content: string;
    is_completed: boolean;
}

const props = defineProps<{
    course?: Course;
    lessons?: Lesson[];
}>();

const breadcrumbs: BreadcrumbItem[] = props.course
    ? [
        {
            title: 'Course',
            href: `/courses/${props.course.id}`,
        },
    ]
    : [];
</script>

<template>

    <Head :title="props.course ? `${props.course.name} - Courses` : 'Courses'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <SidebarProvider>
                <CourseSidebar :course="props.course" :lessons="props.lessons" />
                <main>
                    <slot />
                </main>
            </SidebarProvider>
        </div>
    </AppLayout>
</template>
