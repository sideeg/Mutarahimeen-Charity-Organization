<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { Plus, Edit2, Trash2 } from "lucide-vue-next";

defineProps({ articles: Array });

const deleteArticle = (id) => {
    if (confirm("هل أنت متأكد من رغبتك بحذف هذا المقال الإخباري؟")) {
        router.delete("/admin/news/" + id);
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
                    الأخبار والفعاليات الجارية (News Articles)
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تعديل ونشر مقالات ومطبوعات الجمعية الإعلامية وتوثيق الأنشطة
                    بالصور.
                </p>
            </div>
            <Link
                href="/admin/news/create"
                class="flex items-center gap-2 px-4 py-2.5 bg-orange-500 text-white rounded-lg font-bold text-sm hover:bg-orange-600 transition"
            >
                <Plus class="w-4 h-4" />
                <span>إنشاء مقال جديد</span>
            </Link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="art in articles"
                :key="art.id"
                class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col"
            >
                <div
                    class="aspect-video relative bg-slate-100 border-b border-slate-100"
                >
                    <img
                        :src="art.cover_image_url"
                        class="w-full h-full object-cover"
                    />
                    <span
                        class="absolute top-3 left-3 px-3 py-1 text-[10px] font-bold rounded-full"
                        :class="
                            art.status === 'published'
                                ? 'bg-emerald-100 text-emerald-800'
                                : 'bg-amber-100 text-amber-800'
                        "
                    >
                        {{ art.status === "published" ? "منشور" : "مسودة" }}
                    </span>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3
                            class="font-bold text-slate-800 text-sm mb-2 line-clamp-2"
                        >
                            {{ art.title_ar }}
                        </h3>
                        <p class="text-slate-400 text-[10px] font-mono">
                            تاريخ النشر: {{ art.published_at }}
                        </p>
                    </div>
                    <div
                        class="flex items-center justify-end border-t border-slate-100 pt-4 mt-4 gap-2"
                    >
                        <Link
                            :href="'/admin/news/' + art.id + '/edit'"
                            class="p-2 text-slate-500 hover:text-orange-500 hover:bg-slate-100 rounded-lg transition"
                        >
                            <Edit2 class="w-4 h-4" />
                        </Link>
                        <button
                            @click="deleteArticle(art.id)"
                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition cursor-pointer"
                        >
                            <Trash2 class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
