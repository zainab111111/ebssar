<script setup>
import { BotMessageSquare, SendHorizontal } from 'lucide-vue-next';
import { nextTick, ref, watch } from 'vue';

// ShadCN-Vue Components
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Sheet, SheetContent, SheetDescription, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';

// Component Props
const props = defineProps({
    context: {
        type: String,
        default: '',
    },
});

// Component State
const isOpen = ref(false);
const input = ref('');
const isLoading = ref(false);
const messages = ref([
    {
        role: 'assistant',
        content: 'Hello! I can help answer questions based on the provided context.',
    },
]);
const scrollArea = ref(null);

// Function to auto-scroll to the bottom
const scrollToBottom = async () => {
    await nextTick();
    const scrollEl = scrollArea.value;
    if (scrollEl) {
        const viewport = scrollEl.querySelector('[data-radix-scroll-area-viewport]');
        if (viewport) {
            viewport.scrollTop = viewport.scrollHeight;
        }
    }
};

// Watch for new messages and scroll to the bottom
watch(
    messages,
    () => {
        scrollToBottom();
    },
    { deep: true },
);

const handleSubmit = async () => {
    if (!input.value.trim() || isLoading.value) return;

    const userMessage = { role: 'user', content: input.value };
    messages.value.push(userMessage);
    isLoading.value = true;
    input.value = '';

    // Add a placeholder for the assistant's response
    messages.value.push({ role: 'assistant', content: '' });
    scrollToBottom();

    try {
        // Include system message with user messages
        const requestMessages = messages.value.slice(0, -1); // Just the conversation history

        const response = await fetch('/api/chat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ messages: requestMessages, context: props.context }),
        });

        if (!response.body) {
            throw new Error('Response body is null');
        }

        const reader = response.body.getReader();
        const decoder = new TextDecoder();
        let buffer = '';

        while (true) {
            const { done, value } = await reader.read();
            if (done) break;

            buffer += decoder.decode(value, { stream: true });
            const lines = buffer.split('\n');
            buffer = lines.pop() || '';

            for (const line of lines) {
                if (!line.trim()) continue;
                try {
                    const parsed = JSON.parse(line);
                    if (parsed.message && parsed.message.content) {
                        messages.value[messages.value.length - 1].content += parsed.message.content;
                        scrollToBottom();
                    }
                } catch (error) {
                    console.error('Failed to parse JSON chunk:', error, 'Chunk:', line);
                }
            }
        }
    } catch (error) {
        console.error('Error during chat stream:', error);
        messages.value[messages.value.length - 1].content = 'Sorry, something went wrong.';
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <Sheet v-model:open="isOpen">
        <SheetTrigger as-child>
            <Button variant="outline" class="fixed right-6 bottom-6 h-14 w-14 rounded-full p-4 shadow-lg">
                <BotMessageSquare class="h-8 w-8" />
            </Button>
        </SheetTrigger>
        <SheetContent class="flex h-svh flex-col sm:w-[540px]">
            <SheetHeader class="border-b border-gray-200 px-6 pt-6 pb-4">
                <SheetTitle class="text-xl font-semibold text-gray-800">AI Assistant</SheetTitle>
                <SheetDescription class="mt-1 text-sm text-gray-600">Ask me anything! I'm powered by a local Ollama model.</SheetDescription>
            </SheetHeader>
            <div class="flex flex-1 flex-col bg-gray-50 p-4">
                <ScrollArea ref="scrollArea" class="flex-1 overflow-hidden">
                    <div class="space-y-4">
                        <div
                            v-for="(message, index) in messages"
                            :key="index"
                            class="flex items-start gap-3"
                            :class="{ 'justify-end': message.role === 'user' }"
                        >
                            <template v-if="message.role === 'assistant'">
                                <Avatar class="h-8 w-8 border border-gray-300">
                                    <AvatarFallback class="bg-blue-100 text-blue-600">AI</AvatarFallback>
                                </Avatar>
                                <div class="max-w-[80%] rounded-lg bg-white p-3 shadow-sm">
                                    <p class="text-gray-800">{{ message.content }}</p>
                                </div>
                            </template>
                            <template v-else>
                                <div class="max-w-[80%] rounded-lg bg-blue-500 p-3 shadow-sm">
                                    <p class="text-white">{{ message.content }}</p>
                                </div>
                                <Avatar class="h-8 w-8 border border-gray-300">
                                    <AvatarFallback class="bg-gray-200 text-gray-600">U</AvatarFallback>
                                </Avatar>
                            </template>
                        </div>
                        <div v-if="isLoading" class="flex items-start gap-3">
                            <Avatar class="h-8 w-8 border border-gray-300">
                                <AvatarFallback class="bg-blue-100 text-blue-600">AI</AvatarFallback>
                            </Avatar>
                            <div class="flex items-center space-x-2 rounded-lg bg-white p-3 shadow-sm">
                                <span class="h-2 w-2 animate-pulse rounded-full bg-blue-500 delay-0"></span>
                                <span class="h-2 w-2 animate-pulse rounded-full bg-blue-500 delay-200"></span>
                                <span class="h-2 w-2 animate-pulse rounded-full bg-blue-500 delay-400"></span>
                            </div>
                        </div>
                    </div>
                </ScrollArea>
                <form @submit.prevent="handleSubmit" class="mt-4 flex items-center gap-2 border-t border-gray-200 bg-white p-4">
                    <Input v-model="input" placeholder="Type your message..." class="flex-1" :disabled="isLoading" />
                    <Button type="submit" :disabled="isLoading" class="bg-blue-500 text-white hover:bg-blue-600">
                        <SendHorizontal class="h-4 w-4" />
                    </Button>
                </form>
            </div>
        </SheetContent>
    </Sheet>
</template>

<style scoped>
/* Additional custom styles */
</style>
