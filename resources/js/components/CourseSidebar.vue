<script setup lang="ts">
import {
    Sidebar,
    SidebarContent,
    SidebarGroup,
    SidebarGroupContent,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { router } from '@inertiajs/vue3';
import { CheckCircle, Milestone } from 'lucide-vue-next';

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
    audio_url: string;
    content: string;
    is_completed: boolean;
}

const props = defineProps<{
    course?: Course;
    lessons?: Lesson[];
    currentLesson?: Lesson;
}>();

// Menu items with active state
const items = props.lessons?.map((item) => ({
    title: item.title,
    url: `/courses/${props.course?.id}/lessons/${item.id}`,
    icon: item.is_completed ? CheckCircle : Milestone,
    isActive: props.currentLesson?.id === item.id,
    isCompleted: item.is_completed,
}));

const handleLessonClick = (url: string, event: Event) => {
    event.preventDefault();
    //TODO: set is_completed to true
    router.get(url);
};
</script>

<template>
    <Sidebar variant="sidebar">
        <SidebarHeader>
            <div class="flex flex-col items-center gap-2 p-4">
                <img :src="props.course?.image_url" alt="Course image" loading="lazy" class="aspect-video w-full rounded object-cover" />
                <h2 class="text-center text-sm font-semibold">
                    {{ props.course?.name }}
                </h2>
            </div>
        </SidebarHeader>
        <SidebarContent>
            <SidebarGroup>
                <SidebarGroupContent>
                    <SidebarMenu>
                        <SidebarMenuItem v-for="item in items" :key="item.title">
                            <SidebarMenuButton
                                :class="{
                                    'bg-accent text-accent-foreground': item.isActive,
                                    'text-green-600': item.isCompleted && !item.isActive,
                                }"
                                @click="(event: Event) => handleLessonClick(item.url, event)"
                            >
                                <component
                                    :is="item.icon"
                                    :class="{
                                        'text-green-600': item.isCompleted,
                                    }"
                                />
                                <span>{{ item.title }}</span>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>
    </Sidebar>
</template>
