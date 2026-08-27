<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ArrowRight, Save } from "lucide-vue-next";
import { ref } from "vue";

const props = defineProps({ article: Object });
const isEditing = !!props.article;
const fileInput = ref(null);

const newsPreview = ref(props.article?.cover_image_url || null);

const form = useForm({
    title_ar: props.article?.title_ar || "",
    title_en: props.article?.title_en || "",
    content_ar: props.article?.content_ar || "",
    content_en: props.article?.content_en || "",
    status: props.article?.status || "draft",
    published_at:
        props.article?.published_at || new Date().toISOString().split("T")[0],
    cover_file: null,
});

const handleFile = (e) => {
    const file = e.target.files[0];
    form.cover_file = file;
    if (file) {
        newsPreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    if (isEditing) {
        form.post("/admin/news/" + props.article.id);
    } else {
        form.post("/admin/news");
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <Link
                href="/admin/news"
                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 transition"
            >
                <ArrowRight class="w-5 h-5" />
            </Link>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    {{
                        isEditing
                            ? "تعديل المقال الإخباري"
                            : "إنشاء ونشر مقال إخباري جديد"
                    }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    صياغة الأخبار وإدراج صور التوثيق الصحفي والفعاليات
                    الميدانية.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6 max-w-3xl"
        >
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >تاريخ المقال ونشره *</label
                    >
                    <input
                        type="date"
                        v-model="form.published_at"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                    />
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >حالة المقال والظهور *</label
                    >
                    <select
                        v-model="form.status"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    >
                        <option value="draft">حفظ كمسودة (مخفي)</option>
                        <option value="published">منشور للعامة بالواجهة</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >عنوان الخبر الصحفي (بالعربي) *</label
                    >
                    <input
                        type="text"
                        v-model="form.title_ar"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    />
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >عنوان الخبر الصحفي (بالإنجليزي)</label
                    >
                    <input
                        type="text"
                        v-model="form.title_en"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >صورة واجهة الغلاف والخبر للتقرير الميداني *</label
                    >
                    <input
                        type="file"
                        ref="fileInput"
                        @change="handleFile"
                        :required="!isEditing"
                        accept="image/*"
                        class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-xs focus:outline-none"
                    />
                </div>
                <div
                    class="bg-slate-50 p-2 border border-slate-200 rounded-lg h-fit"
                >
                    <span
                        class="block text-[10px] font-bold text-slate-400 mb-1"
                        >غلاف المقال الحالي</span
                    >
                    <div
                        class="aspect-video bg-white border border-slate-150 rounded overflow-hidden shadow-inner"
                    >
                        <img
                            v-if="newsPreview"
                            :src="newsPreview"
                            class="w-full h-full object-cover"
                        />
                        <div
                            v-else
                            class="w-full h-full flex items-center justify-center text-slate-400 text-[10px]"
                        >
                            لا يوجد غلاف
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100"
            >
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >المحتوى والسياق الخبري (بالعربي) *</label
                    >
                    <textarea
                        v-model="form.content_ar"
                        required
                        rows="10"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                        placeholder="اكتب تفاصيل التقرير الخبري الكامل هنا..."
                    ></textarea>
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >المحتوى والسياق الخبري (بالإنجليزي)</label
                    >
                    <textarea
                        v-model="form.content_en"
                        rows="10"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                        placeholder="Write article details here..."
                    ></textarea>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex items-center gap-2 px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg shadow-sm transition"
                >
                    <Save class="w-4 h-4" />
                    <span>{{
                        form.processing
                            ? "جاري حفظ المقال..."
                            : "نشر المقال الإخباري"
                    }}</span>
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
