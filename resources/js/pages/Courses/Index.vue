<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
const props = defineProps({
    courses: Array<any>,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Courses',
        href: '/courses',
    },
];
</script>

<template>

    <Head title="Courses" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div dir="rtl" class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div v-for="course in props.courses" :key="course.id"
                    class="relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <Card>
                        <CardHeader>
                            <CardTitle class="">
                                <img :src="course.image_url || course.image" :alt="course.name" loading="lazy"
                                    class="aspect-video rounded" />
                            </CardTitle>
                            <CardDescription>{{ course.description }}</CardDescription>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-2">
                            {{ course.name }}
                            <Button class="w-full">
                                <Link class="w-full" :href="route('courses.show', course.id)"> ابدأ التعلم </Link>
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
