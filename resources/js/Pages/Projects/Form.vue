<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link, router } from "@inertiajs/vue3";
import { ArrowRight, Save, Image, Trash2, Star } from "lucide-vue-next";
import { ref } from "vue";

const props = defineProps({
    categories: Array,
    project: Object,
});

const isEditing = !!props.project;
const fileInput = ref(null);

const newImagePreviews = ref([]);

const form = useForm({
    category_id: props.project?.category_id || "",
    title_ar: props.project?.title_ar || "",
    title_en: props.project?.title_en || "",
    short_description_ar: props.project?.short_description_ar || "",
    short_description_en: props.project?.short_description_en || "",
    full_description_ar: props.project?.full_description_ar || "",
    full_description_en: props.project?.full_description_en || "",
    type: props.project?.type || "sustainable",
    status: props.project?.status || "active",
    target_amount: props.project?.target_amount || 0,
    raised_amount: props.project?.raised_amount || 0,
    beneficiaries_count: props.project?.beneficiaries_count || 0,
    location_ar: props.project?.location_ar || "",
    location_en: props.project?.location_en || "",
    governorate: props.project?.governorate || "",
    is_featured: props.project ? !!props.project.is_featured : false,
    is_active: props.project ? !!props.project.is_active : true,
    media_files: [],
});

const settingCoverId = ref(null);

const handleFilesUpload = (e) => {
    const files = Array.from(e.target.files);
    form.media_files = files;
    newImagePreviews.value = files.map((file) => URL.createObjectURL(file));
};

const deleteExistingMedia = (mediaId) => {
    if (confirm("هل أنت متأكد من رغبتك بحذف هذا الملف المرفق بشكل نهائي؟")) {
        router.delete("/admin/media/" + mediaId, {
            preserveScroll: true,
        });
    }
};

const setCoverImage = (mediaId) => {
    settingCoverId.value = mediaId;
    router.post(
        "/admin/media/" + mediaId + "/set-cover",
        {},
        {
            preserveScroll: true,
            onFinish: () => {
                settingCoverId.value = null;
            },
        }
    );
};

const submit = () => {
    const url = isEditing
        ? "/admin/projects/" + props.project.id
        : "/admin/projects";

    form.post(url, {
        forceFormData: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <Link
                href="/admin/projects"
                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 transition"
            >
                <ArrowRight class="w-5 h-5" />
            </Link>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    {{
                        isEditing ? "تعديل بيانات المشروع" : "إضافة مشروع جديد"
                    }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تحديد التفاصيل المالية والجغرافية والمرفقات البصرية للمشروع.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6"
        >
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >تصنيف المشروع الرئيسي *</label
                    >
                    <select
                        v-model="form.category_id"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    >
                        <option value="" disabled>اختر التصنيف</option>
                        <option
                            v-for="cat in categories"
                            :key="cat.id"
                            :value="cat.id"
                        >
                            {{ cat.name_ar }}
                        </option>
                    </select>
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >اسم المشروع باللغة العربية *</label
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
                        >اسم المشروع باللغة الإنجليزية</label
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
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >نوع المشروع *</label
                    >
                    <select
                        v-model="form.type"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    >
                        <option value="sustainable">مستدام</option>
                        <option value="seasonal">موسمي</option>
                        <option value="relief">إغاثي</option>
                    </select>
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >حالة المشروع التشغيلية *</label
                    >
                    <select
                        v-model="form.status"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    >
                        <option value="active">نشط</option>
                        <option value="completed">مكتمل</option>
                        <option value="paused">موقوف مؤقتاً</option>
                    </select>
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >المستهدف المالي (SDG) *</label
                    >
                    <input
                        type="number"
                        v-model="form.target_amount"
                        required
                        min="0"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left font-mono"
                    />
                </div>
            </div>

            <!-- Media Attachments Panel -->
            <div class="border-t border-b border-slate-100 py-6 my-6">
                <h3
                    class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2"
                >
                    <Image class="w-5 h-5 text-orange-500" />
                    مرفقات ومعرض صور المشروع
                </h3>

                <div v-if="project?.media?.length > 0" class="mb-4">
                    <span class="block text-xs font-bold text-slate-400 mb-2"
                        >الصور المحفوظة حالياً بقاعدة البيانات — اضغط النجمة
                        لتعيين صورة الغلاف:</span
                    >
                    <div
                        class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4"
                    >
                        <div
                            v-for="media in project.media"
                            :key="media.id"
                            class="relative group rounded-lg overflow-hidden border-2 bg-slate-100 aspect-video shadow-sm transition"
                            :class="
                                media.is_cover
                                    ? 'border-orange-500 ring-2 ring-orange-200'
                                    : 'border-slate-200'
                            "
                        >
                            <img
                                :src="media.url"
                                class="w-full h-full object-cover"
                            />

                            <!-- Cover badge, always visible when this is the current cover -->
                            <span
                                v-if="media.is_cover"
                                class="absolute top-1.5 right-1.5 flex items-center gap-1 bg-orange-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow"
                            >
                                <Star class="w-3 h-3 fill-white" />
                                الغلاف
                            </span>

                            <div
                                class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2"
                            >
                                <button
                                    v-if="!media.is_cover"
                                    type="button"
                                    @click="setCoverImage(media.id)"
                                    :disabled="settingCoverId === media.id"
                                    title="تعيين كصورة غلاف"
                                    class="p-2 bg-orange-500 hover:bg-orange-600 text-white rounded-full transition cursor-pointer shadow disabled:opacity-50"
                                >
                                    <Star class="w-4 h-4" />
                                </button>
                                <button
                                    type="button"
                                    @click="deleteExistingMedia(media.id)"
                                    title="حذف الصورة"
                                    class="p-2 bg-red-600 hover:bg-red-700 text-white rounded-full transition cursor-pointer shadow"
                                >
                                    <Trash2 class="w-4 h-4" />
                                </button>
                            </div>
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
                        اختر صوراً جديدة لتحميلها للمشروع
                    </button>
                    <p class="text-[11px] text-slate-400 mt-2">
                        بإمكانك اختيار صور متعددة معاً (JPG, PNG). أول صورة سيتم
                        رفعها ستصبح صورة الغلاف تلقائياً إذا لم يوجد غلاف
                        حالياً.
                    </p>

                    <div
                        v-if="newImagePreviews.length > 0"
                        class="mt-6 border-t border-slate-200 pt-4"
                    >
                        <span
                            class="block text-xs font-bold text-slate-500 text-right mb-2"
                            >معاينة الملفات المحددة للرفع الآن:</span
                        >
                        <div
                            class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-3"
                        >
                            <div
                                v-for="(preview, idx) in newImagePreviews"
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
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >المبلغ المجموع المؤكد حالياً (SDG)</label
                    >
                    <input
                        type="number"
                        v-model="form.raised_amount"
                        min="0"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left font-mono"
                    />
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >عدد المستفيدين التقريبي</label
                    >
                    <input
                        type="number"
                        v-model="form.beneficiaries_count"
                        min="0"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                    />
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الموقع (بالعربي)</label
                    >
                    <input
                        type="text"
                        v-model="form.location_ar"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    />
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الموقع (بالإنجليزي)</label
                    >
                    <input
                        type="text"
                        v-model="form.location_en"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الولاية الجغرافية</label
                    >
                    <input
                        type="text"
                        v-model="form.governorate"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    />
                </div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100"
            >
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الوصف المختصر المساعد (بالعربي) *</label
                    >
                    <textarea
                        v-model="form.short_description_ar"
                        required
                        rows="2"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    ></textarea>
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الوصف المختصر المساعد (بالإنجليزي)</label
                    >
                    <textarea
                        v-model="form.short_description_en"
                        rows="2"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    ></textarea>
                </div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100"
            >
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >تفاصيل المشروع والتقرير الوصفي الكامل (بالعربي)
                        *</label
                    >
                    <textarea
                        v-model="form.full_description_ar"
                        required
                        rows="5"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    ></textarea>
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >تفاصيل المشروع والتقرير الوصفي الكامل
                        (بالإنجليزي)</label
                    >
                    <textarea
                        v-model="form.full_description_en"
                        rows="5"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    ></textarea>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex items-center gap-2 px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg shadow-sm transition cursor-pointer"
                >
                    <Save class="w-4 h-4" />
                    <span>{{
                        form.processing
                            ? "جاري الحفظ..."
                            : "حفظ التغييرات والمشروع"
                    }}</span>
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
