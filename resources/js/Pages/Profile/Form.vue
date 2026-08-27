<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { Save, Building, Image as ImageIcon } from "lucide-vue-next";
import { ref } from "vue";

const props = defineProps({ profile: Object });
const logoInput = ref(null);
const aboutImgInput = ref(null);
const volunteerImgInput = ref(null);

// Reactive previews
const logoPreview = ref(props.profile?.logo_url || null);
const aboutPreview = ref(props.profile?.about_image_url || null);
const volunteerPreview = ref(props.profile?.volunteer_image_url || null);

const form = useForm({
    name_ar: props.profile?.name_ar || "",
    name_en: props.profile?.name_en || "",
    about_text_ar: props.profile?.about_text_ar || "",
    about_text_en: props.profile?.about_text_en || "",
    vision_ar: props.profile?.vision_ar || "",
    vision_en: props.profile?.vision_en || "",
    mission_ar: props.profile?.mission_ar || "",
    mission_en: props.profile?.mission_en || "",
    marketing_message_ar: props.profile?.marketing_message_ar || "",
    marketing_message_en: props.profile?.marketing_message_en || "",
    email: props.profile?.email || "",
    phone: props.profile?.phone || "",
    whatsapp_link: props.profile?.whatsapp_link || "",
    address_ar: props.profile?.address_ar || "",
    address_en: props.profile?.address_en || "",
    logo_file: null,
    about_image_file: null,
    volunteer_image_file: null,
});

const handleFile = (e) => {
    const file = e.target.files[0];
    form.logo_file = file;
    if (file) {
        logoPreview.value = URL.createObjectURL(file);
    }
};

const handleAboutFile = (e) => {
    const file = e.target.files[0];
    form.about_image_file = file;
    if (file) {
        aboutPreview.value = URL.createObjectURL(file);
    }
};

const handleVolunteerFile = (e) => {
    const file = e.target.files[0];
    form.volunteer_image_file = file;
    if (file) {
        volunteerPreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    form.post("/admin/profile");
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <div
                class="p-2.5 bg-white border border-slate-200 rounded-lg text-slate-600"
            >
                <Building class="w-6 h-6 text-orange-500" />
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    الملف التعريفي والبيانات العامة للمنظمة
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تحديث شعار المنظمة، الرؤية والرسالة، ومعلومات التواصل
                    والتسويق.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-8"
        >
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >اسم المنظمة باللغة العربية *</label
                    >
                    <input
                        type="text"
                        v-model="form.name_ar"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    />
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >اسم المنظمة باللغة الإنجليزية</label
                    >
                    <input
                        type="text"
                        v-model="form.name_en"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    />
                </div>
            </div>

            <!-- Branding Images Preview Panel -->
            <div class="border-t border-b border-slate-100 py-6 space-y-6">
                <h3
                    class="text-sm font-bold text-slate-800 flex items-center gap-2"
                >
                    <ImageIcon class="w-5 h-5 text-orange-500" />
                    معاينة وإدارة الصور العامة للموقع
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Shogo / Logo Upload with Preview -->
                    <div
                        class="bg-slate-50 p-4 border border-slate-200 rounded-lg flex flex-col justify-between"
                    >
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-700 mb-2"
                                >شعار المنظمة (Logo)</label
                            >
                            <input
                                type="file"
                                ref="logoInput"
                                @change="handleFile"
                                accept="image/*"
                                class="w-full px-2 py-1 bg-white border border-slate-200 rounded text-slate-800 text-xs focus:outline-none mb-4"
                            />
                        </div>
                        <div
                            class="aspect-video w-full bg-white border border-slate-100 rounded-lg flex items-center justify-center p-3 shadow-inner"
                        >
                            <img
                                v-if="logoPreview"
                                :src="logoPreview"
                                class="max-h-full max-w-full object-contain"
                            />
                            <span v-else class="text-[11px] text-slate-400"
                                >لا يوجد شعار متاح</span
                            >
                        </div>
                    </div>

                    <!-- About Cover with Preview -->
                    <div
                        class="bg-slate-50 p-4 border border-slate-200 rounded-lg flex flex-col justify-between"
                    >
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-700 mb-2"
                                >صورة لافتة "عن المنظمة"</label
                            >
                            <input
                                type="file"
                                ref="aboutImgInput"
                                @change="handleAboutFile"
                                accept="image/*"
                                class="w-full px-2 py-1 bg-white border border-slate-200 rounded text-slate-800 text-xs focus:outline-none mb-4"
                            />
                        </div>
                        <div
                            class="aspect-video w-full rounded-lg overflow-hidden border border-slate-150 shadow-inner"
                        >
                            <img
                                v-if="
                                    form.about_image_file ||
                                    profile?.about_image_url
                                "
                                :src="
                                    form.about_image_file
                                        ? URL.createObjectURL(
                                              form.about_image_file
                                          )
                                        : profile.about_image_url
                                "
                                class="w-full h-full object-cover"
                            />
                            <div
                                v-else
                                class="w-full h-full flex items-center justify-center text-slate-400 text-xs"
                            >
                                لا يوجد غلاف تعريف حالياً
                            </div>
                        </div>
                    </div>

                    <!-- Volunteer Cover with Preview -->
                    <div>
                        <div
                            class="bg-slate-50 border border-slate-200 p-4 rounded-lg flex flex-col h-full justify-between"
                        >
                            <div>
                                <label
                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                    >صورة قسم التطوع</label
                                >
                                <input
                                    type="file"
                                    ref="volunteerImgInput"
                                    @change="handleVolunteerFile"
                                    accept="image/*"
                                    class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-xs focus:outline-none"
                                />
                            </div>
                            <div
                                class="aspect-video w-full overflow-hidden rounded-lg mt-3 border border-slate-150"
                            >
                                <img
                                    v-if="
                                        profile?.volunteer_image_url ||
                                        form.volunteer_image_file
                                    "
                                    :src="
                                        form.volunteer_image_file
                                            ? URL.createObjectURL(
                                                  form.volunteer_image_file
                                              )
                                            : profile.volunteer_image_url
                                    "
                                    class="w-full h-full object-cover"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center text-slate-400 text-xs"
                                >
                                    لا توجد صورة تطوع حالية
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >البريد الإلكتروني الرسمي</label
                    >
                    <input
                        type="email"
                        v-model="form.email"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    />
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >رقم الهاتف الرسمي</label
                    >
                    <input
                        type="tel"
                        v-model="form.phone"
                        pattern="[0-9]{9,15}"
                        title="يرجى إدخال رقم هاتف صحيح يتكون من 9 إلى 15 رقماً بدون رموز."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    />
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >رابط واتساب للتواصل السريع</label
                    >
                    <input
                        type="url"
                        v-model="form.whatsapp_link"
                        placeholder="https://wa.me/..."
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
                        >العنوان الميداني باللغة العربية</label
                    >
                    <input
                        type="text"
                        v-model="form.address_ar"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                        placeholder="مثال: الخرطوم، السودان"
                    />
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >العنوان الميداني باللغة الإنجليزية</label
                    >
                    <input
                        type="text"
                        v-model="form.address_en"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                        placeholder="e.g. Khartoum, Sudan"
                    />
                </div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100"
            >
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الرسالة التسويقية باللغة العربية</label
                    >
                    <input
                        type="text"
                        v-model="form.marketing_message_ar"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                        placeholder="مثال: كن ظلاً للخير يمتد أبداً"
                    />
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الرسالة التسويقية باللغة الإنجليزية</label
                    >
                    <input
                        type="text"
                        v-model="form.marketing_message_en"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                        placeholder="e.g. Be a shade of goodness that extends forever"
                    />
                </div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100"
            >
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >حول المنظمة (بالعربي)</label
                    >
                    <textarea
                        v-model="form.about_text_ar"
                        rows="4"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    ></textarea>
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >حول المنظمة (بالإنجليزي)</label
                    >
                    <textarea
                        v-model="form.about_text_en"
                        rows="4"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    ></textarea>
                </div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-slate-100 pt-6"
            >
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الرؤية (بالعربي)</label
                    >
                    <textarea
                        v-model="form.vision_ar"
                        rows="3"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    ></textarea>
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الرؤية (بالإنجليزي)</label
                    >
                    <textarea
                        v-model="form.vision_en"
                        rows="3"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    ></textarea>
                </div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-slate-100 pt-6"
            >
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الرسالة (بالعربي)</label
                    >
                    <textarea
                        v-model="form.mission_ar"
                        rows="3"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    ></textarea>
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الرسالة (بالإنجليزي)</label
                    >
                    <textarea
                        v-model="form.mission_en"
                        rows="3"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
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
                            ? "جاري الحفظ..."
                            : "حفظ التحديثات والمواصفات العامة"
                    }}</span>
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
