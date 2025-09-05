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
import { Milestone } from 'lucide-vue-next';

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

// Menu items.
const items = props.lessons?.map((item) => ({
    title: item.title,
    url: `/courses/${props.course?.id}/lessons/${item.id}`,
    icon: Milestone,
}));
</script>

<template>
    <Sidebar>
        <SidebarHeader>
            <SidebarHeaderTitle>
                <div class="flex flex-col items-center gap-2">
                    <img :src="props.course?.image_url" alt="Course image" loading="lazy"
                        class="aspect-video rounded" />
                    {{ props.course?.name }}
                </div>
            </SidebarHeaderTitle>
        </SidebarHeader>
        <SidebarContent>
            <SidebarGroup>
                <SidebarGroupContent>
                    <SidebarMenu>
                        <SidebarMenuItem v-for="item in items" :key="item.title">
                            <SidebarMenuButton asChild>
                                <a :href="item.url">
                                    <component :is="item.icon" />
                                    <span>{{ item.title }}</span>
                                </a>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>
    </Sidebar>
</template>
