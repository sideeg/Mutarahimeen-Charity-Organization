<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { Plus, Edit2, Trash2 } from "lucide-vue-next";

defineProps({ slides: Array });

const deleteSlide = (id) => {
    if (confirm("هل أنت متأكد من حذف هذه لافتة الواجهة؟")) {
        router.delete("/admin/hero-slides/" + id);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4"
        >
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    لافتات الواجهة الرئيسية (Hero Slides)
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تعديل الصور والمقولات والروابط الترويجية المعروضة في واجهة
                    الموقع.
                </p>
            </div>
            <Link
                href="/admin/hero-slides/create"
                class="flex items-center gap-2 px-4 py-2.5 bg-orange-500 text-white rounded-lg font-bold text-sm hover:bg-orange-600 transition"
            >
                <Plus class="w-4 h-4" />
                <span>إضافة لافتة جديدة</span>
            </Link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="slide in slides"
                :key="slide.id"
                class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col"
            >
                <div
                    class="aspect-video relative bg-slate-100 border-b border-slate-100"
                >
                    <img
                        :src="slide.image_url"
                        class="w-full h-full object-cover"
                    />
                    <span
                        class="absolute top-3 left-3 px-2 py-1 bg-slate-900/80 text-white font-mono text-[10px] font-bold rounded"
                        >ترتيب: {{ slide.display_order }}</span
                    >
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm mb-1">
                            {{ slide.headline_ar }}
                        </h3>
                        <p class="text-xs text-orange-500 font-semibold mb-2">
                            {{ slide.highlighted_text_ar }}
                        </p>
                        <p class="text-slate-500 text-xs line-clamp-2">
                            {{ slide.subtext_ar }}
                        </p>
                    </div>
                    <div
                        class="flex items-center justify-between border-t border-slate-100 pt-4 mt-4"
                    >
                        <span
                            class="inline-block w-2.5 h-2.5 rounded-full"
                            :class="
                                slide.is_active
                                    ? 'bg-emerald-500'
                                    : 'bg-red-400'
                            "
                        ></span>
                        <div class="flex items-center gap-2">
                            <Link
                                :href="
                                    '/admin/hero-slides/' + slide.id + '/edit'
                                "
                                class="p-2 text-slate-500 hover:text-orange-500 hover:bg-slate-100 rounded-lg transition"
                            >
                                <Edit2 class="w-4 h-4" />
                            </Link>
                            <button
                                @click="deleteSlide(slide.id)"
                                class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition cursor-pointer"
                            >
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
