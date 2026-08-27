<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ArrowRight, Save } from "lucide-vue-next";
import { ref } from "vue";

const props = defineProps({ slide: Object });
const isEditing = !!props.slide;
const fileInput = ref(null);

const slidePreview = ref(props.slide?.image_url || null);

const form = useForm({
    headline_ar: props.slide?.headline_ar || "",
    headline_en: props.slide?.headline_en || "",
    highlighted_text_ar: props.slide?.highlighted_text_ar || "",
    highlighted_text_en: props.slide?.highlighted_text_en || "",
    subtext_ar: props.slide?.subtext_ar || "",
    subtext_en: props.slide?.subtext_en || "",
    cta_label_ar: props.slide?.cta_label_ar || "",
    cta_label_en: props.slide?.cta_label_en || "",
    cta_url: props.slide?.cta_url || "",
    valid_from: props.slide?.valid_from || "",
    valid_until: props.slide?.valid_until || "",
    display_order: props.slide?.display_order || 0,
    is_active: props.slide ? !!props.slide.is_active : true,
    image_file: null,
});

const handleFile = (e) => {
    const file = e.target.files[0];
    form.image_file = file;
    if (file) {
        slidePreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    if (isEditing) {
        form.post("/admin/hero-slides/" + props.slide.id);
    } else {
        form.post("/admin/hero-slides");
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <Link
                href="/admin/hero-slides"
                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 transition"
            >
                <ArrowRight class="w-5 h-5" />
            </Link>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    {{
                        isEditing
                            ? "تعديل لافتة الواجهة"
                            : "إضافة لافتة واجهة جديدة"
                    }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تحديث محتوى ونصوص البداية المعروضة لزوار الموقع.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6 max-w-3xl"
        >
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Inputs Section -->
                <div class="md:col-span-2 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >العنوان الرئيسي (بالعربي) *</label
                            >
                            <input
                                type="text"
                                v-model="form.headline_ar"
                                required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >العنوان الرئيسي (بالإنجليزي)</label
                            >
                            <input
                                type="text"
                                v-model="form.headline_en"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                                dir="ltr"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >النص المظلل (بالعربي)</label
                            >
                            <input
                                type="text"
                                v-model="form.highlighted_text_ar"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >النص المظلل (بالإنجليزي)</label
                            >
                            <input
                                type="text"
                                v-model="form.highlighted_text_en"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                                dir="ltr"
                            />
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >صورة لافتة العرض الرئيسية *</label
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >النص التعريفي المساعد (بالعربي)</label
                            >
                            <textarea
                                v-model="form.subtext_ar"
                                rows="3"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                            ></textarea>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >النص التعريفي المساعد (بالإنجليزي)</label
                            >
                            <textarea
                                v-model="form.subtext_en"
                                rows="3"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                                dir="ltr"
                            ></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >نص زر الإجراء (بالعربي)</label
                            >
                            <input
                                type="text"
                                v-model="form.cta_label_ar"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                                placeholder="مثال: تبرع الآن"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >نص زر الإجراء (بالإنجليزي)</label
                            >
                            <input
                                type="text"
                                v-model="form.cta_label_en"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                                dir="ltr"
                                placeholder="e.g. Donate Now"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >رابط زر الإجراء (CTA Link)</label
                            >
                            <input
                                type="text"
                                v-model="form.cta_url"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >ترتيب العرض</label
                            >
                            <input
                                type="number"
                                v-model="form.display_order"
                                min="0"
                                step="1"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                            />
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                v-model="form.is_active"
                                class="w-4 h-4 text-orange-500 border-slate-300 rounded focus:ring-orange-500"
                            />
                            <span class="text-sm font-semibold text-slate-700"
                                >تفعيل ظهور اللافتة بالواجهة فوراً</span
                            >
                        </label>
                    </div>
                </div>

                <!-- Live Preview Pane -->
                <div
                    class="bg-slate-50 p-4 border border-slate-200 rounded-xl h-fit space-y-3"
                >
                    <span
                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                        >معاينة اللافتة (Ratio 16:9)</span
                    >
                    <div
                        class="aspect-video w-full rounded-lg overflow-hidden bg-slate-200 border border-slate-300 relative shadow-inner"
                    >
                        <img
                            v-if="slidePreview"
                            :src="slidePreview"
                            class="w-full h-full object-cover"
                        />
                        <div
                            v-else
                            class="w-full h-full flex items-center justify-center text-slate-400 text-xs"
                        >
                            لا توجد صورة مختارة
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex items-center gap-2 px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg shadow-sm transition"
                >
                    <Save class="w-4 h-4" />
                    <span>حفظ البيانات</span>
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
