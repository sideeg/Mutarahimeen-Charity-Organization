<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ArrowRight, Save } from "lucide-vue-next";
import { ref } from "vue";

const props = defineProps({
    projects: Array,
    update: Object,
});

const isEditing = !!props.update;
const fileInput = ref(null);

const updateImagePreviews = ref([]);

const form = useForm({
    project_id: props.update?.project_id || "",
    title_ar: props.update?.title_ar || "",
    title_en: props.update?.title_en || "",
    content_ar: props.update?.content_ar || "",
    content_en: props.update?.content_en || "",
    admin_notes: props.update?.admin_notes || "",
    published_date:
        props.update?.published_date || new Date().toISOString().split("T")[0],
    media_files: [],
});

const handleFilesUpload = (e) => {
    const files = Array.from(e.target.files);
    form.media_files = files;
    updateImagePreviews.value = files.map((file) => URL.createObjectURL(file));
};

const submit = () => {
    if (isEditing) {
        form.post("/admin/updates/" + props.update.id);
    } else {
        form.post("/admin/updates");
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <Link
                href="/admin/updates"
                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 transition"
            >
                <ArrowRight class="w-5 h-5" />
            </Link>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    {{
                        isEditing
                            ? "تعديل التقرير الميداني"
                            : "إضافة تقرير ميداني جديد للمشروع"
                    }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    إضافة صور التوثيق والتفاصيل الإجرائية لتطور التنفيذ.
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
                        >المشروع المستهدف بالتقرير *</label
                    >
                    <select
                        v-model="form.project_id"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    >
                        <option value="" disabled>اختر المشروع</option>
                        <option
                            v-for="proj in projects"
                            :key="proj.id"
                            :value="proj.id"
                        >
                            {{ proj.title_ar }}
                        </option>
                    </select>
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >تاريخ التحديث الميداني *</label
                    >
                    <input
                        type="date"
                        v-model="form.published_date"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >عنوان التقرير التنفيذي (بالعربي) *</label
                    >
                    <input
                        type="text"
                        v-model="form.title_ar"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                        placeholder="مثال: اكتمال حفر البئر وتركيب المضخة الشمسية"
                    />
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >عنوان التقرير التنفيذي (بالإنجليزي)</label
                    >
                    <input
                        type="text"
                        v-model="form.title_en"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    />
                </div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100"
            >
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >تفاصيل وسياق الإنجاز الميداني (بالعربي) *</label
                    >
                    <textarea
                        v-model="form.content_ar"
                        required
                        rows="6"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    ></textarea>
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >تفاصيل وسياق الإنجاز الميداني (بالإنجليزي)</label
                    >
                    <textarea
                        v-model="form.content_en"
                        rows="6"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    ></textarea>
                </div>
            </div>

            <div v-if="update?.media_urls?.length > 0" class="mb-4">
                <span class="block text-xs font-bold text-slate-400 mb-2"
                    >الصور المحفوظة مسبقاً بهذا التحديث:</span
                >
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div
                        v-for="(url, idx) in update.media_urls"
                        :key="idx"
                        class="rounded-lg overflow-hidden border border-slate-200 aspect-video"
                    >
                        <img :src="url" class="w-full h-full object-cover" />
                    </div>
                </div>
            </div>

            <div
                class="p-6 border-2 border-dashed border-slate-200 rounded-lg bg-slate-50 text-center"
            >
                <input
                    type="file"
                    ref="fileInput"
                    @change="handleFilesUpload"
                    multiple
                    accept="image/*"
                    class="hidden"
                />
                <button
                    type="button"
                    @click="$refs.fileInput.click()"
                    class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 rounded-lg font-semibold text-xs cursor-pointer shadow-sm"
                >
                    تحميل صور الميدان المرفقة بالتقرير
                </button>
                <p class="text-[11px] text-slate-400 mt-2">
                    يمكنك اختيار صور متعددة معا بالضغط المطول وتحديدها دفعة
                    واحدة
                </p>

                <div
                    v-if="updateImagePreviews.length > 0"
                    class="mt-6 border-t border-slate-200 pt-4"
                >
                    <span
                        class="block text-xs font-bold text-slate-500 text-right mb-2"
                        >معاينة الصور المختارة للرفع:</span
                    >
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div
                            v-for="(preview, idx) in updateImagePreviews"
                            :key="idx"
                            class="rounded-lg overflow-hidden border border-slate-300 bg-slate-200 aspect-video shadow-inner"
                        >
                            <img
                                :src="preview"
                                class="w-full h-full object-cover"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2"
                    >ملاحظات إدارية (داخلية)</label
                >
                <textarea
                    v-model="form.admin_notes"
                    rows="2"
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                ></textarea>
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
                            ? "جاري حفظ التقرير..."
                            : "حفظ ونشر التقرير الميداني"
                    }}</span>
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
