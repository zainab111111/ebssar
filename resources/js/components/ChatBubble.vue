<script setup>
import { BotMessageSquare, SendHorizontal } from 'lucide-vue-next';
import { nextTick, ref, watch } from 'vue';

// ShadCN-Vue Components
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
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
        content: 'Hello! I can help you.',
    },
]);

// Reference to the scrollable container
const chatContainer = ref(null);
// Reference to track the bottom element
const messagesEnd = ref(null);

// Function to auto-scroll to the bottom
const scrollToBottom = async () => {
    await nextTick();

    setTimeout(() => {
        if (messagesEnd.value) {
            messagesEnd.value.scrollIntoView({
                behavior: 'smooth',
                block: 'end',
            });
        } else if (chatContainer.value) {
            chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
        }
    }, 50);
};

// Watch for new messages and scroll to the bottom
watch(
    messages,
    () => {
        if (isOpen.value) {
            scrollToBottom();
        }
    },
    { deep: true },
);

// Watch when sheet opens
watch(isOpen, (newVal) => {
    if (newVal) {
        setTimeout(() => scrollToBottom(), 200);
    }
});

const handleSubmit = async () => {
    if (!input.value.trim() || isLoading.value) return;

    const userMessage = { role: 'user', content: input.value };
    messages.value.push(userMessage);
    isLoading.value = true;
    input.value = '';

    // Add a placeholder for the assistant's response
    messages.value.push({ role: 'assistant', content: '' });

    try {
        const requestMessages = messages.value.slice(0, -1);

        const response = await fetch('/api/chat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                messages: requestMessages,
                context: props.context,
            }),
        });

        if (!response.body) {
            throw new Error('Response body is null');
        }

        const reader = response.body.getReader();
        const decoder = new TextDecoder();
        let buffer = '';
        let scrollCounter = 0;

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

                        // Throttle scrolling during streaming - every 5th update
                        scrollCounter++;
                        if (scrollCounter % 5 === 0) {
                            scrollToBottom();
                        }
                    }
                } catch (error) {
                    console.error('Failed to parse JSON chunk:', error, 'Chunk:', line);
                }
            }
        }
        // Always scroll at the end
        scrollToBottom();
    } catch (error) {
        console.error('Error during chat stream:', error);
        messages.value[messages.value.length - 1].content = 'Sorry, something went wrong.';
        scrollToBottom();
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

        <!-- Full height flex container -->
        <SheetContent class="flex h-svh max-h-[100svh] flex-col sm:w-[540px]">
            <!-- Header -->
            <SheetHeader class="border-b border-gray-200 px-6 pt-6 pb-4">
                <SheetTitle class="text-xl font-semibold text-gray-800"> Ebssar Teacher </SheetTitle>
                <SheetDescription class="mt-1 text-sm text-gray-600"> Ask me anything! I'm here to help you. </SheetDescription>
            </SheetHeader>

            <!-- Chat body -->
            <div class="relative flex h-svh flex-1 flex-col bg-gray-50 pb-6">
                <div ref="chatContainer" class="flex-1 overflow-x-hidden overflow-y-auto scroll-smooth p-4">
                    <div class="space-y-4 pb-[72px]">
                        <div
                            v-for="(message, index) in messages"
                            :key="index"
                            class="flex items-start gap-3"
                            :class="{ 'justify-end': message.role === 'user' }"
                        >
                            <template v-if="message.role === 'assistant'">
                                <Avatar class="h-8 w-8 flex-shrink-0 border border-gray-300">
                                    <AvatarFallback class="bg-blue-100 text-blue-600">AI</AvatarFallback>
                                </Avatar>
                                <div class="max-w-[80%] rounded-lg bg-white p-3 shadow-sm">
                                    <p class="whitespace-pre-wrap text-gray-800">
                                        {{ message.content }}
                                    </p>
                                </div>
                            </template>
                            <template v-else>
                                <div class="max-w-[80%] rounded-lg bg-blue-500 p-3 shadow-sm">
                                    <p class="whitespace-pre-wrap text-white">
                                        {{ message.content }}
                                    </p>
                                </div>
                                <Avatar class="h-8 w-8 flex-shrink-0 border border-gray-300">
                                    <AvatarFallback class="bg-gray-200 text-gray-600">U</AvatarFallback>
                                </Avatar>
                            </template>
                        </div>

                        <!-- Loading indicator -->
                        <div v-if="isLoading" class="flex items-start gap-3">
                            <Avatar class="h-8 w-8 flex-shrink-0 border border-gray-300">
                                <AvatarFallback class="bg-blue-100 text-blue-600">AI</AvatarFallback>
                            </Avatar>
                            <div class="flex items-center space-x-2 rounded-lg bg-white p-3 shadow-sm">
                                <span class="h-2 w-2 animate-pulse rounded-full bg-blue-500 delay-0"></span>
                                <span class="h-2 w-2 animate-pulse rounded-full bg-blue-500 delay-200"></span>
                                <span class="h-2 w-2 animate-pulse rounded-full bg-blue-500 delay-400"></span>
                            </div>
                        </div>

                        <div ref="messagesEnd" class="h-1"></div>
                    </div>
                </div>

                <!-- Input form (sticky bottom inside sheet) -->
                <div class="sticky bottom-0 border-t border-gray-200 bg-white p-4">
                    <form @submit.prevent="handleSubmit" class="flex items-center gap-2">
                        <Input v-model="input" placeholder="Type your message..." class="flex-1" :disabled="isLoading" />
                        <Button type="submit" :disabled="isLoading || !input.trim()" class="bg-blue-500 text-white hover:bg-blue-600">
                            <SendHorizontal class="h-4 w-4" />
                        </Button>
                    </form>
                </div>
            </div>
        </SheetContent>
    </Sheet>
</template>
